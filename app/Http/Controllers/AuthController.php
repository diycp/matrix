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

        $collect = collect($installed)->where('type', 'matrix-plugin')->filter(function ($item) {
            // 过滤不显示菜单的插件
            return array_get($item, 'extra.plugin.menu.status', true);
        });

        $groups = $collect->pluck('extra.plugin.menu.group')->toArray();
        $prepend = [];

        $collect->sortBy('time')->each(function ($item) use ($groups, &$prepend) {
            $group = array_get($item, 'extra.plugin.menu.group');
            $icons = array_get($item, 'extra.plugin.menu.group-icons');
            $groupSplit = explode('|', $group);
            $iconsSplit = explode('|', $icons);
            for ($i = count($groupSplit); $i > 1; $i--) {
                $name = array_pop($groupSplit);
                $group = implode('|', $groupSplit);
                $icon = array_pop($iconsSplit);
                $icons = implode('|', $iconsSplit);

                if (!in_array($group, $groups)) {
                    array_push($prepend, [
                        'group' => $group,
                        'name' => $name,
                        'icon' => $icon,
                        'group-icons' => $icons,
                    ]);
                }
            }
        });

        $menus = $collect->map(function ($item) use ($groups) {

            // 生成链接
            array_set($item, 'extra.plugin.menu.url', str_replace(['matrix-plugin-', 'matrix-'], '', $item['name']));

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
            ->sortBy('time')
            ->pluck('extra.plugin.menu');

        return collect($prepend)->merge($menus)->all();
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
