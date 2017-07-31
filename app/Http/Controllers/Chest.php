<?php
/**
 * Created by PhpStorm.
 * User: Loc
 * Date: 30.07.2017
 * Time: 19:12
 */

namespace App\Http\Controllers;
use App\Http\Controllers\VKUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;


class Chest extends Controller
{

    public $userinfo;
    function __construct()
    {
        new VKUsers();
        $this->userinfo = VKUsers::$a;
    }
    public function dialy(){
        $userinfo = $this->userinfo['user'];
        if($userinfo->chest == 'ready' OR $userinfo->chest == 'none'){
            $item = array(9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 9, 6, 4, 5, 4, 5, 4, 5, 4, 5, 4, 5, 4, 5, 4, 5, 4, 5, 4, 5, 4, 5, 7, 8, 7, 8, 7, 8, 7, 8, 7, 8, 7, 8, 7, 8, 7, 8, 7, 8, 10, 11, 10, 11, 10, 11, 10, 11 );
            $item = $item[rand(0, count($item)-1)];
            $times = array(1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 4, 4, 5, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 4, 4, 5, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 4, 4, 5, 24);
            $times = $times[rand(0,count($times)-1)];
            $itemInfo = DB::table('do_items')->where('id', $item)->first();
            DB::table('do_user_items')->insert([
                'uid' => $userinfo->id,
                'item_id' => $item,
                'ended' => DB::raw('DATE_ADD(NOW(), interval '.$times.' hour)'),
            ]);
            if($userinfo->dialy_chest == 'none'){
                DB::table('do_user_chest')->insert([
                    'uid' => $userinfo->id,
                    'item_id' => $item,
                ]);
            }else{
                DB::table('do_user_chest')->where('uid', $userinfo->id)->update([
                    'opened_at' => DB::raw('NOW()'),
                    'item_id' => $item,
                ]);

            }
            $msg = 'Поздравляем, ты получаешь бонус к каждому танцу! ' . PHP_EOL . $itemInfo->name.' на ' . $times . ' час(а).';

        }else{
            $msg = 'Сундук ещё закрыт!';
        }
        return response()->json($msg);
    }
}