<!DOCTYPE html>
<html lang="zh_CN" ng-controller="AllCtrl" fullscreen="isFullscreen">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="author" content="wangdong">
    <title>{{ config('matrix.name') }}</title>
    <link rel="stylesheet" href="{{ elixir('css/matrix.css') }}" type="text/css"/>
    <base href="/">
</head>
<body ng-class="bodyClass">
<!--[if lt IE 9]>
<script>
    document.body.innerHTML = '<h4>当前浏览器版本过低，暂不支持访问！</h4>';
    window.stop();
</script>
<![endif]-->

<div ui-view="layout">
    <div class="svg-icon-loader">
        <svg width="40" height="40" viewBox="0 0 135 140" xmlns="http://www.w3.org/2000/svg" fill="#605ca8">
            <rect y="10" width="15" height="120" rx="6">
                <animate attributeName="height"
                         begin="0.5s" dur="1s"
                         values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                         repeatCount="indefinite"/>
                <animate attributeName="y"
                         begin="0.5s" dur="1s"
                         values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                         repeatCount="indefinite"/>
            </rect>
            <rect x="30" y="10" width="15" height="120" rx="6">
                <animate attributeName="height"
                         begin="0.25s" dur="1s"
                         values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                         repeatCount="indefinite"/>
                <animate attributeName="y"
                         begin="0.25s" dur="1s"
                         values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                         repeatCount="indefinite"/>
            </rect>
            <rect x="60" width="15" height="140" rx="6">
                <animate attributeName="height"
                         begin="0s" dur="1s"
                         values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                         repeatCount="indefinite"/>
                <animate attributeName="y"
                         begin="0s" dur="1s"
                         values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                         repeatCount="indefinite"/>
            </rect>
            <rect x="90" y="10" width="15" height="120" rx="6">
                <animate attributeName="height"
                         begin="0.25s" dur="1s"
                         values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                         repeatCount="indefinite"/>
                <animate attributeName="y"
                         begin="0.25s" dur="1s"
                         values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                         repeatCount="indefinite"/>
            </rect>
            <rect x="120" y="10" width="15" height="120" rx="6">
                <animate attributeName="height"
                         begin="0.5s" dur="1s"
                         values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
                         repeatCount="indefinite"/>
                <animate attributeName="y"
                         begin="0.5s" dur="1s"
                         values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
                         repeatCount="indefinite"/>
            </rect>
        </svg>
    </div>
</div>

<script type="text/javascript" src="{{ elixir('js/matrix.js') }}"></script>
</body>
</html>
