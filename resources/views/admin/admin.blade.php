@extends('layouts.app')
@section('scripts')

@endsection
@if($u->usergroup == 2)
@section('content')
    <div class="block admin">
        <div class="block_header">Управление</div>
        <div class="block_description">Выберите необходимый пункт меню</div>
        <div class="block_content">
            <a href="/admin/users">Пользователи</a>
            <a href="/admin/items">Предметы</a>
            <a href="/admin/shop">Магазин</a>
            <a href="/admin/status">Статусы</a>
            <a href="/admin/songs">Песни</a>
        </div>
        @yield('adminContent')
    </div>
@endsection
@endif