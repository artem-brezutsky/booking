<div class="left-sidebar">
    <ul>
        <li><a class="nav-link {{ Request::is('admin' ) ? 'active' : null }}" href="{{ url('/admin') }}">Главная</a></li>
        <li><a class="nav-link {{ Request::is('admin/studios' ) || Request::is('admin/studios/*') ? 'active' : null }}" href="{{ url('/admin/studios') }}">Комнаты</a></li>
        <li><a class="nav-link {{ Request::is('admin/events') || Request::is('admin/events/*') ? 'active' : null }}" href="{{ url('/admin/events') }}">События</a></li>
        <li><a class="nav-link {{ Request::is('admin/users') || Request::is('admin/users/*')  ? 'active' : null }}" href="{{ url('/admin/users') }}">Пользователи</a></li>
    </ul>
</div>