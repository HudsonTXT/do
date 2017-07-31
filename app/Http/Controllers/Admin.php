<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\VKUsers;

use App\Http\Controllers\DOApi;
class Admin extends Controller
{
    public $userinfo;
    function __construct()
    {
        new VKUsers();
        $this->userinfo = VKUsers::$a;
    }

    public function index(){
        if ($this->userinfo['user']->usergroup != 2){
            return redirect('/');
        }else{
            return view('admin/admin', array( 'u' => $this->userinfo['user'], 'a' => $this->userinfo['act'], 'new' => $this->userinfo['new']));
        }
    }

    public function usersIndex(){
        if ($this->userinfo['user']->usergroup != 2){
            return redirect('/');
        }
        $userList = DB::table('do_user')->paginate(15);

        return view('admin/users', array('list' => $userList, 'u' => $this->userinfo['user'], 'a' => $this->userinfo['act'], 'new' => $this->userinfo['new']));
    }
    public function userEdit($id){
        if ($this->userinfo['user']->usergroup != 2){
            return redirect('/');
        }
        $userList = DB::table('do_user')->paginate(15);

        return view('admin/users', array('list' => $userList, 'u' => $this->userinfo['user'], 'a' => $this->userinfo['act'], 'new' => $this->userinfo['new']));
    }
}