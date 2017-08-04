<?php

namespace App\Http\Controllers;
use App\Http\Controllers\VKUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;


class Versus extends Controller
{

    public $userinfo;
    function __construct()
    {
        new VKUsers();
        $this->userinfo = VKUsers::$a;
    }

    static public function activity($uid, $type, $text)
    {

        DB::table('do_log_activity')->insert(array(
            'uid' => $uid,
            'type' => $type,
            'text' => $text
        ));
    }

    static public function getExpAndMoney($uid, $exp, $money){
        DB::update('UPDATE do_user SET exp = exp + '.$exp.', coins = coins + '. $money.' where id = '.$uid);
        Versus::activity($uid,'4', 'Турнир завершен. Ты получаешь ' . $money.' кристаллов и ' . $exp .' очков опыта!');
    }



    public function cron(){
        /* Обновление.... */
        $song_id = DB::select('SELECT * FROM do_music ORDER BY rand() LIMIT 1')[0];

        DB::table('do_versus')->insert([
            'song_id' => $song_id->id
        ]);



        /*  Награждение победителей!  */
        $versusSong = DB::select('SELECT  (SELECT song_id FROM do_versus WHERE DATE_FORMAT(date, \'%Y-%m-%d\') = CURDATE()) as song_id, 
(SELECT COALESCE(song_id,0) FROM do_versus WHERE DATE_FORMAT(date, \'%Y-%m-%d\') = CURDATE() - INTERVAL 1 DAY) as tomorrow_song_id,
(SELECT CONCAT(do_music.author, \' - \', do_music.name) FROM do_music WHERE do_music.id = song_id) as song_name,
(SELECT CONCAT(do_music.author, \' - \', do_music.name) FROM do_music WHERE do_music.id = tomorrow_song_id) as tomorrow_song_name')[0];
        if($versusSong->tomorrow_song_id > 0){
            $allVersuses = DB::select('SELECT uid FROM do_log WHERE DATE_FORMAT(do_log.danced_at, \'%Y-%m-%d\') = CURDATE() - INTERVAL 1 DAY AND song_id = '.$versusSong->tomorrow_song_id.' GROUP BY uid');
            $allVersuses = count($allVersuses);

            $getLog = DB::table('do_log')->join('do_user', 'do_user.id', '=', 'do_log.uid')
                ->select(DB::raw('sum(do_log.score) as score'), 'do_user.name', 'do_user.last', 'do_user.mid', 'do_user.id')
                ->where([
                    ['do_log.song_id', '=', $versusSong->tomorrow_song_id],
                    [DB::raw('DATE_FORMAT(do_log.danced_at, \'%Y-%m-%d\')'), '=', DB::raw('CURDATE() - INTERVAL 1 DAY')],
                ])->groupby('do_log.uid')->orderby('score', 'desc')->limit(5)->get();
            foreach ($getLog as $k=>$item) {
                if($k == 0){
                    Versus::getExpAndMoney($item->id, ($allVersuses*1000), ($allVersuses*10));
                    echo 'ID:'. $item->id.' exp: ' .($allVersuses*1000).', money: ' . ($allVersuses*10);
                }
                if($k == 1){
                    Versus::getExpAndMoney($item->id, ($allVersuses*700), ($allVersuses*7));
                    echo 'ID:'. $item->id.' exp: ' .($allVersuses*700).', money: ' . ($allVersuses*7);
                }
                if($k == 2){
                    Versus::getExpAndMoney($item->id, ($allVersuses*500), ($allVersuses*5));
                    echo 'ID:'. $item->id.' exp: ' .($allVersuses*500).', money: ' . ($allVersuses*5);
                }
                if($k == 3){
                    Versus::getExpAndMoney($item->id, ($allVersuses*300), ($allVersuses*3));
                    echo 'ID:'. $item->id.' exp: ' .($allVersuses*300).', money: ' . ($allVersuses*3);
                }
                if($k == 4){
                    Versus::getExpAndMoney($item->id, ($allVersuses*200), ($allVersuses*2));
                    echo 'ID:'. $item->id.' exp: ' .($allVersuses*200).', money: ' . ($allVersuses*2);
                }
            }
        }





    }

    public function index(){
        if(!Session::has('user')){
            return redirect('/');
        }
        /*
         * SELECT  (SELECT song_id FROM do_versus WHERE DATE_FORMAT(date, '%Y-%m-%d') = CURDATE()) as song_id,
(SELECT COALESCE(song_id,0) FROM do_versus WHERE DATE_FORMAT(date, '%Y-%m-%d') = CURDATE() - INTERVAL 1 DAY) as tomorrow_song_id
         * */
        $versusSong = DB::select('SELECT  (SELECT song_id FROM do_versus WHERE DATE_FORMAT(date, \'%Y-%m-%d\') = CURDATE()) as song_id, 
(SELECT COALESCE(song_id,0) FROM do_versus WHERE DATE_FORMAT(date, \'%Y-%m-%d\') = CURDATE() - INTERVAL 1 DAY) as tomorrow_song_id,
(SELECT COALESCE(sum(do_log.score),0) from do_log where uid = '.$this->userinfo['user']->id.' AND DATE_FORMAT(danced_at, \'%Y-%m-%d\') = CURDATE() AND do_log.song_id = ((SELECT song_id FROM do_versus WHERE DATE_FORMAT(date, \'%Y-%m-%d\') = CURDATE()))) as user_score, 
(SELECT CONCAT(do_music.author, \' - \', do_music.name) FROM do_music WHERE do_music.id = song_id) as song_name,
(SELECT CONCAT(do_music.author, \' - \', do_music.name) FROM do_music WHERE do_music.id = tomorrow_song_id) as tomorrow_song_name')[0];
        /*
         * SELECT sum(l.score) as score, u.name, u.last
FROM `do_log`  l
JOIN do_user u ON l.uid = u.id

WHERE song_id = 1 and DATE_FORMAT(l.danced_at, '%Y-%m-%d') = CURDATE()
GROUP by uid
ORDER by score desc
limit 5

         */
if(!$versusSong->song_id){
    return 'Подведение результатов... Пожалуйста, зайдите позже.';
}
        $allVersuses = DB::select('SELECT uid FROM do_log WHERE DATE_FORMAT(do_log.danced_at, \'%Y-%m-%d\') = CURDATE() AND song_id = '.$versusSong->song_id.' GROUP BY uid');
        DB::enableQueryLog();
        $getLog = DB::table('do_log')->join('do_user', 'do_user.id', '=', 'do_log.uid')
            ->select(DB::raw('sum(do_log.score) as score'), 'do_user.name', 'do_user.last', 'do_user.mid', 'do_user.id')
            ->where([
                ['do_log.song_id', '=', $versusSong->song_id],
                [DB::raw('DATE_FORMAT(do_log.danced_at, \'%Y-%m-%d\')'), '=', DB::raw('CURDATE()')],
            ])->groupby('do_log.uid')->orderby('score', 'desc')->limit(5)->get();
//return dd(DB::getQueryLog());
        foreach ($getLog as $l) {
            $l->score = DOApi::number_format_short($l->score);
        }
        $getLog->prizes = count($allVersuses);
        $getLogTomorrow = DB::table('do_log')->join('do_user', 'do_user.id', '=', 'do_log.uid')
            ->select(DB::raw('sum(do_log.score) as score'), 'do_user.name', 'do_user.last', 'do_user.mid', 'do_user.id')
            ->where([
                ['do_log.song_id', '=', $versusSong->tomorrow_song_id],
                [DB::raw('DATE_FORMAT(do_log.danced_at, \'%Y-%m-%d\')'), '=', DB::raw('CURDATE() - INTERVAL 1 DAY')],
            ])->groupby('do_log.uid')->orderby('score', 'desc')->limit(5)->get();
        foreach ($getLogTomorrow as $l) {
            $l->score = DOApi::number_format_short($l->score);
        }

        $this->userinfo['user']->coins = DOApi::number_format_short($this->userinfo['user']->coins);
        $this->userinfo['user']->exp = DOApi::number_format_short($this->userinfo['user']->exp);
        return view('versus', array('l' => $getLog, 't' => $getLogTomorrow, 'v' => $versusSong, 'u' => $this->userinfo['user'], 'a' => $this->userinfo['act'], 'new' => $this->userinfo['new']));
    }
}
