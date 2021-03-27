<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
    //マイページ投稿
    public function index_post($user_id)
    {
      $posts = User::find($user_id)->posts()->get();
      $user = User::find($user_id);//ID取得からuser情報を取得

      $favo_posts = $user->favo_posts()->get();//ユーザーのお気に入りを取得
      $like_posts = $user->like_posts()->get();//ユーザーのいいねを取得

        return view('mypage_post',[
          'posts'=> $posts,
          'user' => $user,
          'favo_posts'=>$favo_posts,
          'like_posts'=>$like_posts
        ]);
    }
    //マイページお気に入り
    public function index_favorite($user_id)
    {
      $posts = User::find($user_id)->posts()->get();
      $user = User::find($user_id);//ID取得からuser情報を取得

      $favo_posts = $user->favo_posts()->get();//ユーザーのお気に入りを取得
      $like_posts = $user->like_posts()->get();//ユーザーのいいねを取得

        return view('mypage_favorite',[
          'posts'=> $posts,
          'user' => $user,
          'favo_posts'=>$favo_posts,
          'like_posts'=>$like_posts
        ]);
    }
    //マイページいいね
    public function index_like($user_id)
    {
      $posts = User::find($user_id)->posts()->get();
      $user = User::find($user_id);//ID取得からuser情報を取得

      $favo_posts = $user->favo_posts()->get();//ユーザーのお気に入りを取得
      $like_posts = $user->like_posts()->get();//ユーザーのいいねを取得

        return view('mypage_like',[
          'posts'=> $posts,
          'user' => $user,
          'favo_posts'=>$favo_posts,
          'like_posts'=>$like_posts
        ]);
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
      if(Auth::id() == $user_id) {
        $user = User::find($user_id);
        return view('profile_edit',[
          'user' => $user
        ]);
      }else{
        return redirect($user_id.'/post');
      }
    }

    //プロフィール更新
    public function update(Request $request)
    {
      //バリデーション
      $validator = $request->validate([
        'img' => 'nullable|file|image|max:2048',
      ]);
      //画像ファイル取得
      $file = $request->img;
      //ユーザー取得
      $user = User::find($request->id);

      if(!empty($file)) {
        //ファイルの拡張子取得
        $ext = $file->guessExtension();

        //ファイル名を生成
        $file_name = Str::random(32).'.'.$ext;

        //画像のファイル名を任意のDBに保存
        $user->img_url = $file_name;
        $user->name = $request->name;
        $user->introduction = $request->introduction;
        $user->save();

        //public/profileフォルダを生成
        $target_path = public_path('/profile/');

        //ファイルをフォルダに移動
        $file->move($target_path, $file_name);
      }else{
        $user->name = $request->name;
        $user->introduction = $request->introduction;
        //$user->img_url = $file;
        $user->save();
      }
      $user_id = $request->id;

      return redirect($user_id.'/post');
    }

    //マイページ（いいね）
    public function like()
    {

    }
}
