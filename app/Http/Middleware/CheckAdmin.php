<?php

namespace App\Http\Middleware;

use Closure;
use App\models\ConfigModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //配置信息
        if (!Cache::has('admin_config')) {
            $config         = ConfigModel::first();
            $config         = json_decode($config->content,true);
            $expiresAt = now()->addMinutes(5);
            Cache::put('admin_config', $config, $expiresAt);
        }
        
        
        $controller     = request()->route()->getAction()['controller'];
        list($controller, $action) = explode('@', $controller);
        $controller     = substr(strrchr($controller,'\\'),1);
        if($controller =='LoginController' && $action=='doLogin'){
            //登录
            $milkcaptcha = Session('milkcaptcha');                                      #验证码
            if($request['code'] !== $milkcaptcha){
                $request['login_error'] = ['code'=>1,'msg'=>'验证码错误!'];
            }
            $username   = $request['user_name'];
            $password   = $request['password'];
            if(empty($username) || empty($password)){
                $request['login_error'] =  ['code'=>1,'msg'=>'请输入完整信息!'];
            }
            
            if (Auth::attempt(['name' => $username, 'password' => $password,'checkout'=>0,'backuser'=>1])) {        #登录
                // 认证通过...
                $user   = Auth::user()->toArray();
                session()->put('user',$user);
                if($user['isadmin']){
                    session()->put('user.permission ','all');
                    $request['login_success'] =  ['code'=>0,'data'=>'/admin', 'msg'=>'管理员登录成功!'];
                }else{                                                                  #权限验证    
                       //权限判断
                       
                }
            }else{
                $request['login_error'] = ['code'=>1,'msg'=>'登录失败!'];
            }
        }else{
            $session_user = session('user');
            if(!$session_user){
                return redirect('/admin/login');
            }else{
                $user = Auth::user();
                //权限判断
                $roles = $user->getRoleNames();
                session()->put('user.role ',$roles->toArray());
            }
            
        }
        return $next($request);
    }
}
