# MATRIX

[![Latest Stable Version](https://poser.pugx.org/wangdong/matrix/v/stable)](https://packagist.org/packages/wangdong/matrix)
[![Total Downloads](https://poser.pugx.org/wangdong/matrix/downloads)](https://packagist.org/packages/wangdong/matrix)
[![License](https://poser.pugx.org/wangdong/matrix/license)](https://packagist.org/packages/wangdong/matrix)

基于Laravel + Angular.js + AdminLTE开发

> 环境要求
- node.js >= 6.9.0 (建议)
- php >= 5.5.9 (必须)

## 仓库地址

|  名称  |                 地址                    |
| ------ | --------------------------------------- |
| github | https://github.com/repertory/matrix     |
| aliyun | https://code.aliyun.com/wangdong/matrix |

## 安装所需命令
```
npm install -g gulp gitbook-cli
```

## 安装步骤
```
# 创建项目
composer create-project wangdong/matrix matrix dev-master

cd matrix

# 安装依赖包
npm install

# 编译静态资源文件
npm start # 本地模式 (监听模式 npm run dev) 或 线上模式 npm run prod

# 修改.env配置，然后初始化数据库
php artisan migrate --seed
```

## 升级步骤
```
composer update
npm update
npm start
php artisan migrate:refresh --seed
```

## 开发文档
```
cd document
gitbook serve
```

## 常见问题
- npm安装失败或速度很慢？
  - 国内访问不稳定，建议使用淘宝镜像: http://npm.taobao.org
  - windows上建议安装python2.7 + vc2012 + .net framework3后再试

- composer安装失败或超时？
  - 国内访问不稳定，建议使用国内镜像: http://pkg.phpcomposer.com/

## 变动说明
- [2016-11-28]
  - 增加百度echarts插件（angular.js支持采用echarts-ng模块）

- [2016-10-31]
  - 移除bower管理模式（考虑到国内bower速度太慢，因此改用npm替代的方式）

## BUG反馈 

https://github.com/repertory/matrix/issues/new