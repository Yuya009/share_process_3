@extends('layouts.app')
@section('content')
    <div class="wrapper">
    <div class="header"><h1>投稿ページ</h1></div>
    <div class="content_wrapper">
    <div class="content2">

        <form action="/newpostsend" method="post">
            @csrf
            <p>タイトル</p>
            <input type="text" name="title" class="formtitle">         
            <p>&nbsp;</p>
            <p>本文</p>
            <!-- <textarea name="main" cols="40" rows="10"></textarea> -->
            <div id="editor" style="height: 200px;"></div>
            <p>&nbsp;</p>
            <input type="submit" class="submitbtn">
        </form>

    </div>
    </div>
    </div>

    <script>
        var quill = new Quill('#editor', {
          modules: {
            toolbar: [
              ['bold', 'italic', 'underline', 'strike'],
              [{'color': []}, {'background': []}],
              ['link', 'blockquote', 'image', 'video'],
              [{ list: 'ordered' }, { list: 'bullet' }]
            ]
          },
          placeholder: '',
          theme: 'snow'
        }); 
    </script>
@endsection