<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\models\RoleModel;
use Illuminate\Http\Request;
use App\models\DepartmeModel;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    private $view_data = [];
    public function index() {
        #$role = Role::create(['name' => '技术员','guard_name'=>'web3']);
        return view('admin.role.index');
    }
    
    /**
     * AJAX获取角色列表
     * @param Request $Request
     */
    public function getRoleList(Request $Request){
        if($Request->ajax()){
            $input  = $Request->all();
            $limit  = $input['pageSize'];
            $offset = ($input['pageNumber'] - 1) * $limit;
            $where  = [];
            if (!empty($input['searchText'])) {
                $where['name']  = ['like', '%' . $input['searchText'] . '%'];
            }
            $roles  = RoleModel::where($where)->offset($offset)->limit($limit)->get();
            foreach($roles as $key=>$vo){
                $roles[$key]['operate'] = $this->showOperate($this->makeButton($vo['id']));
            }
            $return =[];
            $return['total']    = RoleModel::where($where)->count();  // 总数据
            $return['rows']     = $roles;
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
    
    /**
     * 修改
     */
    function edit($role_id,Request $request){
        $role = RoleModel::where(['id'=>$role_id])->first();  
        $departme           = DepartmeModel::all();
        $data['role']       = $role;
        $data['departme']   = $departme;
        return view('admin.role.edit',$data);
    }
    
    /**
     * 保存
     */
    function store(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|max:255'
        ],['required' => '请确保"角色名称"不为空!!']);
        if($validator->fails()){
           return back()->withErrors($validator)
            ->withInput();
        }
        
        if($input['role_id']!=-1){
            //更新
            $role = RoleModel::find($input['role_id']);
            $role->name         = $input['name'];
            $role->guard_name   = $input['guard_name'];
            $role->save();
        }else{
            //插入
            $role = new RoleModel;
            $role->name         = $input['name'];
            $role->guard_name   = $input['guard_name'];
            $role->save();
        }
        return redirect('admin/role')->with('message', '操作成功!!');
    }
    
    /**
     * 删除角色
     */
    
    public function destroy($id,Request $request){
        $input = $request->all();
        
    }
   
}
