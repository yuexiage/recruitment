<!DOCTYPE html>
<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>后台管理系统</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html"/>
    <![endif]-->
	<link rel="shortcut icon" href="favicon.ico">
    <link href="{{ asset('css/bootstrap.min.css?v=3.3.6')}}{{time()}}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css?v=4.4.0') }}{{time()}}" rel="stylesheet">
    <link href="{{ asset('css/animate.min.css?v=') }}{{time()}}" rel="stylesheet">
    <link href="{{ asset('css/style.min.css?v=4.1.10') }}{{time()}}" rel="stylesheet">
    <link href="{{ asset('js/layui/css/layui.css?v=') }}{{time()}}" rel="stylesheet">
    <script src="{{ asset('js/jquery.min.js?v=2.1.4') }}{{time()}}"></script>
    <script src="{{ asset('js/layui/layui.js?v=1.0.0') }}{{time()}}"></script>
    <script src="{{ asset('js/bootstrap.min.js?v=3.3.6') }}{{time()}}"></script>
    <script src="{{ asset('js/content.min.js?v=1.0.0') }}{{time()}}"></script>
    <script src="{{ asset('js/jquery.form.js?v=') }}{{time()}}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js?v=') }}{{time()}}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js?v=') }}{{time()}}"></script>
    <script src="{{ asset('js/plugins/layer/layer.min.js?v=') }}{{time()}}"></script>
	<script src="{{ asset('js/hplus.min.js?v=4.1.0') }}{{time()}}"></script>
	<script type="text/javascript" src="{{ asset('js/contabs.min.js?v=') }}{{time()}}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js?v=') }}{{time()}}"></script>
</head>
<body class="fixed-sidebar full-height-layout gray-bg">