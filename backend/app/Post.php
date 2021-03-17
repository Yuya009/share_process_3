<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $tabel = "posts";
    protected $fillable =["file_name", "file_path"];

    //Userテーブルとのリレーション（従テーブル側）
    public function user() {
      return $this->belongsTo('App\User');
    }

    //Userテーブルとの多対多リレーション（favo・お気に入り）
    public function favo_user() {
      return $this->belongsToMany('App\User','post_user','post_id','user_id');
    }

    //Userテーブルとの多対多のリレーション（like・いいね）
    public function like_user() {
      return $this->belongsTomany('App\User','postlike_user','post_id','user_id');
    }
  }
