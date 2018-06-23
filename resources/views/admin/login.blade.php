@extends('layouts.app')
@section('content')
<link href="{{ asset('css/login.min.css') }}" rel="stylesheet">
<!--[if lt IE 9]>
<meta http-equiv="refresh" content="0;ie.html" />
<![endif]-->
<script>
    if(window.top!==window.self){window.top.location=window.location};
</script>
<div class="signinpanel">
    <div class="row">
        <div class="col-sm-7">
            <div class="signin-info">
                <div class="logopanel m-b">
                </div>
                <div class="m-b"></div>
                <h4>欢迎使用招聘系统</strong></h4>
                <ul class="m-b">

                </ul>
            </div>
        </div>
        <div class="col-sm-5">
            <form method="post" action="index.html">
                <p class="m-t-md" id="err_msg">登录到招聘系统后台</p>
                <input type="text" class="form-control uname" placeholder="用户名" id="user_name" value="admin" />
                <input type="password" class="form-control pword m-b" placeholder="密码" id="password" value="p8r3b84"/>
                <div style="margin-bottom:70px">
                    <input type="text" class="form-control" placeholder="验证码" style="color:black;width:120px;float:left;margin:0px 0px;" name="code" id="code"/>
                    <img class='captcha' src="{{ url('captcha/1')}}" onclick="javascript:this.src='{{ url('captcha/1')}}?tm='+Math.random();" style="float:right;cursor: pointer"/>
                </div>
                {{ csrf_field() }}
                <input class="btn btn-success btn-block" id="login_btn" value="登录"/>
            </form>
        </div>
    </div>
    <div class="signup-footer">
        <div class="pull-left">
            &copy; 2017-2019 All Rights Reserved. laravel
        </div>
    </div>
</div>

<script type="text/javascript">
    document.onkeydown=function(event){
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if(e && e.keyCode==13){ // enter ��
            $('#login_btn').click();
        }
    };
    var lock = false;
    $(function () {
        $('#login_btn').click(function(){
            if(lock){
                return;
            }
            lock = true;
            $('#err_msg').hide();
            $('#login_btn').removeClass('btn-success').addClass('btn-danger').val('登陆中...');
            var username 	= $('#user_name').val();
            var password 	= $('#password').val();
            var code 		= $('#code').val();
            var _token 		= $('input[name="_token"]').val();
            $.post("{{url('admin/dologin')}}",{'user_name':username, 'password':password, 'code':code,'_token':_token},function(data){
                lock = false;
                $('#login_btn').val('登录').removeClass('btn-danger').addClass('btn-success');
                if(data.code==1){
                    $('#err_msg').show().html("<span style='color:red'>"+data.msg+"</span>");
					$(".captcha").click();
                    return;
                }else{
                	window.location.href=data.data;
                }
            });
        });
    });
</script>
@endsection