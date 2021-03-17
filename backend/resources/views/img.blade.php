@extends('layouts.app')
@section('content')
    <form route="/users/{$user->id}/edit" method="post" enctype='multipart/form-data'>
        {{ csrf_field() }}

        @isset ($filename)
            <div>
                <img src="{{ asset('storage/avatar/' . $user->image_path) }}">
            </div>
        @endisset

        <div>
            <input type="hidden" name="id">
        </div>
        <div>
            画像の名前：<input type="text" name="file_name">
        </div>
        <div>
            <input type="file" name="image">
        </div>
        <input type="submit" value="更新する">
    </form>
@endsection