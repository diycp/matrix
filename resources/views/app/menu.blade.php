<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>@{{ services.auth.data.user.name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form class="sidebar-form" onsubmit="return false">
            <div class="input-group">
                <input type="text" ng-model="query" class="form-control" placeholder="输入关键字进行搜索">
                <span class="input-group-btn">
                <button class="btn btn-flat">
                    <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <app-menu items="services.auth.data.menu" filter="@{{query}}"></app-menu>

    </section>
    <!-- /.sidebar -->
</aside>