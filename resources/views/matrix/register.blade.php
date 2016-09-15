<div class="register-box" ng-controller="RegisterCtrl">
    {{--<div class="register-logo">--}}
    {{--<a ng-href="@{{ '/' | url }}"><b>Admin</b>LTE</a>--}}
    {{--</div>--}}

    <div class="register-box-body">
        {{--<p class="login-box-msg">Register a new membership</p>--}}

        <form name="form">
            <div class="form-group has-feedback">
                <input type="text" name="name" class="form-control" placeholder="姓名" ng-model="data.name" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="邮箱" required
                       ng-model="data.email" ng-model-options="{ debounce: 100 }"
                       ui-validate-async="{exists: 'checkEmail($modelValue)'}">
                <span ng-show='form.email.$error.exists'>邮箱已被使用</span>
                <span ng-show='form.email.$pending'>邮箱验证中...</span>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="密码" required
                       ng-model="data.password" ui-validate="{password: 'checkPassword($value)'}">
                <span ng-show='form.password.$error.password'>密码为6-30个字符组成</span>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="confirm_password" class="form-control" placeholder="确认密码" required
                       ng-model="data.confirm_password" ui-validate=" '$value==data.password' "
                       ui-validate-watch=" 'data.password' ">
                <span ng-show='form.confirm_password.$error.validator'>两次密码不一致</span>
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <button ng-if="form.$valid" ng-click="services.matrix.register(data)"
                            class="btn btn-primary btn-block btn-flat">注册
                    </button>
                    <button ng-if="!form.$valid" class="btn btn-primary btn-block btn-flat">注册</button>
                </div>
                <div class="col-xs-6">
                    <a ng-href="@{{ '/login' | url }}" class="btn btn-default btn-block btn-flat">已有帐号登录</a>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.form-box -->
</div>