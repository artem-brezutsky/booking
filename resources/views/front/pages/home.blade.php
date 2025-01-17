<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Бронирование переговорных комнат</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/front-styles.css') }}">

</head>
<body class="home-page">
<header>
    @include('front.includes.header')
</header>
<section class="home-screen">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
