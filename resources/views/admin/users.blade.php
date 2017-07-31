@extends('admin/admin')
@section('scripts')
    <link rel="stylesheet" href="{{asset('/css/admin.css')}}">
@endsection
@section('adminContent')
<div class="block">
    <div class="block_header">Пользователи</div>
    <div class="block_content">
        <div class="user">
            <div class="block_element">
                <div class="block__separator user_name">Фамилия Имя</div>
                <div class="block__separator user_exp">Опыт</div>
                <div class="block__separator user_coins">Монеты</div>
            </div>
        </div>
        @foreach($list as $user)
            <div class="user">
                <a href="/admin/users/edit/{{$user->id}}">
                <div class="block_element">
                    <div class="block__separator user_name">{{$user->name}} {{$user->last}}</div>
                    <div class="block__separator user_exp">{{$user->exp}}</div>
                    <div class="block__separator user_coins">{{$user->coins}}</div>
                </div>
                </a>
            </div>
            @endforeach

        {{$list->links()}}
    </div>
</div>
@endsection