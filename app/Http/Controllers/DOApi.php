<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class DOApi extends Controller
{
    public $userinfo;

    function __construct()
    {
        new VKUsers();
        $this->userinfo = VKUsers::$a;
    }

    function updateUser()
    {
        new VKUsers();
        $this->userinfo = VKUsers::$a;

    }

    /*
    *************************** ЛИЧНЫЙ КАБИНЕТ - СТРАНИЦА ТАНЦА *****************************
      *********************** @dance ***********************************
        Обязательные параметры Ю и А., ЭС можно убрать, если песни не нужны.
     */
    public function lk()
    {
        if (Session::has('user')) {
            $this->userinfo['user']->coins = DOApi::number_format_short($this->userinfo['user']->coins);
            $this->userinfo['user']->exp = DOApi::number_format_short($this->userinfo['user']->exp);
            $allSongs = DB::table('do_music')->orderby('bpm', 'asc')->orderby('author', 'asc')->get();
            $tutCheck = DB::table('do_user_tutorial')->where('uid', $this->userinfo['user']->id)->get();
            $this->userinfo['user']->tut = false;
            //return response()->json($tutCheck);
            if (!count($tutCheck)) {
                $this->userinfo['user']->tut = true;
            }
            return view('dance', array('u' => $this->userinfo['user'], 's' => $allSongs, 'a' => $this->userinfo['act'], 'new' => $this->userinfo['new']));
        } else {
            return redirect('/');
        }
    }


    /*
*************************** Функция для записи лога активности *****************************
  *********************** @activityLog ***********************************
    Дай ей параметры тип и текст уведомления/лога и она запишет это, а пользователь увидит!
 */
    function activity($type, $text)
    {

        DB::table('do_log_activity')->insert(array(
            'uid' => $this->userinfo['user']->id,
            'type' => $type,
            'text' => $text
        ));
    }

    public function getExp(Request $request)
    {
        $exp = $request->exp;
        $nowLVL = $this->userinfo['user']->lvl;
        DB::table('do_user')->where('id', $this->userinfo['user']->id)->increment('exp', $exp);
        $this->updateUser();
        $sndLvl = $this->userinfo['user']->lvl;
        if ($sndLvl > $nowLVL) {
            $this->activity(2, 'Поздравляем! Ты перешел на ' . $sndLvl . ' уровень!');
        }
        $mes = 'Текущий уровень:' . $nowLVL . '; Новый: ' . $sndLvl;
        return response()->json($mes);

    }

    function plusExp($exp)
    {
        $nowLVL = $this->userinfo['user']->lvl;
        DB::table('do_user')->where('id', $this->userinfo['user']->id)->increment('exp', $exp);
        $this->updateUser();
        $sndLvl = $this->userinfo['user']->lvl;
        if ($sndLvl > $nowLVL) {
            $this->activity(2, 'Поздравляем! Ты перешел на ' . $sndLvl . ' уровень!');
        }

    }


    /*
*************************** Функция для записи лога округления цифр *****************************
  *********************** @numFormat ***********************************
    Делает большие цифры маленькими. Обычно ей обрабатываются (округляются/выводятся) кристаллы и очки опыта.
 */
    public static function number_format_short($n, $precision = 1) //K, M, Etc....
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else
            if ($n < 900000) {
                // 0.9k-850k
                $n_format = number_format($n / 1000, $precision);
                $suffix = 'K';
            } else
                if ($n < 900000000) {
                    // 0.9m-850m
                    $n_format = number_format($n / 1000000, $precision);
                    $suffix = 'M';
                } else
                    if ($n < 900000000000) {
                        // 0.9b-850b
                        $n_format = number_format($n / 1000000000, $precision);
                        $suffix = 'B';
                    } else {
                        // 0.9t+
                        $n_format = number_format($n / 1000000000000, $precision);
                        $suffix = 'T';
                    }
// Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
// Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }

        return $n_format . $suffix;
    }


    /*
*************************** Функция для записи лога округления цифр *****************************
*********************** @login ***********************************
Вызывается после авторизации ВК. Если пользователь существует, то записывает данные в сессию, а если нет то в БД.
    Нужна только при авторизации, для авторизации, после ВК!!
*/


    public function insert(Request $request)
    {
        // Api/login. Регистрация новых, проверка старых.
        $this->validate($request, [
            'auth' => 'required'
        ]);
        $vk = $request->auth;
        $vkCheckString = 'expire=' . $vk['expire'] . 'mid=' . $vk['mid'] . 'secret=' . $vk['secret'] . 'sid=' . $vk['sid'] . 'lQRD2OWwdElGhhteeMyF';
        if (md5($vkCheckString) == $vk['sig']) {
            $result = DB::table('do_user')->where('mid', $vk['user']['id'])->first();
            if (count($result) == 0) {
                $id = DB::table('do_user')->insertGetId(
                    array('mid' => $vk['user']['id'],
                        'name' => $vk['user']['first_name'],
                        'last' => $vk['user']['last_name'],
                        'href' => $vk['user']['href'],
                    )
                );
                $result = DB::table('do_user')->where('id', $id)->first();
                //insert and session start

            } else {
                $goToNew = DB::table('do_user')->where('mid', $vk['user']['id'])->update(array('name' => $vk['user']['first_name'], 'last' => $vk['user']['last_name'], 'href' => $vk['user']['href']));
                if ($goToNew) {
                    $result = DB::table('do_user')->where('mid', $vk['user']['id'])->first();
                }


            }
            $isOk = true;
            Session::put('user', $result);
        } else {
            $isOk = false;
        }

        //[$request->input('id')])
        //return $request->input();*/
        return response()->json($isOk);

    }


    /*
*************************** Функция для проверки авторизации *****************************
*********************** @check_login ***********************************
    Вызывается после глобальной авторизации пользователя.
    А также, для проверки, пользователь на сайте или нет?

    Выводит статус авторизиации loginned:true|false.
    если true выводит всю инфу из бд.
*/

    public function check()
    {
        //Api check.  Проверка по сессиям авторизации
        $resp = array();
        $resp['loginned'] = false;
        //$userSession = Session::get('user');
        if (Session::has('user')) {
            $resp['loginned'] = true;
            //$resp['user'] = DB::select('select do_user.*, max(do_levels.lvl) as lvl from do_user join do_levels WHERE do_user.id = ? AND do_user.exp >= do_levels.exp', [$userSession->id])[0];
            //$resp['user']->coins = DOApi::number_format_short($resp['user']->coins);
            //$resp['user']->exp = DOApi::number_format_short($resp['user']->exp);
        }

        return response()->json($resp);
    }



    public function result(Request $request)
    {
        //return $request->input('parts')['p'];
        $r = $request;
        if (!empty($request)) {
            $exp = 0;
            $coins = 0;
            $max_exp = 8888;
            if ($r['song_type'] != 1) {
                $exp = $request->input('baseinfo')['steps'] - $request->input('parts')['m'];
                $exp = $exp / $request->input('baseinfo')['steps'] * 100;
                $exp = floor($max_exp / 100 * $exp) + $this->userinfo['user']->exp_bonus;

                $coins = floor($exp / 888) + $this->userinfo['user']->dmn_bonus;
                if ($coins < 0) {
                    $coins = 0;
                }
            }
            $parts = $request->input('parts');
            DB::table('do_log')->insert(
                array('uid' => Session::get('user')->id,
                    'song_type' => $request->input('song_type'),
                    'song_id' => $request->input('song_id'),
                    'score' => $request->input('points'),
                    'exp' => $exp,
                    'perf' => $parts['p'],
                    'cool' => $parts['c'],
                    'good' => $parts['g'],
                    'bad' => $parts['b'],
                    'miss' => $parts['m'],
                    'coins' => $coins,
                )
            );
            //$insertLog = DB::insert("INSERT INTO do_log (uid, song_type, song_id, score, exp, perf, cool, good, bad, miss, coins)
            //VALUES ('$r[uid]', '$r[song_type]', '$r[song_id]', '$r[points]', '$exp', '$parts[p]', '$parts[c]', '$parts[g]', '$parts[b]', '$parts[m]', '$coins')");
            DB::table('do_user')->where('id', Session::get('user')->id)->update([
                'coins' => \DB::raw('coins + ' . $coins),
            ]);

            //DB::update("UPDATE do_user SET coins = coins + $coins, exp = exp + $exp WHERE id = $r[uid]");
            $songInfo = DB::table('do_music')->where('id', $request->input('song_id'))->first();//("SELECT * FROM do_music WHERE id = $r[song_id]")->fetch_assoc();
            //return response()->json($songInfo);
            //DOApi::activity(1, 'Вы станцевали ' . $songInfo->author . ' - ' . $songInfo->name . '. Кристаллы +' . $coins . ', опыт +' . DOApi::number_format_short($exp));
            $this->plusExp($exp);

            $alert = array('exp' => $exp, 'coins' => $coins);
            return response()->json($alert);

        }
    }

    public function songs()
    {
        $songs = DB::table('do_music')->orderby('bpm', 'desc')->get();
        return response()->json($songs);
    }

    public function getActivity()
    {
        $last5 = DB::select('SELECT dla.text as text, dlat.image as img
FROM do_log_activity dla
JOIN do_log_activity_types dlat ON dla.type = dlat.id
WHERE dla.uid = ' . Session::get('user')->id . '
AND dlat.visible =1
LIMIT 0 , 5');

        //        ORDER BY dla.id DESC
        return response()->json($last5);
    }

    public function checkAct()
    {
        DB::table('do_user')->where('id', $this->userinfo['user']->id)->update(['activity_update' => DB::raw('CURRENT_TIMESTAMP')]);
    }

    public function go($id = 0)
    {
        if ($id <= 0) {
            return redirect('/dance');
        }
        $user = Session::get('user');

        if (!Session::has('user')) {
            return redirect('/');
        }

        $songInfo = DB::table('do_music')->where('id', $id)->first();
        //var_dump($songInfo);
        return view('goDance', array('song' => $songInfo, 'u' => $this->userinfo['user']));

    }

    public function tutorialEnd()
    {
        $tutCheck = DB::table('do_user_tutorial')->where('uid', $this->userinfo['user']->id)->get();
        //$this->userinfo['user']->tut = false;
        //return response()->json($tutCheck);
        if (!count($tutCheck)) {
            DB::table('do_user_tutorial')->insert(
                ['uid' => $this->userinfo['user']->id]
            );
            DB::table('do_user')->where('id', $this->userinfo['user']->id)->update([
                'coins' => \DB::raw('coins + 10'),
            ]);
            $this->plusExp(1000);

        }
        return response()->json(true);
    }

}
