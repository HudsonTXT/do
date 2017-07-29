<?php
namespace App\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class Login extends Controller
{
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


}
