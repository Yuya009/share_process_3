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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'PostsController@index_top');

//ゲストログイン
Route::get('guest_login', 'Auth\LoginController@guest_login')->name('login.guest');

//top画面表示
Route::get('top', 'PostsController@index_top');
//記事一覧
Route::get('/top/post', 'PostsController@top_post');

//マイページ表示
Route::get('/', 'PostsController@index_top');
//マイページ表示(user_id)
//Route::get('/{user_id}', 'MypageController@index');
//マイページ（投稿・Home）表示
Route::get('/{user_id}/post', 'MypageController@index_post');
//マイページ（お気に入り）表示
Route::get('/{user_id}/favorite', 'MypageController@index_favorite');
//マイページ（いいね）
Route::get('/{user_id}/like', 'MypageController@index_like');
//プロフィール編集
Route::get('/{user_id}/profile_edit', 'MypageController@edit');
//プロフィールアップデート
Route::post('/{user_id}/update', 'MypageController@update');
//フォロー一覧
Route::get('/{user_id}/followings', 'MypageController@followings');
//フォロワー一覧
Route::get('/{user_id}/followers', 'MypageController@followers');

//記事投稿処理
Route::post('posts', 'PostsController@store');
//記事投稿編集ページ
Route::get('postedit/{post}', 'PostsController@edit');
//記事投稿編集アップデート
Route::post('posts/p_update', 'PostsController@update')->name('post.update');
//記事投稿詳細ページ
Route::get('post/{post}', 'PostsController@show');
//記事投稿削除処理
Route::delete('post/{post}', 'PostsController@delete');
//記事投稿
Route::get('/write', 'PostsController@write');
//エディタ内画像
Route::post('/upload_image', 'PostsController@upload_image');


//記事投稿（リッチテキストv2）
Route::get('/create', 'PostsController@edita_create');
//画像保存
Route::post('/temp', 'PostsController@edita_image');


//記事投稿（リッチテキストエディタ）
Route::prefix('editor_post')->group(function(){
  Route::get('/editor_index', 'PostsController@editor_index');
  Route::get('/list', 'PostsController@editor_list');
  Route::get('/{post}', 'PostsController@editor_show');
  Route::post('/', 'PostsController@editor_store');
  Route::post('/upload_image', 'PostsController@editor_upload_image');
  Route::put('/{post}', 'PostsController@editor_update');
  Route::delete('/{post}', 'PostsController@editor_destroy');
});

//テスト記事投稿
Route::get('/edit_write', 'PostsController@edit_test');

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