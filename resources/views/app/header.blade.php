<header class="main-header">
    <!-- Logo -->
    <a ng-href="@{{ '/' | url }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">{!! config('laa.header.logo.mini') !!}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{!! config('laa.header.logo.normal') !!}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                @if(config('laa.header.toolbar.lockscreen.status'))
                    <li data-toggle="tooltip" data-placement="bottom" title="锁屏">
                        <a href="@{{ '/lock' | url }}"><i class="ion ion-lock-combination"></i></a>
                    </li>
                @endif

                @if(config('laa.header.toolbar.fullscreen.status'))
                    <li data-toggle="tooltip" data-placement="bottom" title="全屏模式">
                        <a ng-click="toggleFullScreen()"><i class="fa"
                                                            ng-class="{'fa-expand': !isFullscreen, 'fa-compress': isFullscreen}"></i></a>
                    </li>
                @endif

                @if(config('laa.header.toolbar.user.status'))
                    <li class="dropdown user user-menu">
                        <a href="#/" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs">@{{ services.auth.data.user.name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                <p>
                                    @{{ services.auth.data.user.email }}
                                    <small>注册时间：@{{ services.auth.data.user.created_at }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a ng-href="@{{ '/profile' | url }}" class="btn btn-default btn-flat">个人资料</a>
                                </div>
                                <div class="pull-right">
                                    <a ng-click="services.auth.logout()" class="btn btn-default btn-flat">退出登录</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif

                @if(config('laa.header.toolbar.theme.status'))
                    <li class="dropdown tasks-menu" data-toggle="tooltip">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="ion ion-android-color-palette"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">更换主题</li>
                            <li>
                                <ul class="menu">
                                    <li style="float:left; width: 33.33333%; padding: 5px;">
                                        <a href='javascript:void(0);' ng-click="themeEnable('skin-blue')"
                                           style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)'
                                           class='clearfix full-opacity-hover'>
                                            <div>
                                                <span style='display:block; width: 20%; float: left; height: 7px; background: #367fa9;'></span><span
                                                        class='bg-light-blue'
                                                        style='display:block; width: 80%; float: left; height: 7px;'></span>
                                            </div>
                                            <div>
                                                <span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span
                                                        style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span>
                                            </div>
                                        </a>
                                        <p class='text-center no-margin'>Blue</p>
                                    </li>
                                    <li style="float:left; width: 33.33333%; padding: 5px;">
                                        <a href='javascript:void(0);' ng-click="themeEnable('skin-black')"
                                           style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)'
                                           class='clearfix full-opacity-hover'>
                                            <div style='box-shadow: 0 0 2px rgba(0,0,0,0.1)' class='clearfix'><span
                                                        style='display:block; width: 20%; float: left; height: 7px; background: #fefefe;'></span><span
                                                        style='display:block; width: 80%; float: left; height: 7px; background: #fefefe;'></span>
                                            </div>
                                            <div>
                                                <span style='display:block; width: 20%; float: left; height: 20px; background: #222;'></span><span
                                                        style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span>
                                            </div>
                                        </a>
                                        <p class='text-center no-margin'>Black</p>
                                    </li>
                                    <li style="float:left; width: 33.33333%; padding: 5px;">
                                        <a href='javascript:void(0);' ng-click="themeEnable('skin-purple')"
                                           style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)'
                                           class='clearfix full-opacity-hover'>
                                            <div><span style='display:block; width: 20%; float: left; height: 7px;'
                                                       class='bg-purple-active'></span><span class='bg-purple'
                                                                                             style='display:block; width: 80%; float: left; height: 7px;'></span>
                                            </div>
                                            <div>
                                                <span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span
                                                        style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span>
                                            </div>
                                        </a>
                                        <p class='text-center no-margin'>Purple</p>
                                    </li>
                                    <li style="float:left; width: 33.33333%; padding: 5px;">
                                        <a href='javascript:void(0);' ng-click="themeEnable('skin-green')"
                                           style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)'
                                           class='clearfix full-opacity-hover'>
                                            <div><span style='display:block; width: 20%; float: left; height: 7px;'
                                                       class='bg-green-active'></span><span class='bg-green'
                                                                                            style='display:block; width: 80%; float: left; height: 7px;'></span>
                                            </div>
                                            <div>
                                                <span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span
                                                        style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span>
                                            </div>
                                        </a>
                                        <p class='text-center no-margin'>Green</p>
                                    </li>
                                    <li style="float:left; width: 33.33333%; padding: 5px;">
                                        <a href='javascript:void(0);' ng-click="themeEnable('skin-red')"
                                           style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)'
                                           class='clearfix full-opacity-hover'>
                                            <div><span style='display:block; width: 20%; float: left; height: 7px;'
                                                       class='bg-red-active'></span><span class='bg-red'
                                                                                          style='display:block; width: 80%; float: left; height: 7px;'></span>
                                            </div>
                                            <div>
                                                <span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span
                                                        style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span>
                                            </div>
                                        </a>
                                        <p class='text-center no-margin'>Red</p>
                                    </li>
                                    <li style="float:left; width: 33.33333%; padding: 5px;">
                                        <a href='javascript:void(0);' ng-click="themeEnable('skin-yellow')"
                                           style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)'
                                           class='clearfix full-opacity-hover'>
                                            <div><span style='display:block; width: 20%; float: left; height: 7px;'
                                                       class='bg-yellow-active'></span><span class='bg-yellow'
                                                                                             style='display:block; width: 80%; float: left; height: 7px;'></span>
                                            </div>
                                            <div>
                                                <span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span
                                                        style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span>
                                            </div>
                                        </a>
                                        <p class='text-center no-margin'>Yellow</p>
                                    </li>
                                    <li style="float:left; width: 33.33333%; padding: 5px;">
                                        <a href='javascript:void(0);' ng-click="themeEnable('skin-blue-light')"
                                           style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)'
                                           class='clearfix full-opacity-hover'>
                                            <div>
                                                <span style='display:block; width: 20%; float: left; height: 7px; background: #367fa9;'></span><span
                                                        class='bg-light-blue'
                                                        style='display:block; width: 80%; float: left; height: 7px;'></span>
                                            </div>
                                            <div>
                                                <span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span
                                                        style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span>
                                            </div>
                                        </a>
                                        <p class='text-center no-margin' style='font-size: 12px'>Blue Light</p>
                                    </li>
                                    <li style="float:left; width: 33.33333%; padding: 5px;">
                                        <a href='javascript:void(0);' ng-click="themeEnable('skin-black-light')"
                                           style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)'
                                           class='clearfix full-opacity-hover'>
                                            <div style='box-shadow: 0 0 2px rgba(0,0,0,0.1)' class='clearfix'><span
                                                        style='display:block; width: 20%; float: left; height: 7px; background: #fefefe;'></span><span
                                                        style='display:block; width: 80%; float: left; height: 7px; background: #fefefe;'></span>
                                            </div>
                                            <div>
                                                <span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span
                                                        style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span>
                                            </div>
                                        </a>
                                        <p class='text-center no-margin' style='font-size: 12px'>Black Light</p>
                                    </li>
                                    <li style="float:left; width: 33.33333%; padding: 5px;">
                                        <a href='javascript:void(0);' ng-click="themeEnable('skin-purple-light')"
                                           style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)'
                                           class='clearfix full-opacity-hover'>
                                            <div><span style='display:block; width: 20%; float: left; height: 7px;'
                                                       class='bg-purple-active'></span><span class='bg-purple'
                                                                                             style='display:block; width: 80%; float: left; height: 7px;'></span>
                                            </div>
                                            <div>
                                                <span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span
                                                        style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span>
                                            </div>
                                        </a>
                                        <p class='text-center no-margin' style='font-size: 12px'>Purple Light</p>
                                    </li>
                                    <li style="float:left; width: 33.33333%; padding: 5px;">
                                        <a href='javascript:void(0);' ng-click="themeEnable('skin-green-light')"
                                           style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)'
                                           class='clearfix full-opacity-hover'>
                                            <div><span style='display:block; width: 20%; float: left; height: 7px;'
                                                       class='bg-green-active'></span><span class='bg-green'
                                                                                            style='display:block; width: 80%; float: left; height: 7px;'></span>
                                            </div>
                                            <div>
                                                <span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span
                                                        style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span>
                                            </div>
                                        </a>
                                        <p class='text-center no-margin' style='font-size: 12px'>Green Light</p>
                                    </li>
                                    <li style="float:left; width: 33.33333%; padding: 5px;">
                                        <a href='javascript:void(0);' ng-click="themeEnable('skin-red-light')"
                                           style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)'
                                           class='clearfix full-opacity-hover'>
                                            <div><span style='display:block; width: 20%; float: left; height: 7px;'
                                                       class='bg-red-active'></span><span class='bg-red'
                                                                                          style='display:block; width: 80%; float: left; height: 7px;'></span>
                                            </div>
                                            <div>
                                                <span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span
                                                        style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span>
                                            </div>
                                        </a>
                                        <p class='text-center no-margin' style='font-size: 12px'>Red Light</p>
                                    </li>
                                    <li style="float:left; width: 33.33333%; padding: 5px;">
                                        <a href='javascript:void(0);' ng-click="themeEnable('skin-yellow-light')"
                                           style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)'
                                           class='clearfix full-opacity-hover'>
                                            <div><span style='display:block; width: 20%; float: left; height: 7px;'
                                                       class='bg-yellow-active'></span><span class='bg-yellow'
                                                                                             style='display:block; width: 80%; float: left; height: 7px;'></span>
                                            </div>
                                            <div>
                                                <span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span
                                                        style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span>
                                            </div>
                                        </a>
                                        <p class='text-center no-margin' style='font-size: 12px;'>Yellow Light</p>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>