<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\VKUsers;

use App\Http\Controllers\DOApi;

class SocialApi extends Controller
{
    public $userinfo;

    function __construct()
    {
        new VKUsers();
        $this->userinfo = VKUsers::$a;
    }

    public function editProfile()
    {
        if (!Session::has('user')) {
            return redirect('/');
        }
        return view('default', array( 'u' => $this->userinfo['user'], 'a' => $this->userinfo['act'], 'new' => $this->userinfo['new']));
    }

    public function anotherProfile($id = 0)
    {
        /*
         * select u.*, s.name as status_name, s.color as status_color, MAX(l.lvl) as lvl, sum(pow.bonus) as pow
from do_user u
JOIN do_levels l ON u.exp >= l.exp
JOIN do_user_status s ON u.status = s.id
JOIN do_user_power pow ON u.id = pow.uid AND pow.type = 1
where u.id = 5
         * */
        //userinfo = $this->userinfo['user']->{param here}
        //another user = $user

        if (!Session::has('user')) {
            return redirect('/');
        }
        if ($id == 0) {
            return redirect('/profile/' . $this->userinfo['user']->id);
        }


        $user = DB::select('SELECT u.*, s.name AS status_name, s.color AS status_color, max(l.lvl) AS lvl, 
COALESCE((
    
SELECT sum(i.value) 
FROM do_user_items doi 
JOIN do_items i ON doi.item_id = i.id
WHERE doi.uid = u.id AND i.type = \'exp_bonus\' AND ended > CURRENT_TIMESTAMP
    
),0) AS exp_bonus,
COALESCE((

    SELECT sum(i.value) 
FROM do_user_items doi 
JOIN do_items i ON doi.item_id = i.id
WHERE doi.uid = u.id AND i.type = \'dmn_bonus\' AND ended > CURRENT_TIMESTAMP
    

),0) AS dmn_bonus
FROM do_user u
JOIN do_levels l
JOIN do_user_status s ON u.status = s.id 

WHERE u.id =?  AND u.exp >= l.exp ', [$id])[0];
        if (!$user->id) {
            return redirect('/profile');
        }


        $user->oldMoney = $user->coins;
        $this->userinfo['user']->coins = DOApi::number_format_short($this->userinfo['user']->coins);
        $user->coins = DOApi::number_format_short($user->coins);
        $user->maxExp = $user->exp;
        $this->userinfo['user']->exp = DOApi::number_format_short($this->userinfo['user']->exp);
        $user->exp = DOApi::number_format_short($user->exp);

        //**Расчет процента до следующего уровня.
        $lvlPercent = array();
        $lvlPercent['percent'] = 0;
        if ($user->lvl < 100 and $user->lvl != 1 and $user->lvl != 2) {
            $prevLvl = DB::table('do_levels')->select('exp')->where('exp', '<', $user->maxExp)->first();
            $prevLvl = $prevLvl->exp;
            $nextLvl = DB::table('do_levels')->select('exp')->where('exp', '>', $user->maxExp)->first();
            $nextLvl = $nextLvl->exp;
            //$lvlPercent['percent'] = $user->maxExp / $nextLvl;
            $lvlPercent['percent'] = ($nextLvl - $user->maxExp) / ($nextLvl - $prevLvl);
        } elseif ($user->lvl == 1) {
            $nextLvl = DB::table('do_levels')->select('exp')->where('exp', '>', $user->maxExp)->first();
            $nextLvl = $nextLvl->exp;
            $lvlPercent['percent'] = $user->maxExp / $nextLvl;

        } elseif ($user->lvl == 2) {
            $nextLvl = DB::table('do_levels')->select('exp')->where('exp', '>', $user->maxExp)->first();
            $nextLvl = $nextLvl->exp;
            $lvlPercent['percent'] = $user->maxExp / $nextLvl;

        } else {
            $lvlPercent['percent'] = 1;
            $nextLvl = 0;
        }
        $medals = DB::select('SELECT i.* FROM do_user_items dum 
JOIN do_items i ON dum.item_id = i.id
WHERE uid = ? AND ended > CURRENT_TIMESTAMP AND  i.type = \'medals\'', [$id]);
        $lvlPercent['now'] = $user->maxExp;
        $lvlPercent['next'] = $nextLvl;


        //**Расчет процента успешности танца
        $danceProc = DB::select('SELECT COALESCE(AVG(exp), 0) AS proc FROM do_log WHERE uid = ?', [$id])[0];
        $danceProc = $danceProc->proc / 8888;

        return view('profile', array('my' => false, 'medals' => $medals, 'p' => $user, 'u' => $this->userinfo['user'], 'a' => $this->userinfo['act'], 'new' => $this->userinfo['new'], 'lvlPerc' => $lvlPercent, 'danceProc' => $danceProc));
    }

}