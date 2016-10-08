# 系统简介

## 设计理念

以往我经历过的所有项目都会随着开发人员的增加导致原来的架构模式出现问题，
为了解决这一问题，我这里将一个系统划分为每一个功能（我叫他们为模块），每
个模块只负责一个独立的功能，如果功能过于复杂则在此基础上再分模块（目的就
是要将所有功能划分为一个个独立的可以完全被替代的模块），如果遇到特殊情况
则必须由我先提供对应的接口才能去实现（可以将我的这套系统看作为一个操作系
统，每一个功能就是用户自己安装的软件，如果系统不支持某些接口，则软件上是
无法实现的这些功能的）

解决以上问题后相信大家的开发习惯上会发生很大变化，但后期带来的影响肯定是值得的

## 代码托管地址
https://github.com/repertory/matrix

**关于开源**
- 遵守MIT开源协议
- 如果大家都来帮忙完善，后面就会发展的越来越好
- 以后别人写好的插件我们拿来就能直接使用了，我们写好的也可以给其他人使用，避免重复劳动

## 目录结构
```
├─app
│  ├─Console
│  ├─Events
│  ├─Exceptions
│  ├─Http
│  │  ├─routes.php        # 系统路由配置文件（插件访问等入口）
│  │  ├─Controllers
│  │  │  ├─MatrixController.php  # 系统默认控制器（可以使用插件进行覆盖）
│  │  │  └─Auth
│  │  ├─Middleware
│  │  └─Requests
│  ├─Jobs
│  ├─Listeners
│  ├─Models
│  ├─Policies
│  └─Providers
├─bootstrap
├─bower_components           # bower安装目录（前端包管理）
├─config                     # 系统配置目录
├─database
│  ├─factories
│  ├─migrations
│  └─seeds
├─document                   # 开发文档目录
├─matrix                     # 本地插件目录（方便开发用） 
├─node_modules               # npm安装目录（一般为node.js包）
├─public
│  ├─build                  # 与下面目录对应
│  │  ├─css                # 与public/css目录对应（文件名带版本号）
│  │  ├─fonts              # 与public/fonts目录一样
│  │  ├─img                # 与public/img目录一样
│  │  └─js                 # 与public/js目录对应（文件名带版本号）
│  ├─css                    # 通过resources/assets目录或插件目录生成
│  ├─fonts                  # 通过bower或插件目录生成
│  ├─img                    # 通过bower或插件目录生成
│  └─js                     # 通过resources/assets目录或插件目录生成
├─resources
│  ├─assets
│  │  ├─js
│  │  │  ├─app.js         # 整个系统入口js(全局)
│  │  │  └─app            # app.js依赖文件
│  │  └─sass               # 系统默认样式目录(全局)
│  ├─lang
│  └─views                  # 系统（除插件外）模板目录
│      ├─index.blade.php    # 系统入口页面模板文件(全局)
│      ├─errors
│      ├─matrix
│      └─vendor
├─storage
│  ├─app
│  │  └─public
│  ├─framework
│  │  ├─cache
│  │  ├─sessions
│  │  └─views              # 系统模板缓存目录（APP_ENV=local时没有缓存），上线更新时得清理一次
│  └─logs
├─tests
└─vendor                     # composer安装目录（type=matrix-plugin的为系统插件包）
```

## 运行原理

参考文件：

- app/Http/routes.php
- app/Http/Controllers/MatrixController.php

## 第三方包管理

**bower**

> 用于安装系统所需要的第三方类库

配置文件： bower.json

**npm**

> 用于安装前端工具

配置文件： package.json

**composer**

> 用于安装PHP类库

配置文件： composer.json

## 系统安装

**首次安装**

```
composer create-project wangdong/matrix matrix dev-master
cd matrix

npm install
bower install
gulp
```

**代码更新**

```
composer update
bower instasll
gulp
```

## 常见问题
- npm安装失败或速度很慢？
  - 国内访问不稳定，建议使用淘宝镜像: http://npm.taobao.org
  - windows上建议安装python2.7 + vc2012 + .net framework3后再试

- bower安装失败？
  - 由于依赖git命令，安装后重试即可

- composer安装失败或超时？
  - 国内访问不稳定，建议使用国内镜像: http://pkg.phpcomposer.com/