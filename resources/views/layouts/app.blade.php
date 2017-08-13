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
        var chest = '{{$u->chest}}';
        var tournirs = '{{$u->end_day}}';


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
<div class="sunduk">
    @if($u->chest != 'ready')
<div class="sunduk_after" title="Сундук откроется через...">
    <span></span>
</div>
    @endif
</div>

<a href="/versus" id="versus"><div class="tourninrs" title="До конца турнира осталось..."><span></span></div></a>
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
                <div class="sidebar_menu__item"><a href="/profile"><img src="{{asset('img/profile.svg')}}" alt="">Профиль</a></div>
                <div class="sidebar_menu__item"><a href="/dance"><img src="{{asset('img/disco.svg')}}" alt="">Танцпол</a></div>
                <div class="sidebar_menu__item"><a href="/shop"><img src="{{asset('img/store.svg')}}" alt="">Магазин</a></div>
                <div class="sidebar_menu__item"><a href="/versus"><img src="{{asset('img/trophy.svg')}}" alt="">Турнир</a></div>
                <div class="sidebar_menu__item"><a href="/rating"><img src="{{asset('img/exp.svg')}}" alt="">Рейтинг</a></div>

            </div>

        </div>
        <div class="center">
            @yield('content')

        </div>
        <div class="clearfix"></div>
    </div>

</div>
<div class="footer">
    <div class="wrap">
        <div class="footer_c">
            <div class="c_name">DanceOnline!</div>
            <li><a href="/">Главная</a></li>
            <li><a href="/profile">Профиль</a></li>
            <li><a href="/dance">Танцпол</a></li>
            <li><a href="/shop">Магазин</a></li>
            <li><a href="/versus">Турнир</a></li>
            <li><a href="/rating">Рейтинг</a></li>
        </div>
        <div class="footer_c">
            <div class="c_name">Обратная связь</div>
            <li><a href="https://vk.com/gim55487263" target="_blank">Администрациия</a></li>
            <li><a href="https://vk.com/topic-55487263_36089582" target="_blank">Задать вопрос</a></li>
            <li><a href="https://vk.com/topic-55487263_36089582" target="_blank">Предложить трек</a></li>
            <li><a href="https://vk.com/topic-55487263_36089582" target="_blank">Отзыв</a></li>
            <li><a href="https://vk.com/topic-55487263_36089582" target="_blank">Пожелание</a></li>
            <li><a href="https://vk.com/topic-55487263_36089582" target="_blank">Предложение</a></li>
        </div>
        <div class="footer_c">
            <div class="c_name">Акция</div>
            Нравится приложение?<br>
            Напиши отзыв и получи подарок! <br>
            В отзыве ты можешь написать свои впечатления, предложения а также поделиться любимой музыкой. <br>

            <br>
            <a href="https://vk.com/topic-55487263_36089582" class="c_link" target="_blank">Оставить отзыв</a>
        </div>

        <div class="footer_c">

            <!-- VK Widget -->
            <div id="vk_groups"></div>
            <script type="text/javascript">
                VK.Widgets.Group("vk_groups", {mode: 3, width: "280", color1: '333', color2: 'FFF', color3: 'D0D0D0'}, 55487263);
            </script>
        </div>
    </div>
</div>
</body>

</html>
