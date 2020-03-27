<div class="top-line">
    @if (Route::has('login'))
        <div class="top-left-links">
            <div class="home-page-link">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('img/abmeetings-logo.png') }}" alt="">
                </a>
            </div>
        </div>
        @if (request()->is('studios/*'))
        <div class="top-center-block">
            <div class="studio-title">
                {{ $studioName }}
            </div>
        </div>
        @endif
        <div class="top-right-links">
            @auth
                @if (request()->is('studios/*'))
                    <div class="pdf-link">
                        <form action="{{ route('output.pdf', ['studioID' => $studio_id]) }}" method="POST">
                            @csrf
                            <input id="activeDateStart" type="hidden" name="activeDateStart" value="">
                            <input id="activeDateEnd" type="hidden" name="activeDateEnd" value="">
                            <input id="calendarViewType" type="hidden" name="calendarViewType" value="">
                            <button class="get-pdf-button" id="pdfGenerator" type="submit"></button>
                        </form>
                    </div>
                @endif
                @can('isAdmin')
                    <a href="{{ url('/admin') }}">Админ панель</a>
                @endcan
                <a href="{{ url('/studios') }}">Комнаты</a>
                <a style="padding-right: 30px" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                    Выйти
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a style="padding-right: 30px" href="{{ route('login') }}">Войти</a>
            @endauth
        </div>
    @endif
</div>