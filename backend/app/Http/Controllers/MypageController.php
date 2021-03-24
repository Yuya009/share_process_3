<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use Auth;
use Validator;

class MypageController extends Controller
{
    //マイページ
    public function index($user_id)
    {
      //$posts = Post::get();// 全ての投稿を取得
      $posts = User::find($user_id)->posts()->get();
      //$user = User::find( Auth::user()->id);//ログイン者のID取得
      $user = User::find($user_id);//ID取得からuser情報を取得
      
      if (Auth::check()) {
           $favo_posts = $user->favo_posts()->get();//ログインユーザーのお気に入りを取得
           $like_posts = $user->like_posts()->get();//ログインユーザーのいいねを取得
            return view('mypage',[
              'posts'=> $posts,
              'user' => $user,
              'favo_posts'=>$favo_posts,
              'like_posts'=>$like_posts
            ]);
      }else{
            return view('posts',[
              'posts'=> $posts
            ]);
      }
    }
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

    //プロフィール編集
    public function edit($user_id)
    {
      $user = User::find($user_id);
      return view('profile_edit',[
        'user' => $user //getで送られる？
      ]);
    }

    //プロフィール更新
    public function update(Request $request)
    {
      $user = User::find($request->id);
      $user->name = $request->name;
      $user->introduction = $request->introduction;
      $user->img_url = $request->img_url;
      $user->save();

      return redirect()->back();
    }

    //マイページ（いいね）
    public function like()
    {

    }
}
