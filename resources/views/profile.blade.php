@extends('layouts.app')

    @section('scripts')
        <script src="{{asset('js/circle.js')}}"></script>
        <script>
            var profileMid = {{$p->mid}}

        </script>
        <script src="{{asset('js/profile.js')}}"></script>
        <link rel="stylesheet" href="{{asset('css/profile.css')}}">
    @endsection
    @section('content')
        <div class="block profile">
            <div class="block_header">Профиль @if($u->id == 1/*$p->id*/)<span><a href="/profile/edit">Редактировать</a></span>@endif</div>
            <div class="block_content">
                <div class="profile_image animated zoomIn">
                    <img src="{{asset('img/av.png')}}" alt="" width="200">
                </div>
                <div class="profile_info">
                    <div class="info_name__status animated slideInRight" style="color: {{$p->status_color}};">{{$p->status_name}}</div>
                    <div class="info_name animated slideInLeft"><span>{{$p->name}} {{$p->last}}</span>
                        <div class="info_lastin"></div>

                    </div>

                    <div class="info_lvl circle" data-value="{{$lvlPerc['percent']}}" title="Уровень ({{$lvlPerc['now']}}/{{$lvlPerc['next']}})">
                        <div id="lvl_num">{{$p->lvl}} <span>уровень</span></div>
                    </div>
                    <div class="info_money circle" data-value="1" title="Всего: {{$p->oldMoney}}">
                        <div id="lvl_num">{{$p->coins}} <span>кристаллы</span></div>
                    </div>
                    <div class="info_dance circle" data-value="{{$danceProc}}" title="Точность высчитывается средним процентом за все танцы">
                        <div id="lvl_num">{{round($danceProc*100)}}% <span>точность</span></div>
                    </div>

                </div>
            </div>

            <div class="block profile_bonuses">
                <div class="block_header">Бонусы</div>
                <div class="block_description">После завершения танца, к награде будут добавлены бонусы. Их можно заработать в специальных событиях. Действие бонусов ограничено!</div>
                <div class="block_content">
                    <div class="bonuses_exp bonus" title="К каждому танцу будет добавляться {{$p->exp_bonus}} очков опыта">
                        <img src="{{asset('/img/exp_bonus.svg')}}" alt="">
                        Опыт <span>+{{$p->exp_bonus}}</span>
                    </div>
                    <div class="bonuses_dmn bonus" title="К каждому танцу будет добавляться {{$p->dmn_bonus}} кристаллов">
                        <img src="{{asset('/img/m.svg')}}" alt="">
                        Кристаллы <span>+{{$p->dmn_bonus}}</span>
                    </div>

                </div>
            </div>


            <div class="block profile_medals">
                <div class="block_header">Медали</div>
                <div class="block_description">Медали можно преобрести в магазине или получить за участие в акциях.</div>
                <div class="block_content">


                        @if(!count($medals))
                            <div class="no-medals">
                                <img src="{{asset('/img/medals/no.svg')}}" width="100" alt=""><br>
                                Медали отсутствуют
                            </div>
                            @else
                        <div class="medals_carousel">
                            @foreach($medals as $m)

                                <div class="medal" title="{{$m->description}}">
                                    <img src="{{asset($m->image)}}" alt="">
                                    {{$m->name}}
                                </div>
                            @endforeach
                        </div>
                            <div class="carousel_right"></div>
                            <div class="carousel_left"></div>
                            @endif



                </div>
            </div>
        </div>
    @endsection