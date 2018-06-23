<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class TestController extends Controller
{
    //
    
    public function index(){
        echo route('login');exit;
        $user = Auth::User()->find(2);
        $user->guard_name = 'web2';
        $user->assignRole(['部门经理']);
        #Permission::create(['name' => 'writer']);
        #$user->guard_name = 'web2';
        
        #echo $role = Role::create(['name' => '部门经理','guard_name'=>'web2']);;
    }
}
