@extends('layouts.app')
@section('scripts')
    <link rel="stylesheet" href="{{asset('css/rating.css')}}">
    <script>
        var tops = [{{$rich[0]->mid}}, {{$exp[0]->mid}}];
        var tops_10 = {!! $r50 !!};
    </script>

    <script src="{{asset('/js/rating.js')}}"></script>
@endsection
@section('content')
    <div class="block rating">
        <div class="block_header">Рейтинг</div>
        <div class="block_content">
            <div class="rating__rich rich">
                <a href="/profile/{{$rich[0]->id}}">
                    <div class="rich_first">
                        <div class="first_bg"></div>
                        <div class="first_img"><img src="{{asset('img/av.png')}}" alt=""></div>
                        <div class="first_name">{{$rich[0]->name}}<br>{{$rich[0]->last}}</div>
                    </div>
                </a>
                <div class="rich_table">
                    <div class="block_content">
                        <div class="rating_users">
                            @foreach($rich as $r)

                                <div class="block_element ">
                                    <a href="/profile/{{$r->id}}">
                                    <div class="block__separator rating_pos">{{$r->pos}}.</div>
                                    <div class="block__separator rating_name"><img src="{{asset('img/av.png')}}" width="30" alt="">{{$r->name}} {{$r->last}}</div>
                                    <div class="block__separator rating_val">{{$r->coins}} <img src="{{asset('img/m.svg')}}" alt="" width="20"></div>
                                    </a>
                                </div>

                            @endforeach

                        </div>

                    </div>
                </div>
            </div>
            <div class="rating__rich rating__act">
                <a href="/profile/{{$exp[0]->id}}">
                <div class="rich_first">
                    <div class="first_bg"></div>
                    <div class="first_img"><img src="{{asset('img/av.png')}}" alt=""></div>
                    <div class="first_name">{{$exp[0]->name}}<br>{{$exp[0]->last}}</div>
                </div>
                </a>
                <div class="rich_table">
                    <div class="block_content">
                        <div class="rating_users">
                            @foreach($exp as $r)

                                <div class="block_element ">
                                    <a href="/profile/{{$r->id}}">
                                        <div class="block__separator rating_pos">{{$r->pos}}.</div>
                                        <div class="block__separator rating_name"><img src="{{asset('img/av.png')}}" width="30" alt="">{{$r->name}} {{$r->last}}</div>
                                        <div class="block__separator rating_val">{{$r->lvl}}ур. <img src="{{asset('img/exp_rat.svg')}}" alt="" width="20"></div>
                                    </a>
                                </div>

                            @endforeach

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection