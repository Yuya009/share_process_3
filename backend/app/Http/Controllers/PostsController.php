<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use Auth;
use Validator;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($post_id)
    {
        $posts = Post::get();// 全ての投稿を取得
        //$user = User::find( Auth::user()->id);//ログイン者のID取得
        $user = User::find($post_id);//ログイン者のID取得
        
        if (Auth::check()) {
             $favo_posts = Auth::user()->favo_posts()->get();//ログインユーザーのお気に入りを取得
             $like_posts = Auth::user()->like_posts()->get();//ログインユーザーのいいねを取得
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

    public function index_top()
    {
        // 全ての投稿を取得
        $posts = Post::orderBy('created_at', 'desc')->paginate(9);
        $favo_posts = array();

        if (Auth::check()) {
             //ログインユーザーのお気に入りを取得
             $favo_posts = Auth::user()->favo_posts()->get();
             
              return view('top',[
                'posts'=> $posts,
                'favo_posts'=>$favo_posts
              ]);
         }else{
               return view('top',[
                 'posts'=> $posts
               ]);
        }
    }
    public function top_post()
    {
      // 全ての投稿を取得
      $posts = Post::orderBy('created_at', 'desc')->paginate(9);
      $favo_posts = array();

      if (Auth::check()) {
           //ログインユーザーのお気に入りを取得
           $favo_posts = Auth::user()->favo_posts()->get();
           
            return view('top_post',[
              'posts'=> $posts,
              'favo_posts'=>$favo_posts
            ]);
       }else{
             return view('top_post',[
               'posts'=> $posts
             ]);
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //バリデーション 
        $validator = Validator::make($request->all(), [
          'post_title' => 'required|max:255',
          'post_desc' => 'required|max:10000',
        ]);

        //画像取得
        $upload_image = $request->file('file_image');
        //画像をフォルダに保存
        if(isset($upload_image)) {
          //アップロードされた画像を保存
          $path = $upload_image->store('uploads', "public");
          $image_name = $request->file('file_image')->getClientOriginalName();//画像名前
        } else {
          //なければデフォルト画像使用する
          $path = 'uploads/book_note_empty.png';//保存場所
          $image_name = 'book_note_empty.png';//画像名
        }
      
        //バリデーション:エラー
        if ($validator->fails()) {
          return redirect('/write')
              ->withInput()
              ->withErrors($validator);
        }
      
        //以下に登録処理を記述（Eloquentモデル）
        $posts = new Post; //新しいデータをPostモデルを通して、postsテーブルに登録する
        $posts->post_title = $request->post_title; //投稿のタイトル
        $posts->post_desc = $request->post_desc; //投稿の本文
        $posts->file_name = $image_name;//画像の名前
        $posts->file_path = $path;//ファイルの保存パス
        $posts->user_id = Auth::id();//ここでログインしているユーザidを登録しています
        $posts->save(); //DBに登録
        
        return redirect('/mypage/post/'.$posts->user_id);
     
    }

    public function write()
    {
      return view('posts');
    }
    public function upload_image(Request $request) {

      //バリデーションは省略しています。
      $file = $request->file('image');
      $extension = $file->extension();
      $path = 'public/cms_images';
      $name = date('Ymd-His') .'_'. Str::random(5) .'.'. $extension;
      $request->file('image')->storeAs($path, $name);
  
      return [
          'result' => true,
          'image_url' => url('/storage/cms_images/'. $name)
      ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $user = User::find( $post->user_id);//投稿者id
        $following_user = $user->followUsers()->get();//投稿者のフォロワー取得
        $followed_user = $user->follows()->get();//投稿者のフォロー取得
        //$followed_user = Auth::user()->follows()->get();//ログイン者のフォロー取得
        return view('content',[
          'post' => $post,
          'user' => $user,
          'folloUsers' => $following_user,
          'follows' => $followed_user
          ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // 記事編集
    public function edit(Post $post)
    {
      if(Auth::id() == $post->user_id) {
        return view('postsedit', ['post' => $post]);
      }else{
        return redirect('/top');
      }
    }

    public function update(Request $request) {
      //バリデーション
      $post = Post::find($request->id);
      $post->post_title = $request->post_title;
      $post->post_desc = $request->post_desc;
      $post->save();

      return redirect('/top');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //お気に入り処理
    public function favo($post_id)
    {
      $user = Auth::user();//ログイン中のユーザを取得
      $post = Post::find($post_id);//お気に入りする記事
      $post->favo_user()->attach($user);//リレーションの登録
      return redirect()->back();
    }
    //お気に入り削除
    public function favo_delete(Post $post)
    {
      $post->favo_user()->detach(Auth::id());
      return redirect()->back();
    }

    //いいね処理
    public function like($post_id)
    {
      $user = Auth::user();//ログイン中のユーザを取得
      $post = Post::find($post_id);//いいねする記事
      $post->like_user()->attach($user);//リレーションの登録
      return redirect()->back();
    }
    //いいね削除
    public function like_delete(Post $post)
    {
      $post->like_user()->detach(Auth::id());
      return redirect()->back();
    }

    //削除処理
    public function delete(Post $post) {
      $post->delete();
      return redirect('/');
    }

}
