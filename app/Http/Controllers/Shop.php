<?php
namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\VKUsers;

use App\Http\Controllers\DOApi;

class Shop extends Controller
{
    public $userinfo;
    function __construct()
    {
        new VKUsers();
        $this->userinfo = VKUsers::$a;
    }


    public function show(){
        if (!Session::has('user')) {
            return redirect('/');
        }
        $items = DB::select('SELECT s.id, s.cat, s.days, s.price, i.name, i.description, i.image FROM do_shop s 
                             JOIN  do_items i ON s.item_id = i.id 
                             WHERE s.visible = 1
                             ORDER BY s.cat DESC, s.price ASC');
        $this->userinfo['user']->coins = DOApi::number_format_short($this->userinfo['user']->coins);
        $this->userinfo['user']->exp = DOApi::number_format_short($this->userinfo['user']->exp);
        return view('shop', array('items' => $items, 'u' => $this->userinfo['user'], 'a' => $this->userinfo['act'], 'new' => $this->userinfo['new']));

    }

    public function buy($id){
        $userinfo = $this->userinfo['user'];
        $msg = 'Something BUG!';
        if (!Session::has('user')) {
            return redirect('/');
        }
        $itemInfo = DB::table('do_shop')->where(['id' => $id, 'visible' => 1])->first();
        if(!count($itemInfo)){
            return abort(404);
        }else{
            if($userinfo->coins >= $itemInfo->price){
                if($itemInfo->days == '-1') {
                    $itemInfo->days = '3650'; //86400
                }
                    $addItems = DB::table('do_user_items')->insert(
                        ['uid' => $userinfo->id, 'item_id' => $id, 'ended' => DB::raw('DATE_ADD(NOW(), INTERVAL '.$itemInfo->days.' DAY)')]);
                DB::table('do_user')->where('id', $userinfo->id)->decrement('coins', $itemInfo->price);

                    if($addItems){
                        $msg = 'Спасибо за покупку! <3';
                    }else{
                        $msg = 'Ошибка БД!';
                    }

            }else{
                $msg = 'Недостаточно средств!';
            }
            return response()->json($msg);
        }
    }

}
