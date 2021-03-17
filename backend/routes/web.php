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

Route::get('/home', 'HomeController@index')->name('home');

//top画面表示
Route::get('top', 'PostsController@index_top');

//マイページ表示
Route::get('/', 'PostsController@index');

//記事投稿処理
Route::post('posts', 'PostsController@store');
//記事投稿編集ページ
Route::get('postedit/{post}', 'PostsController@edit');
//記事投稿編集アップデート
Route::post('posts/update', 'PostsController@update');
//記事投稿詳細ページ
Route::get('post/{post}', 'PostsController@show');
//記事投稿削除処理
Route::delete('post/{post}', 'PostsController@delete');

//記事お気に入り処理
Route::post('post/{post_id}', 'PostsController@favo');
//お気に入り削除
Route::post('favo_cancel/{post}','PostsController@favo_delete');
//いいね処理
Route::post('postlike/{post_id}','PostsController@like');
//いいね削除
Route::post('like_cancel/{post}','PostsController@like_delete');

//画像アップロードテスト用
//Route::get('img', )
Route::get('img', 'ImagesController@index');
//画像アップロードフォーム
Route::get('/form', 'UploadImageController@show')->name("upload_form");
//画像アップロード処理ページ
Route::post('/upload', 'UploadImageController@upload')->name("upload_image");
//画像表示処理
Route::get('/list', 'ImageListController@show')->name("imgae_list");