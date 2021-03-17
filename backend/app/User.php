<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Postsテーブルとのリレーション（主テーブル側）
    public function posts() {
      return $this->hasMany('App\Post');
    }

    //imagesテーブルとの1対多nリレーション(主テーブル)
    public function images() {
      return $this->hasMany('App\Image');
    }

    //Postsテーブルとの多対多リレーション（favo・お気に入り）
    public function favo_posts() {
      return $this->belongsToMany('App\Post');
    }

    //Postsテーブルとの多対多リレーション（like・いいね）
    public function like_posts() {
      return $this->belongsToMany('App\Post','postlike_user');
    }

    //フォローワーリレーション
    public function followUsers(){
      return $this->belongsToMany('App\User', 'follow_user', 'followed_user_id', 'fowllowing_user_id');
    }
    //フォローのリレーション
    public function follows() {
      return $this->belongsToMany('App\User', 'follow_user', 'following_user_id','followed_user_id');
    }
}
