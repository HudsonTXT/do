<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers;

use App\Http\Controllers\VKUsers;

/*
 * DEFAULT CONSTRUST FOR GET USER INFO
 *  public $userinfo;
    function __construct()
    {
        new VKUsers();
        $this->userinfo = VKUsers::$a;
    }
 *
 *
 *
 * DEFAULT VIEW FUNCTION
 *     public function all(){
        $userinfo = $this->userinfo['user'];
        $this->userinfo['user']->coins = DOApi::number_format_short($this->userinfo['user']->coins);
        $this->userinfo['user']->exp = DOApi::number_format_short($this->userinfo['user']->exp);
        return view('profile', array( 'u' => $this->userinfo['user'], 'a' => $this->userinfo['act'], 'new' => $this->userinfo['new']));
    }
 *
 * */
Route::get('/', function (\Illuminate\Http\Request $request) {
    $result = $request->session()->all();
    $token = $result['_token'];

    return view('login', ['token' => $token]);
});
Route::get('/dance', 'DOApi@lk');
Route::post('api/login', 'DOApi@insert');
Route::get('api/check', 'DOApi@check');
Route::get('api/logout', function (){
        //Api logout. Выход из аккаунта.
        // \Cookie::forget('vk_app_4004433');

        Session::flush();
        \Cookie::forget('vk_app_4004433');
    return redirect('/');

});
Route::post('api/result', 'DOApi@result');
Route::get('api/songs', 'DOApi@songs');
Route::get('api/tutorialEnd', 'DOApi@tutorialEnd');
Route::get('api/activity', 'DOApi@getActivity');
Route::get('/dance/go/{id?}', 'DOApi@go');
Route::get('/dance/versus', 'DOApi@versus');
Route::get('/dance/dance.js', 'DOApi@danceJs');

//Route::get('/profile/', 'SocialApi@mainProfile');
Route::get('/profile/edit', 'SocialApi@editProfile');
Route::get('/profile/{id?}', 'SocialApi@anotherProfile');

Route::get('/exp/{exp?}', 'DOApi@getExp'); //DELETE THIS
Route::get('api/checkAct', 'DOApi@checkAct');

/*Route::get('check/{id}', function($id){
    return response()->json(DB::table('do_log')->join('do_user', 'do_user.id', '=', 'do_log.uid')->select(DB::raw('max(do_log.score) as score'), 'do_user.name', 'do_user.last')->where('do_log.song_id', $id)->groupby('do_log.uid')->orderby('score', 'desc')->limit(5)->get());
});
Route::get('check/{uid}/{exp}/{money}', function ($uid, $exp, $money){
    Controllers\Versus::getExpAndMoney($uid, $exp, $money);
});

Route::get('/check2', 'SocialApi@check');
*/
Route::get('rating', 'DORating@all');

Route::get('/shop', 'Shop@show');
Route::get('/shop/buy/{id}', 'Shop@buy');

Route::get('chest/dialy', 'Chest@dialy');
Route::get('versus/', 'Versus@index');
Route::get('versus/lovefandanceru/update', 'Versus@cron');





Route::get('/admin', 'Admin@index');
Route::get('/admin/users', 'Admin@usersIndex');
Route::get('/admin/users/edit/{id}', 'Admin@userEdit');