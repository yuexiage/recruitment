<?php
/** 
 * PHP是世界上最好的语言！
 * @Author yuexiage
 * @Date 2018年6月21日 下午10:18:01 
 * @Email 418221610@qq.com
*/ 
?>
@extends('layouts.app') @section('content')
<link href="{{asset('css/plugins/bootstrap-table/bootstrap-table.min.css')}}" rel="stylesheet">
<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
	@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
	@endif
		<!-- Panel Other -->
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>职位列表</h5>
			</div>
			<div class="ibox-content">
				<div class="form-group clearfix col-sm-1">
					@if (session('user')['isadmin']==1)
						<a href="{{url('/admin/position/-1/edit')}}">
							<button class="btn btn-outline btn-primary" type="button">添加职位</button>
						</a>
					@endif
				</div>
				<!--搜索框开始-->
				<form id='commentForm' position="form" method="post" class="form-inline pull-right">
					<div class="content clearfix m-b">
						<div class="form-group">
							<label>管理员名称：</label> <input type="text" class="form-control"
								id="positionname" name="positionname">
						</div>
						<div class="form-group">
							<button class="btn btn-primary" type="button"
								style="margin-top: 5px" id="search">
								<strong>搜 索</strong>
							</button>
						</div>
					</div>
				</form>
				<!--搜索框结束-->

				<div class="example-wrap bootstrap-table ">
					<div class="example fixed-table-container">
						<table id="cusTable" class="table table-hover table-striped">
							<thead>
								<th data-field="id">职位ID</th>
								<th data-field="name">职位名称</th>
								<th data-field="guard_name">看守</th>
								<th data-field="operate">操作</th>
							</thead>
						</table>
					</div>
				</div>
				<!-- End Example Pagination -->
			</div>
		</div>
	</div>
	<!-- End Panel Other -->
	</div>
	<!-- 职位分配 -->
	<div class="zTreeDemoBackground left" style="display: none" id="position">
		<input type="hidden" id="nodeid">
		<div class="form-group">
			<div class="col-sm-5 col-sm-offset-2">
				<ul id="treeType" class="ztree"></ul>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-4 col-sm-offset-4" style="margin-bottom: 15px">
				<input type="button" value="确认分配" class="btn btn-primary"
					id="postform" />
			</div>
		</div>
	</div>
</body>
<script src="{{ asset('js/plugins/bootstrap-table/bootstrap-table.min.js?v=') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js?v=') }}"></script>
<script>
function initTable() {
    //先销毁表格
    $('#cusTable').bootstrapTable('destroy');
    //初始化表格,动态从服务器加载数据
    $("#cusTable").bootstrapTable({
        method: "get",  //使用get请求到服务器获取数据
        url: "{{url('admin/position/getpositionList')}}", //获取数据的地址
        striped: true,  //表格显示条纹
        pagination: true, //启动分页
        pageSize: 10,  //每页显示的记录数
        pageNumber:1, //当前第几页
        pageList: [5, 10, 15, 20, 25],  //记录数可选列表
        sidePagination: "server", //表示服务端请求
        paginationFirstText: "首页",
        paginationPreText: "上一页",
        paginationNextText: "下一页",
        paginationLastText: "尾页",
        queryParamsType : "undefined",
        queryParams: function queryParams(params) {   //设置查询参数
            var param = {
                pageNumber: params.pageNumber,
                pageSize: params.pageSize,
                searchText:$('#positionname').val()
            };
            return param;
        },
        onLoadSuccess: function(res){  //加载成功时执行
            if(111 == res.code){
                window.location.reload();
            }
            layer.msg("加载成功", {time : 1000});
        },
        onLoadError: function(){  //加载失败时执行
            layer.msg("加载数据失败");
        }
    });
}
$(document).ready(function () {
    //调用函数，初始化表格
    initTable();
    //当点击查询按钮的时候执行
    $("#search").bind("click", initTable);

});
function positionDel(id){
    layer.confirm('确认删除此职位?', {icon: 3, title:'提示'}, function(index){
        //do something
    	$.ajax({
	    	url:"{{url('/admin/position/')}}"+'/'+id,
            type:'POST',
            headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },  
	        data:{'_method':'DELETE'},
            success:function(res){
               if(res.code==0){
            	   layer.msg(res.msg); 
            	   //window.location.reload() 
               }else{
            	   layer.alert(res.msg); 
               }
            }           
        });


        /* $.getJSON("{{url('/admin/position')}}", {'id' : id}, function(res){
            if(1 == res.code){
                layer.alert(res.msg, {title: '友情提示', icon: 1, closeBtn: 0}, function(){
                    initTable();
                });
            }else if(111 == res.code){
                window.location.reload();
            }else{
                layer.alert(res.msg, {title: '友情提示', icon: 2});
            }
        }); */


        

        layer.close(index);
    })

}
</script>
@endsection
