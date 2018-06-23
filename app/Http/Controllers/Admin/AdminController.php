<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        ##$this->middleware('auth');
    }
    
    public function index(){
        $user = session('user');    
        return view('index',$user);
    }
    
    /**
     * 后台默认首页
     * @return mixed
     */
    public function indexPage()
    {
        return view('admin/index');
    }
}
