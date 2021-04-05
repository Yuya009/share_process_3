<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<div id="app" class="container p-3">
    <h1 class="mb-4">{{ $post->title }}</h1>
    {!! $post->description !!}
</div>
</body>
</html>