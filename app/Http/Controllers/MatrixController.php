<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;
use Illuminate\Filesystem\Filesystem;
use Identicon\Identicon;

class MatrixController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'only' => [
                'getAuth',
                'getMenu',
                'getLogout',
            ]
        ]);
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
     * 获取用户信息
     * @return mixed
     */
    public function getAuth()
    {
        $identicon = new Identicon();

        $user = Auth::user();
        $user->head = $identicon->getImageDataUri(substr($user->email, 0, 3), 90, rand(777777, 999999));
        return $user;
    }

    /**
     * 获取用户对应左侧菜单数据
     * @return mixed
     */
    public function getMenu(Filesystem $filesystem)
    {
        // 获取插件列表
        $installed = json_decode($filesystem->get(base_path('vendor/composer/installed.json')), true);

        // 合并本地插件
        $pluginFiles = $filesystem->glob(base_path('matrix/*/{composer.json,*/composer.json,*/*/composer.json,*/*/*/composer.json,*/*/*/*/composer.json}'), GLOB_BRACE);
        collect($pluginFiles)->each(function ($file) use (&$installed, $filesystem) {
            $plugin = json_decode($filesystem->get($file), true);
            if (!array_get($plugin, 'time')) array_set($plugin, 'time', date('Y-m-d H:i:s'));
            array_push($installed, $plugin);
        });

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
            if (count(array_get($item, 'extra.plugin.menu.children', [])) == 0 && !array_get($item, 'extra.plugin.menu.url')) {
                // 菜单路由根据命名空间生成
                $namespace = trim(collect(array_get($item, 'autoload.psr-4', []))->keys()->first(), '\\');
                $namespace = explode('\\', $namespace);
                $url = count($namespace) > 2 ? snake_case($namespace[1]) . '/' . snake_case($namespace[2]) : '#';

                array_set($item, 'extra.plugin.menu.url', $url);
            }

            // 24小时内发布的插件菜单显示new标签
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

        return collect($prepend)
            ->merge($menus)
            ->unique(function ($item) {
                return $item['group'] . '|' . $item['name'];
            })
            ->values()
            ->all();
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
