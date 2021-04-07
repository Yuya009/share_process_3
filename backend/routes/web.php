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

Route::get('/', function () {
    return view('top');
});

Auth::routes();

Route::get('/home', 'PostsController@index_top');

//ゲストログイン
Route::get('guest_login', 'Auth\LoginController@guest_login')->name('login.guest');
//top画面表示
Route::get('top', 'PostsController@index_top');
//記事一覧
Route::get('/top/post', 'PostsController@top_post');

//マイページ
Route::prefix('mypage')->group(function(){
  //マイページ（投稿・Home）表示
  Route::get('/post/{user_id}', 'MypageController@index_post');
  //マイページ（お気に入り）表示
  Route::get('/favorite/{user_id}', 'MypageController@index_favorite');
  //マイページ（いいね）
  Route::get('/like/{user_id}', 'MypageController@index_like');
  //プロフィール編集
  Route::get('/edit/{user_id}', 'MypageController@edit');
  //プロフィールアップデート
  Route::post('/update/{user_id}', 'MypageController@update');
  //フォロー一覧
  Route::get('/followings/{user_id}', 'MypageController@followings');
  //フォロワー一覧
  Route::get('/followers/{user_id}', 'MypageController@followers');
});

//記事関連
Route::prefix('posts')->group(function(){
  //記事投稿
  Route::get('/write', 'PostsController@write');
  //記事投稿処理
  Route::post('/save', 'PostsController@store');
  //記事投稿編集ページ
  Route::get('/edit/{post}', 'PostsController@edit');
  //記事投稿編集アップデート
  Route::post('/update', 'PostsController@update');
  //記事詳細ページ
  Route::get('/content/{post}', 'PostsController@show');
  //記事投稿削除処理
  Route::delete('/delete/{post}', 'PostsController@delete');
  //エディタ内画像
  Route::post('/upload_image', 'PostsController@upload_image');
});

//記事お気に入り処理
Route::post('post/{post_id}', 'PostsController@favo');
//お気に入り削除
Route::post('favo_cancel/{post}','PostsController@favo_delete');
//いいね処理
Route::post('postlike/{post_id}','PostsController@like');
//いいね削除
Route::post('like_cancel/{post}','PostsController@like_delete');
//フォロー処理
Route::post('follow/{user_id}','FollowUserController@follow');
//フォロー削除
Route::post('follow_cancel/{user}','FollowUserController@follow_delete');


//画像アップロードテスト用
//Route::get('img', )
Route::get('img', 'ImagesController@index');
//画像アップロードフォーム
Route::get('/form', 'UploadImageController@show')->name("upload_form");
//画像アップロード処理ページ
//Route::post('/upload', 'UploadImageController@upload')->name("upload_image");
//画像表示処理
Route::get('/list', 'ImageListController@show')->name("imgae_list");