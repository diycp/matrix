# 插件目录

> 为了方便开发插件,特意增加了一个本地目录

## 使用方法

1. 只需要按照composer包规范写好插件

2. 然后执行`composer dumpautoload`命令即可

3. 如果php增加新的文件,则再次执行`composer dumpautoload`

4. 将开发好的包发布到composer仓库上

## 文件结构

插件目录可以随意放,但最多只支持3级目录

## 其他说明

建议开发时先在本地搭建composer私有仓库,建议使用 `toran proxy`

当然如果愿意,欢迎将写好的插件分享到packagist.org上