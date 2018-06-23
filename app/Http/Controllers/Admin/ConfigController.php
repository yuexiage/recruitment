<?php

namespace App\Http\Controllers\Admin;

use App\models\ConfigModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
class ConfigController extends Controller
{
    public function index(){
        $config     = Cache::get('admin_config');
        return view('config',$config);
    }
    
    public function store(Request $request){
        $input          = $request->all();
        $config         = json_encode($input['info']);
        $count          = ConfigModel::count();
        if($count){
            $res        = ConfigModel::where('id', 1)->update(['content' => $config]);;
        }else{
            $res        = ConfigModel::insert( ['content' => $config]);
        }
        $config         = ConfigModel::first();
        $config         = json_decode($config->content,true);
        $expiresAt      = now()->addMinutes(5);
        Cache::put('admin_config', $config, $expiresAt);
        return response()->json(['code' => '0', 'msg' => '保存成功!']);
    }
}
