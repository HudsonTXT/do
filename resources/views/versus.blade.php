@extends('layouts.app')
@section('scripts')
    <link rel="stylesheet" href="{{asset('/css/versus.css')}}">
    <script src="{{asset('/js/versus.js')}}"></script>
    @if(count($l))
    <script>
        $(function () {
            VK.Api.call('users.get', {
                user_ids: {{$l[0]->mid}},
                fields: 'photo_200'
            }, function (r) {
                $('.versus_leader img').attr('src', r.response[0].photo_200);

            });
        });

    </script>
    @endif
@endsection

@section('content')
    <div class="block versus">
        <div class="block_header">Ежедневный турнир</div>
        <div class="block_description">Каждый день проходит турнир. Для участия, необходимо станцевать под трек,
            указанный ниже. Результаты подводятся в 24 часа. Победителем считается тот, кто набрал большую сумму очков.
        </div>
        <div class="block_content">
            <div class="versus_timer">
                <span id="timer_head">До конца турнира:</span>
                <span id="timer_time">24:00:00</span>
            </div>
        </div>
        <div class="block_content goto">
        <span id="goto_desc">
        Для участия в турнире станцуй под песню:
        </span>
            <div id="goto_song">{{$v->song_name}}</div>
            <a href="/dance/go/{{$v->song_id}}">
                <div class="button">Участвовать</div>
            </a>
            @if(count($l))
            Твои очки: {{$v->user_score}}
                @endif
        </div>
        @if(count($l))
        <div class="block_content leaderboard">
            <div class="versus_leader">
                <span id="leader">Лидер:</span>
                <br>
                <a href="/profile/{{$l[0]->id}}">
                <img src="{{asset('/img/av.png')}}" alt="" width="150">
                <br>
                <span id="leader_name">{{$l[0]->name}}<br>{{$l[0]->last}}</span>
                </a>
            </div>
        </div>
        <div class="block_content leadertable">
            <div class="versus_table">
                <span>Топ-5:</span>
                <div class="block_element leadertable_info">
                    <div class="block__separator leadertable_num">#</div>
                    <div class="block__separator leadertable_fio">Имя Фамилия</div>
                    <div class="block__separator leadertable_score">Очки</div>
                </div>

                @foreach($l as $k=>$log)
                    <a href="/profile/{{$log->id}}">
                <div class="block_element">
                    <div class="block__separator leadertable_num">{{++$k}}.</div>
                    <div class="block__separator leadertable_fio">{{$log->name}} {{$log->last}}</div>
                    <div class="block__separator leadertable_score">{{$log->score}}</div>
                </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif
        <div class="block_description">Призы зависят от количества человек, принявших участие в турнире.</div>
        <div class="block_content prizes">

            Призы:
            <br>
            <br>
            <div class="block_element">
                <div class="block__separator prizes_num">1.</div>
                <div class="block__separator prizes_items">
                    {{$l->prizes*10}}x<img
                            src="{{asset('/img/m.svg')}}" alt=""> {{$l->prizes*1000}}x<img
                            src="{{asset('/img/exp_bonus.svg')}}" alt=""></div>
            </div>
            <div class="block_element">
                <div class="block__separator prizes_num">2.</div>
                <div class="block__separator prizes_items">
                    {{$l->prizes*7}}x<img
                            src="{{asset('/img/m.svg')}}" alt=""> {{$l->prizes*700}}x<img
                            src="{{asset('/img/exp_bonus.svg')}}" alt=""></div>
            </div>
            <div class="block_element">
                <div class="block__separator prizes_num">3.</div>
                <div class="block__separator prizes_items">
                    {{$l->prizes*5}}x<img
                            src="{{asset('/img/m.svg')}}" alt=""> {{$l->prizes*500}}x<img
                            src="{{asset('/img/exp_bonus.svg')}}" alt=""></div>
            </div>
            <div class="block_element">
                <div class="block__separator prizes_num">4.</div>
                <div class="block__separator prizes_items">
                    {{$l->prizes*3}}x<img
                            src="{{asset('/img/m.svg')}}" alt=""> {{$l->prizes*300}}x<img
                            src="{{asset('/img/exp_bonus.svg')}}" alt=""></div>
            </div>
            <div class="block_element">
                <div class="block__separator prizes_num">5.</div>
                <div class="block__separator prizes_items">
                    {{$l->prizes*2}}x<img
                            src="{{asset('/img/m.svg')}}" alt=""> {{$l->prizes*200}}x<img
                            src="{{asset('/img/exp_bonus.svg')}}" alt=""></div>
            </div>
        </div>

        <div class="block_content history">
            Результаты прошлого турнира:
            <br>
            {{$v->tomorrow_song_name}}
            <br>

            <div class="block_element history_info">
                <div class="block__separator history_num">#</div>
                <div class="block__separator history_fio">Имя Фамилия</div>
                <div class="block__separator history_score">Очки</div>
            </div>
            @if(count($t))
            @foreach($t as $k=>$l)
            <div class="block_element">
                <div class="block__separator history_num">{{++$k}}</div>
                <div class="block__separator history_fio">{{$l->name}} {{$l->last}}</div>
                <div class="block__separator history_score">{{$l->score}}</div>
            </div>
            @endforeach
            @endif

        </div>


    </div>
@endsection