<div ng-controller="MenuIndexCtrl">
    <section class="content-header">
        <h1>菜单管理</h1>
        <ol class="breadcrumb">
            <li><a ng-href="@{{ '/' | url }}"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><i class="fa fa-gears"></i> 设置中心</li>
            <li class="active">菜单管理</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">菜单管理</h3>
                        <a ng-href="@{{ '/menu/create' | url }}" class="btn btn-primary pull-right">添加</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table datatable="ng" dt-options="options" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>分组</th>
                                <th>名称</th>
                                <th>图标</th>
                                <th>标签</th>
                                <th>关键字</th>
                                <th>URL</th>
                                <th>排序</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="menu in services.menu.data" ng-if="menu">
                                <td>@{{ menu.id }}</td>
                                <td>@{{ menu.group.replace('|', ' | ') }}</td>
                                <td>@{{ menu.name }}</td>
                                <td><i class="@{{ menu.icon }}"></i> @{{ menu.icon }}</td>
                                <td><small ng-repeat="right in menu.right"> @{{ right.text }} </small></td>
                                <td>@{{ menu.keywords }}</td>
                                <td>@{{ menu.url }}</td>
                                <td>@{{ menu.order_by }}</td>
                                <td>@{{ menu.deleted_at ? '已删除' : '正常' }}</td>
                                <td>
                                    <a class="btn btn-default btn-sm"
                                       ng-href="@{{ '/menu/' + menu.id + '/edit' | url }}">
                                        <i class="glyphicon glyphicon-pencil"></i> 编辑
                                    </a>
                                    <a class="btn btn-default btn-sm" ng-click="services.menu.delete(menu)">
                                        <i class="glyphicon glyphicon-trash"></i> 删除
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
    </section>
</div>