@extends('admin.layouts.app')

@section('content')
    <div class="right-sidebar">
        <div class="page-title">Админ панель</div>
        <div class="card">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="inner-content">
                    <p>
                        Сервис для бронирования переговорных комнат.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
