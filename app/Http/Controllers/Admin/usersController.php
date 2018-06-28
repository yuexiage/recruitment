<?php

namespace App\Http\Controllers\Admin;
use Validator;
use App\User;
use App\models\RoleModel;
use App\models\usersModel;
use Illuminate\Http\Request;
use App\models\DepartmeModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
class usersController extends Controller
{
    private $view_data = [];
    public function index(){
        /* $name = 'vilin';
        $flag = Mail::send('emails.index',['name'=>$name],function($message){
            $to = '418221610@qq.com';
            $message ->to($to)->subject('测试邮件');
        });
            var_export($flag);
         */
        
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
     * 修改信息
     * @param string $user_id
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit($user_id,Request $request){
        if($user_id!=-1){
            $user = usersModel::where('id',$user_id)->first();
            if(empty($user)){
                abort('404');
            }
            $view_data['user']      = $user;
        }
        //获取所有角色
        $departmes                  = DepartmeModel::all();
        $view_data['departmes']     = $departmes;
        return view('admin.users.edit',$view_data);
    }

    /**
     * 保存用户信息
     * @param Request $request
     * @throws \Exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        try {
            $rules = [
                'name'      => 'required|alpha_num',
                'email'     => 'required|email',
                'departme'  => 'required',
                'user_id'   => 'required'
            ];
            if($request->password!=''){
                $rules['password']                  = 'confirmed';
                $rules['password_confirmation']     = 'required';
            }
            $messages = [
                'name.required'     => '姓名不能为空!',
                'email.required'    => '邮箱不能为空!',
                'email.email'       => '邮箱格式错误!',
                'departme.required' => '请选择部门!',
                'user_id.required'  => '用户信息为空!',
            ];
            $validator = Validator::make($request->all(), $rules,$messages);
            if ($validator->fails()) {
                throw new \Exception($validator->errors(),1);
            }
            //判断用户邮箱和用户名是否存在
            if($request->user_id==-1){
                $hasUser            = User::whereRaw('email = ? or name = ?',[$request['email'],$request['name']])->count();
                if($hasUser){
                    throw new \Exception('用户信息已存在',1);
                }
            }

            //保存用户信息
            $data                   = [];
            $data['name']           = $request['name'];
            $data['email']          = $request['email'];
            if($request->password!=''){
                $data['password']   =  bcrypt($request['password']);
            }
            $data['backuser']       = 1;
            $data['departme_alias'] = $request['departme'];
            if($request->user_id==-1){
                User::create($data);
            }else{
                User::where('id',$request['user_id'])->update($data);
            }
            return response()->json(['code' => 0,'data' => '','msg'  =>'保存成功!']);
        } catch (\Exception $e) {
            return response()->json(['code' => $e->getCode(),'data' => '','msg'  =>$e->getMessage()]);
        }
    }
    
    public function delete($id){
        try {
            if(empty($id)){
                throw new \Exception('信息错误!',1);
            }
            $count = User::where('id',$id)->count();
            if(!$count){
                throw new \Exception('无效用户ID!',1);
            }
            User::where('id',$id)->delete();
            return response()->json(['code' => 0,'data' => '','msg'  =>'删除成功!']);
        } catch (\Exception $e) {
            return response()->json(['code' => $e->getCode(),'data' => '','msg'  =>$e->getMessage()]);
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
                'href' => url("admin/users/$id/edit"),
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
