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
<div class="wrapper wrapper-content animated fadeInRight">
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
        <div class="col-sm-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>添加角色</h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal m-t" id="commentForm" method="post" action="{{url('admin/role')}}">
						{{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-3 control-label">角色名称：</label>
                            <div class="input-group col-sm-4">
                                <input id="role_name" type="text" class="form-control" name="name" required aria-required="true" value="{{$role->name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">角色名称：</label>
                            <div class="input-group col-sm-4">
                            <select name='guard_name' required class="form-control">
                            	<option value=''>选择部门</option>
                            	@foreach($departme as $val)
                            	<option value='{{$val->alias}}'>{{$val->departme_name}}</option>
                            	@endforeach
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-6">
                            	<input id="role_name" type="hidden" class="form-control" name="role_id" required value="{{$role->id}}">
                                <button class="btn btn-primary" type="submit">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
