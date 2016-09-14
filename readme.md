# MATRIX
基于Laravel + Angular.js + AdminLTE开发

> 环境要求
- node.js >= 6.0 (建议)
- php >= 5.5.9

## 仓库地址

|  名称  |                 地址                    |
| ------ | --------------------------------------- |
| github | https://github.com/repertory/matrix     |
| aliyun | https://code.aliyun.com/wangdong/matrix |

## 安装所需命令
```
npm install -g bower gulp
```

## 安装步骤
```
# 创建项目
composer create-project wangdong/matrix matrix dev-master

cd matrix

# 安装依赖包
npm install
bower install

# 编译静态资源文件
gulp  # 开发时建议使用监听模式 gulp watch

# 修改.env配置，然后初始化数据库
php artisan migrate --seed
```

## 升级步骤
```
composer update
bower install
gulp
php artisan migrate:refresh --seed
```

## 常见问题
- npm安装失败或速度很慢？
  - 国内访问不稳定，建议使用淘宝镜像: http://npm.taobao.org
  - windows上建议安装python2.7 + vc2012 + .net framework3后再试

- bower安装失败？
  - 由于依赖git命令，安装后重试即可

- composer安装失败或超时？
  - 国内访问不稳定，建议使用国内镜像: http://pkg.phpcomposer.com/
