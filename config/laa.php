<?php

return [

    'name' => 'LAA管理系统',
    'header' => [
        'logo' => [
            'mini' => '<b>LAA</b>',
            'normal' => '<b>LAA</b>管理系统',
        ],
        'toolbar' => [
            'theme' => [
                'status' => 1,
                'name' => '更换主题',
            ],
            'user' => [
                'status' => 1,
                'name' => '用户选项卡',
            ],
            'fullscreen' => [
                'status' => 1,
                'name' => '全屏模式',
            ],
            'lockscreen' => [
                'status' => 0,
                'name' => '锁屏',
            ],
        ]
    ],
    'footer' => [
        'version'=> '1.0.0',
        'copyright' => '<strong>Copyright &copy; 2016 <a target="_blank" href="https://code.aliyun.com/wangdong/laa">wangdong</a>.</strong> All rights reserved.',
    ]

];
