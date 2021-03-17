<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;//モデル
use App\User;
use Auth;
use Validator;

class FollowUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

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
    //フォロー処理
    public function follow($user)
    {
      $login_user = Auth::user();//ログイン中のユーザを取得
      $follow_user = User::find($user);//フォローするユーザ
      $follow_user->followUsers()->attach($user);//リレーションの登録
      return redirect()->back();
    }
    //フォロー解除
    public function like_delete(User $user)
    {
      $post->like_user()->detach(Auth::id());
      return redirect()->back();
    }
}
