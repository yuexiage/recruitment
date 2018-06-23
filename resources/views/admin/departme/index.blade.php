<?php
/** 
 * PHP是世界上最好的语言！
 * @Author yuexiage
 * @Date 2018年6月21日 下午10:18:01 
 * @Email 418221610@qq.com
*/ 
?>
@extends('layouts.app')
@section('content')
<link href="{{ asset('css/jquery.orgchart.css?v=1') }}" rel="stylesheet">
<script src="{{ asset('js/jquery.orgchart.js') }}"></script>
<div id="chart-container"></div>
<div class="ibox-content" id="edit_box" style="display: none">
    <form class="layui-form" action="" id="editForm">
        <input type="hidden" name="id" id="id"/>
        <div class="form-group">
            <label class="col-sm-3 control-label"><sub>*</sub>部门名称：</label>
            <div class="input-group col-sm-7">
                <input id="e_node_name" type="text" class="form-control" name="departme_name" lay-verify="required" required aria-required="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label"><sub>*</sub>别名：</label>
            <div class="input-group col-sm-7">
                <input id="e_control_name" type="text" class="form-control" name="alias" lay-verify="required" required aria-required="true" placeholder="全小写">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-8">
                <button class="btn btn-primary" type="submit" lay-submit lay-filter="formDemo">提交</button>
            </div>
        </div>
    </form>
</div>
<script>
layui.use(['element','form'], function(){
	var form = layui.form;
	form.on('submit(formDemo)', function(data){
		$.ajax({
	    	url:"{{url('/admin/departme')}}",
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
            	   layer.alert(res.msg); 
               }
            }           
        });
	    return false;
	});
});
</script>
<script>
$(function() {
    $('#chart-container').orgchart({
        'data' : "{{url('/admin/departme/getdepartme')}}",
        'nodeContent': 'title',
        'parentNodeSymbol': 'fa-th-large',
        'createNode': function($node, data) {
            console.log($node);
            console.log(data);
            var box;
            $node.on('click', function(event) {
            	layer.close(box);
            	var id = data.id;
            	$("#id").val(id);
            	if(id=='1'){
            		layui.use('layer', function(){
                        box = layer.open({
                            type: 1,
                            title: '添加 ' + data.title + ' 的部门',
                            anim: 2,
                            skin: 'layui-layer-molv', //加上边框
                            area: ['620px', '240px'], //宽高
                            content: $('#edit_box')
                        });
                	});
                }
                
            });
		}
	});
});
</script>
@endsection