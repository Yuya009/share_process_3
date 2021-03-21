<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use Auth;
use Validator;

class MypageController extends Controller
{
    public function followings($user_id)//ユーザがフォローしている人
    {
      $user = User::find($user_id);//対象のユーザのデータ取得
      $login_user = User::find( Auth::user()->id);//ログイン者のID取得
      $followed_user = $user->follows()->get();//投稿者のフォロー取得

      return view('followings',[
        'user' => $user,
        'followings' => $followed_user,
        'login_user' => $login_user
      ]);
    }

    //ユーザーをフォローしている人
    public function followers($user_id)
    {
      $user = User::find($user_id);//対象のユーザのデータ取得
      $following_user = $user->followUsers()->get();//投稿者のフォロワー取得
      $login_user = User::find( Auth::user()->id);//ログイン者のID取得

      return view('followers',[
        'user' => $user,
        'followers' => $following_user,
        'login_user' => $login_user
      ]);
    }
}
