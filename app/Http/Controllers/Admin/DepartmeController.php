<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\models\DepartmeModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;

class DepartmeController extends Controller
{
    public function index(){

        return view('admin/departme/index');
    }
    
    //保存
    public function store(Request $request){
        $input          = $request->all();
        $data           = $input['info'];
        $count          = DepartmeModel::where(['departme_name'=>$data['departme_name'],'alias'=>$data['alias']])->count();
        if($count){
            return response()->json(['code' => '1', 'msg' => '部门已存在,不能重复添加!']);
        }else{
            $res        = DepartmeModel::insert(['departme_name'=>$data['departme_name'],'alias'=>$data['alias'],'level'=>$data['id']]);
            if($res){
                //创建权限
                $role = Role::create(['name' => $data['alias'],'guard_name'=>$data['alias']]);
                return response()->json(['code' => '0', 'msg' => '保存成功!']);
            }else {
                return response()->json(['code' => '1', 'msg' => '保存失败!']);
            }
        } 
    }
    
    //获取部门
    public function getDepartme(){
        $config             = Cache::get('admin_config');
        $arr                = ['name'=>'公司名称','title'=> $config['sitename'],'id'=>1];
        $childrens          = DepartmeModel::select('id','departme_name','alias','level')->get()->toArray();
        foreach ($childrens as $children ){
            $arr['children'][]    = ['name'=>$children['departme_name'],'title'=> $children['alias'],'id'=>$children['id']];
        }
        
        return json_encode($arr);
    }
}
