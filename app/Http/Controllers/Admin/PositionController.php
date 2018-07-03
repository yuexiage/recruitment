<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PositionController extends Controller
{
    //
    public function index(Request $request){
        
        $user = session('user');
        dump($user);
        return view('admin.position.index');
    }
    
    function edit($position_id,Request $request){
        
        return view('admin.position.edit');
    }
}
