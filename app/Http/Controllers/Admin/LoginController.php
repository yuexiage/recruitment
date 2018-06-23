<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    //
    public function index(){
        if (Auth::check()) {
            return redirect('/admin/index');
        }
        return view('admin/login');
    }

    public function doLogin(Request $request){
        $input  = $request->all();
        if(isset($input['login_error'])){
            return $input['login_error'];
        }elseif($input['login_success']){
            return $input['login_success'];
        }
    }
    
    public function logout(){
        Auth::logout();
        return redirect('/admin/login');
    }
}
