<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;
use Illuminate\Filesystem\Filesystem;

class MatrixController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'only' => [
                'getIndex',
                'getLock',
                'getUser',
                'getMenu',
                'getLogout',
            ]
        ]);
    }

    /**
     * 模板首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        return view('matrix.index');
    }

    /**
     * 模板头部
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getHeader()
    {
        return view('matrix.header');
    }

    /**
     * 模板底部
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFooter()
    {
        return view('matrix.footer');
    }

    /**
     * 模板左侧菜单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAside()
    {
        return view('matrix.menu');
    }

    /**
     * 模板路由映射
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getMap()
    {
        return view('matrix.map');
    }

    /**
     * 模板404页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEmpty()
    {
        return view('matrix.404');
    }

    /**
     * 模板500页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getError()
    {
        return view('matrix.500');
    }

    /**
     * 模板登录页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        return view('matrix.login');
    }

    /**
     * 模板注册页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRegister()
    {
        return view('matrix.register');
    }

    /**
     * 模板锁屏页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLock()
    {
        return view('matrix.lock');
    }

    // ==============  以下为接口功能 ====================

    /**
     * 获取用户对应左侧菜单数据
     * @return mixed
     */
    public function getUser()
    {
        return Auth::user();
    }

    /**
     * 获取用户对应左侧菜单数据
     * @return mixed
     */
    public function getMenu(Filesystem $filesystem)
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
            // 菜单路由根据命名空间生成
            $namespace = trim(collect(array_get($item, 'autoload.psr-4', []))->keys()->first(), '\\');
            $namespace = explode('\\', $namespace);
            $url = count($namespace) > 2 ? snake_case($namespace[1]) . '/' . snake_case($namespace[2]) : '#';

            // 生成链接
            array_set($item, 'extra.plugin.menu.url', $url);

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
    public function getCheck(Request $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        if (!in_array($field, ['email', 'name'])) return abort(404);

        $count = User::where($field, $value)->count();
        return ['exists' => $count > 0];
    }

    /**
     * 用户注册
     * @return static
     */
    public function postRegister(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        return $this->postLogin($request);
    }

    /**
     * 用户登录
     * @return mixed
     */
    public function postLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember', true);

        $result = Auth::attempt(['email' => $email, 'password' => $password], $remember);
        return $result ? Auth::user() : abort(404);
    }

    /**
     * 注销登录
     * @return mixed
     */
    public function getLogout()
    {
        return Auth::logout();
    }
}
