<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\VKUsers;

use App\Http\Controllers\DOApi;
use function MongoDB\BSON\toJSON;

class DORating extends Controller
{
    public $userinfo;
    function __construct()
    {
        new VKUsers();
        $this->userinfo = VKUsers::$a;
    }

    function romanic_number($integer, $upcase = true)
    {
        $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
        $return = '';
        while($integer > 0)
        {
            foreach($table as $rom=>$arb)
            {
                if($integer >= $arb)
                {
                    $integer -= $arb;
                    $return .= $rom;
                    break;
                }
            }
        }

        return $return;
    }

    public function all(){
        if(!Session::has('user')){
            return redirect('/');
        }
        $userinfo = $this->userinfo['user'];
        $this->userinfo['user']->coins = DOApi::number_format_short($this->userinfo['user']->coins);
        $this->userinfo['user']->exp = DOApi::number_format_short($this->userinfo['user']->exp);
        $rich = DB::table('do_user')->orderby('coins', 'desc')->limit(5)->get();
        $exp = DB::select('select do_user.*, max(do_levels.lvl) as lvl from do_user join do_levels WHERE do_user.exp >= do_levels.exp group by do_user.id order by lvl desc limit 5');
        //return response()->json($exp);
        $photo_50 = array();
        foreach ($rich as $k=>$r){
            $rich[$k]->coins = DOApi::number_format_short($rich[$k]->coins);
            $rich[$k]->pos = $this->romanic_number($k+1);
            $photo_50['rich'][] = $r->mid;
        }

        foreach ($exp as $k=>$r){
            //$rich[$k]->coins = DOApi::number_format_short($rich[$k]->coins);
            $exp[$k]->pos = $this->romanic_number($k+1);
            $photo_50['exp'][] = $r->mid;
        }
        $photo_50 = json_encode($photo_50);
        return view('rating', array('r50' => $photo_50, 'rich' => $rich, 'exp' => $exp ,'u' => $this->userinfo['user'], 'a' => $this->userinfo['act'], 'new' => $this->userinfo['new']));
    }

}