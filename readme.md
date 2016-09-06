# laa
Laravel + Angular.js + AdminLTE

> 环境要求
- node.js >= 6.0 (建议)
- php >= 5.5.9

## 安装所需命令
```
npm install -g bower gulp
```

## 安装步骤
```
# 克隆系统代码
git clone https://code.aliyun.com/wangdong/laa.git
cd laa

# 安装依赖包
npm install
bower install
composer install

# 编译静态资源文件
gulp  # 开发时建议使用监听模式 gulp watch

# 修改配置文件
cp .env.example .env
php artisan key:generate

# 初始化数据库
php artisan migrate --seed
```

## 升级步骤
```
git pull
bower install
npm install
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
