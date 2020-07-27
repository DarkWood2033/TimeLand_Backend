<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('site/css/app.css') }}">

    <title>Timer</title>
</head>
<body>

<div id="loading_app" style="height: 100vh;width: 100vw;">
    <img src="/site/img/loading.gif" alt="" style="position: absolute;left: 50%;top: 50%;transform: translate(-75px, -75px);width: 150px;">
</div>
<div id="app"></div>

<script>
    window.dd = (data) => console.log(data);
</script>
<script src="{{ route('localization.load') }}"></script>
<script src="{{ asset('site/js/app.js') }}"></script>

</body>
</html>
