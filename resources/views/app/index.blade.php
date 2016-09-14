<div ng-controller="IndexCtrl">
    <section class="content-header">
        <h1>我的面板</h1>
        <ol class="breadcrumb">
            <li>
                <a href="@{{ '/' | url }}">
                    <i class="fa fa-dashboard"></i>
                    首页
                </a>
            </li>
            <li class="active">我的面板</li>
        </ol>
    </section>

    <section class="content">
        <textarea ng-model="text" style="width:100%;min-height:300px;"></textarea>
        <div marked="text" class="markdown"></div>
    </section>
</div>