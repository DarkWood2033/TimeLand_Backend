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

<div id="app"></div>

<script>
    window.dd = (data) => console.log(data);
</script>
<script src="{{ route('localization.load') }}"></script>
<script src="{{ asset('site/js/app.js') }}"></script>

</body>
</html>
