# 插件开发

- 遵循一个插件一个功能的原则，插件中只保留一个PHP控制器文件、一个js入口文件以及一个css入口文件
- 插件可以发布到`packagist.org`上使用，同时也支持将插件放到系统的`matrix`目录下的任意目录中使用（需要执行一次`composer dump-autoload`命令）
- 插件js采用`angular.js`(angular1)；样式采用`scss`；

## 文件结构
```
├─composer.json    # composer配置文件
├─assets           # 静态资源目录
│  ├─plugin.js     # 插件js入口文件（可省略，支持es6）
│  └─plugin.scss   # 插件样式文件(可省略)
├─src              # composer PHP文件目录
│  └─Controller.php    # 插件控制器（view()模板目录为下面这个）
├─views            # laravel模板目录
└─public           # 将与public目录合并
   ├─img           # 图片目录
   ├─fonts         # 字体目录 
   └─...
```

## composer.json配置
```
{
  "name": "wangdong/matrix-plugin-about",
  "description": "matrix plugin",
  "type": "matrix-plugin",
  "license": "MIT",
  "authors": [
    {
      "name": "wangdong",
      "email": "mail@wangdong.io"
    }
  ],
  "require": {},
  "autoload": {
    "psr-4": {
      "Matrix\\Matrix\\About\\": "src/"
    }
  },
  "extra": {
    "plugin": {
      "menu": {
        "status": true,
        "group": "其他菜单",
        "name": "关于系统",
        "icon": "fa fa-info-circle",
        "keywords": "guanyuxitong"
      },
      "action": {
        "view": [
          "index"
        ],
        "add": [],
        "edit": [],
        "delete": [],
        "skip": []
      }
    }
  }
}
```

**说明**
- type必须为`matrix-plugin`
- action中定义控制器的方法名，方便后面权限控制用
- 如果插件不需要显示左侧菜单，则设置extra.plugin.menu.status = false
- 控制器必须使用resource方式

> 参考地址： https://github.com/repertory
