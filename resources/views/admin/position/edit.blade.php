<?php
/** 
 * PHP是世界上最好的语言！
 * @Author yuexiage
 * @Date 2018年6月21日 下午10:18:01 
 * @Email 418221610@qq.com
*/ 
?>
@extends('layouts.app') @section('content')
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight container-fluid">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="row">
        <div class="col-sm-8 center-block">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>添加职位</h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal m-t" id="commentForm" method="post" action="{{url('admin/position')}}">
						{{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-3 control-label">职位名称：</label>
                            <div class="input-group col-sm-5">
                                <input id="position_name" type="text" class="form-control" name="name" required lay-verify="required|username" value="{{isset($position->name)?$position->name:''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">工作地点：</label>
                            <div data-toggle="distpicker" class="input-group col-sm-5">
                                <div class="row">
                                    <div class="col-sm-4">
                                    	<label class="sr-only" for="province">省份/市</label>
                                    	<select class="form-control" id="province" required lay-verify="required" data-province="---- 选择省 ----"></select>
                                    </div>
                                    <div class="col-sm-4">
                                    	<label class="sr-only" for="city">城市</label>
                                    	<select class="form-control" id="city" required lay-verify="required" data-city="---- 选择市 ----"></select>
                                    </div>
                                    <div class="col-sm-4">
                                    	<label class="sr-only" for="district">区县</label>
                                    	<select class="form-control" id="district" required lay-verify="required" data-district="---- 选择区 ----"></select>
                                    </div>
                                </div>
                        	</div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">工作经验：</label>
                            <div class="input-group col-sm-5">
                                <select class="form-control" required lay-verify="required">
                                	<option value=''>---- 选择工作经验 ----</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">学历要求：</label>
                            <div class="input-group col-sm-5">
                                <select class="form-control" required lay-verify="required">
                                	<option value=''>---- 选择学历要求 ----</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">工作类型：</label>
                            <div class="input-group col-sm-5">
                                <select class="form-control" required lay-verify="required">
                                	<option value='1'>全职</option>
                                	<option value='2'>兼职</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">招聘部门：</label>
                            <div class="input-group col-sm-5">
                                <select class="form-control" required lay-verify="required">
                                	
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">招聘人数：</label>
                            <div class="input-group col-sm-5">
                                <input value="{{isset($channel->channel_money)?$channel->channel_money:''}}" type="text" class="form-control" name="num" id="channel_money" 
                                onkeyup="this.value=this.value.replace(/\D|^0/g,'')" 
                                onafterpaste="this.value=this.value.replace(/\D|^0/g,'')"> <span class="input-group-addon">位</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">职位描述：</label>
                            <div class="input-group col-sm-5">
                                <textarea id="editor"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-6">
                            	<input id="position_name" type="hidden" class="form-control" name="position_id" required value="{{isset($position->id)?$position->id:'-1'}}">
                                <button class="btn btn-primary" type="submit">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="{{ asset('js/distpicker.data.js?v=') }}{{time()}}"></script>
<script src="{{ asset('js/distpicker.js?v=') }}{{time()}}"></script>
<script src="{{ asset('js/main.js?v=') }}{{time()}}"></script>
<script src="{{ asset('js/plugins/tinymce/tinymce.min.js?v=') }}{{time()}}"></script>
<script>tinymce.init({ 
	selector:'#editor',
	language: 'zh_CN'
	});
</script>
}
@endsection
