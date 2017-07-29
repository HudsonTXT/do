<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" lang="ru">
    <title>DanceOnline - личный кабинет</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="//vk.com/js/api/openapi.js?139"></script>
    <script src="{{asset('js/etc.js')}}"></script>
    <script src="{{asset('js/modules.js')}}"></script>
    <script>
        var vkId = {{$u->mid}};



    </script>
    @yield('scripts')
</head>

<body>
<menu>
    <div class="wrap">
        <li>
            <a href="http://fandance.ru"><img src="/img/logo.png" alt="" class="logo"></a>
        </li>
        @if($new)
            <li class="activity_menu animated wobble infinite">
            @else
            <li class="activity_menu">
            @endif
            <span class="icon"></span>
            @if($new)
                <div class="activity_new"></div>
            @endif
            <div class="activity_block">
                <div class="activity_head">Уведомления</div>
                <div class="block news">
                    <div class="block_content activity">
                        @if(count($a))
                        @foreach ($a as $act)
                        <div class="block_element">
                            <div class="news__icon block__separator">
                                <img src="/img/{{$act->img}}"></div>
                            <div class="news__text block__separator">{{$act->text}}</div>
                        </div>
                            @endforeach
                            @else
                            <div class="block-empty">Все последние новости можно узнать здесь</div>
                            @endif
                    </div>
                </div>
            </div>
        </li>
        <div class="links">
            <li><a href="/">Главная</a></li>
            <li><a href="http://fandance.ru">FanDance</a></li>
            <li><a href="/profile">Профиль</a></li>
            <li><a href="#" id="logout">Выход</a></li>
        </div>
    </div>

</menu>
<div class="body__bg">



    <div class="content wrap">
        <div class="sidebar">
            <div class="sidebar_userinfo">
                <img src="/img/av.png" alt="" class="sidebar_userinfo__avatar">

                <div class="sidebar_userinfo__about">
                    <div class="about__fio">{{$u->name}}</div>
                    <div class="about__money about__i" title="Кристаллы"><i></i><span>{{$u->coins}}</span></div>
                    <div class="about__exp about__i" title="Уровень (Опыт: {{$u->exp}})"><i></i><span>{{$u->lvl}} ур.</span></div>
                </div>
                <div class="clearfix"></div>

            </div>
            <div class="sidebar_menu">
                <div class="sidebar_menu__item"><a href="/dance"><img src="{{asset('img/disco.svg')}}" alt="">Танцпол</a></div>
                <div class="sidebar_menu__item"><a href="/profile"><img src="{{asset('img/profile.svg')}}" alt="">Профиль</a></div>
                <div class="sidebar_menu__item"><a href="/rating"><img src="{{asset('img/exp.svg')}}" alt="">Рейтинг</a></div>
                <div class="sidebar_menu__item"><a href="/shop"><img src="{{asset('img/store.svg')}}" alt="">Магазин</a></div>
                <div class="sidebar_menu__item"><a href="/rating"><img src="{{asset('img/exp.svg')}}" alt="">Задания</a></div>
            </div>

        </div>
        <div class="center">
            @yield('content')

        </div>
        <div class="clearfix"></div>
    </div>
</div>
</body>

</html>
