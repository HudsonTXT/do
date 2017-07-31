<?php

namespace App\Http\Controllers;

//use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VKUsers extends Controller
{
    public static $a;

    function __construct()
    {

        if(!empty($_COOKIE['vk_app_' . '4004433'])){
            $session = array();
            $member = FALSE;
            $valid_keys = array('expire', 'mid', 'secret', 'sid', 'sig');
            $app_cookie = $_COOKIE['vk_app_' . '4004433'];
            if ($app_cookie) {
                $session_data = explode('&', $app_cookie, 10);
                foreach ($session_data as $pair) {
                    list($key, $value) = explode('=', $pair, 2);
                    if (empty($key) || empty($value) || !in_array($key, $valid_keys)) {
                        continue;
                    }
                    $session[$key] = $value;
                }
                foreach ($valid_keys as $key) {
                    if (!isset($session[$key])) return $member;
                }
                ksort($session);

                $sign = '';
                foreach ($session as $key => $value) {
                    if ($key != 'sig') {
                        $sign .= ($key . '=' . $value);
                    }
                }
                $sign .= 'lQRD2OWwdElGhhteeMyF';
                $sign = md5($sign);
                if ($session['sig'] == $sign && $session['expire'] > time()) {
                    $member = array(
                        'id' => intval($session['mid']),
                        'secret' => $session['secret'],
                        'sid' => $session['sid']
                    );
                }
            }
        }else{
            $member = FALSE;
        }


        if ($member !== FALSE) {
            if (!Session::has('user')) {
                return redirect('/');
            }
            if (Session::has('user')) {
                $userinfo = DB::select('select u.*, s.name as status_name, s.color as status_color, max(l.lvl) as lvl, (SELECT CURRENT_TIMESTAMP) as time, (SELECT DATE_FORMAT( NOW( ) ,  "%Y-%m-%d 23:59:59" )) as end_day,
COALESCE((
    
select sum(i.value) 
from do_user_items doi 
JOIN do_items i ON doi.item_id = i.id
where doi.uid = u.id and i.type = \'exp_bonus\' AND ended > CURRENT_TIMESTAMP
    
),0) as exp_bonus,
COALESCE((
select sum(i.value) 
from do_user_items doi 
JOIN do_items i ON doi.item_id = i.id
where doi.uid = u.id and i.type = \'dmn_bonus\' AND ended > CURRENT_TIMESTAMP
    

), 0) as dmn_bonus,
COALESCE((

SELECT DATE_ADD(c.opened_at, INTERVAL 3 HOUR)
    FROM do_user_chest c
    WHERE c.uid = u.id 
    
    

),\'none\') as dialy_chest
from do_user u
join do_levels l
JOIN do_user_status s ON u.status = s.id 

WHERE u.id = ?  AND u.exp >= l.exp', [Session::get('user')->id])[0];
                $userinfo->time = strtotime($userinfo->time);
                if($userinfo->dialy_chest == 'none'){
                    $userinfo->chest = 'ready';
                }else{

                    $userinfo->dialy_chest = strtotime($userinfo->dialy_chest);
                    if($userinfo->time > $userinfo->dialy_chest){
                        $userinfo->chest = 'ready';
                    }else{
                        $userinfo->chest = $userinfo->dialy_chest - $userinfo->time;
                    }
                    //covert to unix $userinfo->time
                    //convert to unix $userinfo->dialy_chest
                }

                /*
                 * select u.*, s.name as status_name, s.color as status_color, max(l.lvl) as lvl, sum(pow.`value`)
    from do_user u
    join do_levels l
    JOIN do_user_status s ON u.status = s.id
    JOIN (select uid, `value` from do_user_power where do_user_power.type = 1) pow ON pow.uid = u.id
    WHERE u.id = 5 AND u.exp >= l.exp*/
            }
            //SELECT SUM(`value`) FROM `do_user_power` WHERE uid=5 and type = 1 and ended_at > CURRENT_TIMESTAMP

            $act = DB::select('SELECT date, dla.text as text, dlat.image as img
FROM do_log_activity dla
JOIN do_log_activity_types dlat ON dla.type = dlat.id
WHERE dla.uid = ' . Session::get('user')->id . '
AND dlat.visible =1
ORDER BY dla.id DESC
LIMIT 0 , 5');
            //return response()->json($las5Act[0]);
            $newActs = false;
            if ($act) {
                if (date('Y-m-d H:i:s', strtotime($userinfo->activity_update)) < date('Y-m-d H:i:s', strtotime($act[0]->date))) {
                    $newActs = true;
                }
            }
            $userinfo->end_day = strtotime($userinfo->end_day)-$userinfo->time;
            if($userinfo->usergroup >= 2){ //testers = 3, admins = 2
                self::$a = array('act' => $act, 'new' => $newActs, 'user' => $userinfo);
            }else{
                Session::flush();
            }

        } else {
            Session::flush();
        }


    }
}
