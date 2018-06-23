<?php

namespace App\Http\Controllers\Admin;
use App\models\usersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class usersController extends Controller
{
    private $view_data = [];
    public function index(){
        
        return view('admin/users/list');
    }
    
    /**
     * 获取用户列表
     */
    public function getUsers(Request $request){
        if($request->ajax()){
            $input  = $request->all();
            $limit  = $input['pageSize'];
            $offset = ($input['pageNumber'] - 1) * $limit;
            $where  = [];
            if (!empty($input['searchText'])) {
                $where[]  = ['name','like', '%' . $input['searchText'] . '%'];
            }
            $users  = usersModel::where($where)
                    ->select(DB::raw('id,name,email,case when backuser =1 THEN "<span class=\"layui-badge layui-bg-green\">是</span>" WHEN backuser =0 THEN "<span class=\"layui-badge layui-bg-gray\">否</span>" END as backuser,case when isadmin =1 THEN "<span class=\"layui-badge layui-bg-green\">是</span>" WHEN isadmin =0 THEN "<span class=\"layui-badge layui-bg-gray\">否</span>" END as isadmin ,case when checkout =1 THEN "<span class=\"layui-badge layui-bg-badge\">是</span>" WHEN checkout =0 THEN "<span class=\"layui-badge layui-bg-gray\">否</span>" END as checkout ,created_at'))->offset($offset)->limit($limit)->get();
            foreach($users as $key=>$vo){
                $users[$key]['operate'] = $this->showOperate($this->makeButton($vo['id']));
            }
            $return =[];
            $return['total']    = usersModel::where($where)->count();  // 总数据
            $return['rows']     = $users;
            return response()->json($return);
        }
    }
    
    /**
     * 拼装操作按钮
     * @param $id
     * @return array
     */
    private function makeButton($id)
    {
        return [
            '编辑' => [
                'auth' => 'role/roleedit',
                'href' => url("admin/role/$id/edit"),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'role/roledel',
                'href' => "javascript:roleDel(" .$id .")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ],
            '分配权限' => [
                'auth' => 'role/giveaccess',
                'href' => "javascript:giveQx(" .$id .")",
                'btnStyle' => 'info',
                'icon' => 'fa fa-institution'
            ],
        ];
    }
    
    function showOperate($operate = [])
    {
        if(empty($operate)){
            return '';
        }
        $option = '';
        foreach($operate as $key=>$vo){
            $option .= ' <a href="' . $vo['href'] . '"><button type="button" class="btn btn-' . $vo['btnStyle'] . ' btn-sm">'.
                '<i class="' . $vo['icon'] . '"></i> ' . $key . '</button></a>';
        }
        return $option;
    }
}
