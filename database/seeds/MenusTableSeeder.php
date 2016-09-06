<?php

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [
                'group' => '导航菜单',
                'name' => '我的面板',
                'keywords' => 'wodemianban',
                'icon' => 'fa fa-dashboard',
                'right' => [
                    [
                        'class' => 'bg-green',
                        'text' => 'new'
                    ],
                    [
                        'class' => 'bg-blue',
                        'text' => 'tag'
                    ],
                ],
                'url' => '/',
            ],
            [
                'group' => '导航菜单',
                'name' => '设置中心',
                'keywords' => 'shezhizhongxin',
                'icon' => 'fa fa-gears',
            ],
            [
                'group' => '导航菜单|设置中心',
                'name' => '菜单设置',
                'keywords' => 'caidanshezhi',
                'icon' => 'fa fa-list',
                'right' => [
                    [
                        'class' => 'bg-green',
                        'text' => 'new'
                    ],
                ],
                'url' => '/menu',
            ],
            [
                'group' => '导航菜单',
                'name' => '用户中心',
                'keywords' => 'yonghuzhognxin',
                'icon' => 'fa fa-users',
            ],
            [
                'group' => '导航菜单|用户中心',
                'name' => '角色管理',
                'keywords' => 'jueseguanli',
                'icon' => 'fa fa-tags',
                'right' => [
                    [
                        'class' => 'bg-green',
                        'text' => 'new'
                    ],
                ],
                'url' => '/role',
            ],
            [
                'group' => '导航菜单|用户中心',
                'name' => '用户管理',
                'keywords' => 'yonghuguanli',
                'icon' => 'fa fa-user',
                'right' => [
                    [
                        'class' => 'bg-green',
                        'text' => 'new'
                    ],
                ],
                'url' => '/user',
            ],
            [
                'group' => '其他菜单',
                'name' => '开发文档',
                'keywords' => 'kaifawendang',
                'icon' => 'fa fa-book',
                'url' => '/document',
            ],
            [
                'group' => '其他菜单',
                'name' => '关于系统',
                'keywords' => 'guanyuxitong',
                'icon' => 'fa fa-info-circle',
                'right' => [
                    [
                        'class' => 'bg-green',
                        'text' => 'new'
                    ],
                ],
                'url' => '/about',
            ],
        ];

        // 插入数据
        array_map(function ($row) {
            Menu::create($row);
        }, $rows);
    }
}
