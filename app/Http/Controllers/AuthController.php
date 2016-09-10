<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Menu;
use App\Models\User;
use Auth;
use Illuminate\Filesystem\Filesystem;

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
    public function showMenu(Filesystem $filesystem)
    {
        // 获取插件列表
        $installed = json_decode($filesystem->get(base_path('vendor/composer/installed.json')), true);

        return collect($installed)
            ->where('type', 'laa-plugin')
            ->map(function ($item) {
                // 生成链接
                array_set($item, 'extra.plugin.menu.url', str_replace(['laa-plugin-', 'laa-'], '', $item['name']));

                // 24小时内安装的菜单显示new标签
                if (strtotime($item['time'] . '+ 1 day') > time()) {
                    $new = [
                        'class' => 'bg-green',
                        'text' => 'new'
                    ];
                    if (array_get($item, 'extra.plugin.menu.right')) {
                        array_prepend($item, $new);
                    } else {
                        array_set($item, 'extra.plugin.menu.right', [$new]);
                    }
                }

                return $item;
            })
            ->sortByDesc('time')
            ->pluck('extra.plugin.menu')
            ->all();
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
