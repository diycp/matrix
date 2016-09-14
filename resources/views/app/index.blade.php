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
        <div class="row">

            <div class="col-md-12">
                <qrcode data="@{{ text }}" size="200" download></qrcode>
            </div>
            <div class="col-md-12">
                <textarea ng-model="text" style="width:100%;min-height:300px;border:none;resize: none;outline: none;"></textarea>
            </div>
            <div class="col-md-12">
                <div marked="text" class="markdown" style="height: 500px;"></div>
            </div>

        </div>

    </section>
</div>