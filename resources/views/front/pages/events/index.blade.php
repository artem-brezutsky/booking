<!doctype html>
<html lang="ru-RU">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {{-- jQuery UI Styles --}}
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    {{-- Bootstrap Styles --}}
    {{--        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">--}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    {{-- FullCalendar Main Style --}}
    <link rel="stylesheet" href="{{ asset('js/calendar/fullcalendar/core/main.min.css') }}">
    {{-- FullCalendar Daygrid Style --}}
    <link rel="stylesheet" href="{{ asset('js/calendar/fullcalendar/daygrid/main.css') }}">
    {{-- FullCalendar TimeGrid Style--}}
    <link rel="stylesheet" href="{{ asset('js/calendar/fullcalendar/timegrid/main.css') }}">
    {{-- FullCalendar Bootstrap Style--}}
    <link rel="stylesheet" href="{{ asset('js/calendar/fullcalendar/bootstrap/main.css') }}">

    <link rel="stylesheet" href="{{ asset('css/front-styles.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/toastr/css/toastr.min.css') }}">

    {{-- @TODO Поменять дейтпикер --}}
    {{--  Test datepicker  --}}
    {{--  <link href="{{ asset('libs/air-datepicker/css/datepicker.css') }}" rel="stylesheet" type="text/css">  --}}

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $studioName }}</title>

    <script>let studio_id = {{ $studio_id }};</script>
</head>
<body>
<header>
    @include('front.includes.header')
</header>
@include('front.includes.add-event-front-modal')
@include('front.includes.event-info-form')
<div class="main main-calendar">
    <div class="bgc"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="card card-primary">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <script>
        let currentUser = {!! json_encode(Auth::user()->name) !!};
        let currentUserID = {!! json_encode(Auth::user()->id) !!};
        let accessDelete = false;
        @if(Auth::user()->can('isAdmin', Auth::user()))
            accessDelete = true;
        @endif
    </script>
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    {{-- jQuery UI --}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    {{-- Main JS --}}
    <script src="{{ asset('js/calendar/main.js') }}"></script>
    {{-- Toastr JS --}}
    <script src="{{ asset('assets/toastr/js/toastr.min.js') }}"></script>
    {{-- FullCalendar Core JS--}}
    <script src="{{ asset('js/calendar/fullcalendar/core/main.js') }}"></script>
    {{-- FullCalendar DayGrid JS--}}
    <script src="{{ asset('js/calendar/fullcalendar/daygrid/main.js') }}"></script>
    {{-- FullCalendar TimeGrid JS--}}
    <script src="{{ asset('js/calendar/fullcalendar/timegrid/main.js') }}"></script>
    {{-- FullCalendar Bootstrap JS--}}
    <script src="{{ asset('js/calendar/fullcalendar/bootstrap/main.js') }}"></script>
    {{-- FullCalendar Interaction JS--}}
    <script src="{{ asset('js/calendar/fullcalendar/interaction/main.js') }}"></script>

    {{--  <script src="{{ asset('libs/air-datepicker/js/datepicker.min.js') }}"></script>  --}}

</footer>

</body>
</html>