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
    	<div class="col-sm-2">
    	</div>
        <div class="col-sm-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>添加角色</h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal m-t layui-form" id="commentForm" method="post" action="{{url('admin/users')}}">
						{{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><sub>*</sub>用户名：</label>
                            <div class="input-group col-sm-4">
                                <input type="text" class="form-control" lay-verify="required|username" name="name" required aria-required="true" value="{{isset($user->name)?$user->name:''}}" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><sub>*</sub>邮箱：</label>
                            <div class="input-group col-sm-4">
                                <input  type="email" class="form-control" lay-verify="required|email" name="email" required aria-required="true" value="{{isset($user->email)?$user->email:''}}" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><sub>*</sub>密码：</label>
                            <div class="input-group col-sm-4">
                                <input type="password" name='password' id="pwd"  lay-verify="pwd" placeholder="请输入密码" autocomplete="off" class="layui-input">
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-sm-3 control-label"><sub>*</sub>重复密码：</label>
                            <div class="input-group col-sm-4">
                                <input type="password" name='password_confirmation' id="regPwd"  lay-verify="pwd|regPwd" placeholder="请输入密码" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><sub>*</sub>部门：</label>
                            <div class="input-group col-sm-4">
                                <select name='departme' required lay-verify="required" >
                                	<option value=''>选择部门</option>
                                	@foreach($departmes as $val)
                                	<option value='{{$val->alias}}' {{isset($user->departme_alias)&&$val->alias==$user->departme_alias?'selected':''}}>{{$val->departme_name}}</option>
                                	@endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-6">
                            	<input type="hidden" class="form-control" name="user_id" required value="{{isset($user->id)?$user->id:'-1'}}">
                                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
    	</div>
    </div>
</div>
<script>
layui.use('form', function(){
	var form = layui.form;
	form.verify({
		username: function(value, item){ //value：表单的值、item：表单的DOM对象
		    if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)){
		    	return '用户名不能有特殊字符';
		    }
		    if(/(^\_)|(\__)|(\_+$)/.test(value)){
		    	return '用户名首尾不能出现下划线\'_\'';
		    }
		    if(/^\d+\d+\d$/.test(value)){
		    	return '用户名不能全为数字';
		    }
		}
	   ,pwd: [
	    	/^[\S]{0,8}$/
	    	,'密码必须0到8位，且不能出现空格'
	  	]
		,regPwd: function(value) {
    		if(value != $("#pwd").val()){
    			$("#regPwd").val("");
    			return '确认密码与密码不一致';
    		}
		}
	});
	form.on('submit(formDemo)', function(data){
		if($('#pwd').val()!=$('#regPwd').val()){
			layer.alert('两次密码不一致',{'icon':5});
			return false;
		}else{
			$.ajax({
		    	url:"{{url('/admin/users/')}}",
	            type:'POST',
	            headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        },  
		        data:data.field,
	            success:function(res){
	               if(res.code==0){
	            	   layer.msg(res.msg, {time : 3000});
	            	   window.location.href="{{url('/admin/users/')}}";
	               }else{
	            	   layer.alert(res.msg,{icon: 5}); 
	               }
	            }           
	        });
		}
	    return false;
	});
});
</script>
@endsection
