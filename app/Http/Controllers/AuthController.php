<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Menu;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->middleware('auth', ['except' => ['check', 'login', 'register']]);

        $this->request = $request;
    }

    /**
     * 获取用户对应左侧菜单数据
     * @return mixed
     */
    public function showUser()
    {
        return Auth::user();
    }

    /**
     * 获取用户对应左侧菜单数据
     * @return mixed
     */
    public function showMenu()
    {
        return Menu::orderBy('order_by', 'asc')->orderBy('updated_at', 'asc')->get();
    }

    /**
     * 验证是否存在
     * @return mixed
     */
    public function check()
    {
        $field = $this->request->input('field');
        $value = $this->request->input('value');

        if (!in_array($field, ['email', 'name'])) return abort(404);

        $count = User::where($field, $value)->count();
        return ['exists' => $count > 0];
    }

    /**
     * 用户注册
     * @return static
     */
    public function register()
    {
        $name = $this->request->input('name');
        $email = $this->request->input('email');
        $password = $this->request->input('password');

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        return $this->login();
    }

    /**
     * 用户登录
     * @return mixed
     */
    public function login()
    {
        $email = $this->request->input('email');
        $password = $this->request->input('password');
        $remember = $this->request->input('remember', false);

        $result = Auth::attempt(['email' => $email, 'password' => $password], $remember);
        return $result ? Auth::user() : abort(404);
    }

    /**
     * 注销登录
     * @return mixed
     */
    public function logout()
    {
        return Auth::logout();
    }
}
