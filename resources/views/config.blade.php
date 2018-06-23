@extends('layouts.app')
@section('content')
<form class="layui-form" action="">
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="container-fluid">
    	<div class="row">
    		<div class="float-e-margins col-sm-12">
                <div class="ibox-title">
                    <div class="container-fluid">  
                    	<div class="layui-row">
                    		<div class="layui-col-md12">
                          		<button class="layui-btn layui-col-md-offset11" lay-submit lay-filter="formDemo">保存</button>
                        	</div>
                    	</div>
                    </div>
                </div>
                <div class="ibox-content">
					<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                    	<ul class="layui-tab-title">
                            <li class="layui-this">网站设置</li>
                            <li>系统设置</li>
                      	</ul>
                     	<div class="layui-tab-content">
                       		<div class="layui-tab-item layui-show">
                           		<div class="layui-container">
                        			<div class="layui-row">
                        				<div class="layui-col-md9">	
                        				<form class="layui-form" action="">
                            				<div class="layui-form-item">
                                                <label class="layui-form-label">网站名称:</label>
                                                <div class="layui-input-block">
                                                	<input type="text" name="sitename" required  lay-verify="required" placeholder="请输入网站名称" autocomplete="off" class="layui-input" value="{{$sitename}}">
                                                </div>
                                            </div>
                                            <div class="layui-form-item">
                                                <label class="layui-form-label">默认注册角色:</label>
                                                <div class="layui-input-block">
                                                  <select name="access" lay-verify="required">
                                                    <option value=""></option>
                                                    <option value="0">北京</option>
                                                    <option value="1">上海</option>
                                                    <option value="2">广州</option>
                                                    <option value="3">深圳</option>
                                                    <option value="4">杭州</option>
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="layui-form-item layui-form-text">
                                                <label class="layui-form-label">网站元描述(Meta description)</label>
                                                <div class="layui-input-block">
                                                  <textarea name="metadesc" placeholder="请输入内容" class="layui-textarea">{{$metadesc}}</textarea>
                                                </div>
                                            </div>
                                            <div class="layui-form-item layui-form-text">
                                                <label class="layui-form-label">网站元关键字(Meta Keywords)</label>
                                                <div class="layui-input-block">
                                                  <textarea name="metakeys" placeholder="请输入内容" class="layui-textarea">{{$metakeys}}</textarea>
                                                </div>
                                            </div>
                                            <div class="layui-form-item layui-form-text">
                                                <label class="layui-form-label">版权信息</label>
                                                <div class="layui-input-block">
                                                  <textarea name="metarights" placeholder="请输入内容" class="layui-textarea">{{$metarights}}</textarea>
                                                </div>
                                            </div>
                                        </form>
                                        </div>
                        			</div>
                        		</div>
                    		</div>
                        	<div class="layui-tab-item">
								<div class="layui-row">
                    				<div class="layui-col-md9">	
                        				
                                    </div>
                    			</div>
							</div>
                      	</div>
                    </div>
                </div>
            </div>
    	</div>
	</div>
</div>
</form>
<script>
    layui.use(['element','form'], function(){
    	var form = layui.form;
    	form.on('submit(formDemo)', function(data){
    	    $.ajax({
    	    	url:"{{url('/admin/config')}}",
                type:'POST',
                headers: {
    	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	        },  
    	        data:{'info':data.field},
                success:function(res){
                   if(res.code==0){
                	   layer.msg(res.msg); 
                	   window.location.reload() 
                   }else{
                	   layer.alert('保存失败!'); 
                   }
                }
            });
    	    return false;
    	});
    });
</script>
@endsection
 