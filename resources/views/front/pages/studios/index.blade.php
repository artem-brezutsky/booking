<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/front-styles.css') }}">
    <title>Выбор комнаты</title>
</head>
<body class="body-change-studio">
<header>
    @include('front.includes.header')
</header>
<section class="change-studio">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="full-row">
                    @foreach($studios as $studio)
                        @if($user->hasPermission('STUDIO_ID_' . $studio->id))
                            <a class="studio-card"
                               href="{{ url('studios/' . $studio->slug . '/events/') }}">{{ $studio->name }}</a>
                        @endif
{{--                        @can('hasPermission', 'STUDIO_ID_' . $studio->id)--}}
{{--                            <a class="studio-card"--}}
{{--                               href="{{ url('studios/' . $studio->slug . '/events/') }}">{{ $studio->name }}</a>--}}
{{--                        @endcan--}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>