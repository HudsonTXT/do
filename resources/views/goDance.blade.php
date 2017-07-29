<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" lang="ru">
    <title>DANCE ONLINE - BY FanDance.Ru</title>
    <script src="//code.jquery.com/jquery-2.0.3.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <script src="{{asset('/js/circle.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/css/fonts.css')}}">
    <script>
        arrSource = '{{asset('dance_media/music/arr.mp3')}}';
        imgSource = '{{asset('dance_media/image')}}/';
        var crsf = '{{ csrf_token() }}';
        var mus = {
            perfect: new Audio('{{asset('dance_media/music/perfect.mp3')}}'),
            cool: new Audio('{{asset('dance_media/music/cool.mp3')}}'),
            good: new Audio('{{asset('dance_media/music/good.mp3')}}'),
            bad: new Audio('{{asset('dance_media/music/bad.mp3')}}'),
            miss: new Audio('{{asset('dance_media/music/miss.mp3')}}')
        };
        var bpm = {{$song->bpm}};
        var song = new Audio('{!! $song->url !!}');
        var dur = '{{$song->length}}';
        var song_type = 0;
        var song_id = {{$song->id}};
    </script>
    <link rel="stylesheet" href="{{asset('dance_media/style.css')}}" type="text/css"/>
</head>
<body>
<div class="video-bg">
    <div class="effects"></div>
    <div class="video-fg">
        <iframe id="ytplayer" type="text/html"
                src="https://www.youtube.com/embed/{{$song->youtube}}?rel=0&enablejsapi=1&autoplay=1&controls=0&showinfo=0&loop=1&iv_load_policy=3&playlist={{$song->youtube}}"
                frameborder="0" allowfullscreen></iframe>
    </div>
</div>
<div class="loader">
    <img src="{{asset('dance_media/image/logo2.png')}}" align="center" width="400"/>
</div>
<div class="on_load_inputs">
    <div class="ocenka perfect"></div>
    <div class="ocenka cool"></div>
    <div class="ocenka bad"></div>
    <div class="ocenka miss"></div>
    <div class="ocenka good"></div>
    <div class="ar right"></div>
    <div class="ar left"></div>
    <div class="ar up"></div>
    <div class="ar down"></div>
    <div class="ar leftkl"></div>
    <div class="ar upkl"></div>
    <div class="ar downkl"></div>
    <div class="ar rightkl"></div>
</div>
<div class="dansez">
    <center><img src="{{asset('dance_media/image/logo2.png')}}" height="224" style="margin-top:83px;"/></center>
    <div class="dance">
        <div class="lvl"></div>
        <div class="lvlnum"></div>
        <div class="ocenka"></div>
        <div class="spacebar">
            <div class="control"></div>
            <div class="spacer"></div>
        </div>
        <div class="panel"></div>
    </div>
    <div class="music"></div>
    <div class="music_back">
        <audio id="music" src="" controls style="visibility: hidden;" autoplay></audio>
    </div>
    <div class="counter">
        <div class="song-info">
            <div class="counter-name">{{$song->author}}</div>
            <div class="counter-song">{{$song->name}}</div>
            <div class="counter-time"><span id="time-current">00:00</span>/<span id="time-duration">{{$song->length}}</span></div>
            <div class="counter-bpm">{{$song->bpm}}bpm</div>
        </div>
    </div>
    <div class="user-count">
        <div class="user-name">{{$u->name}} {{$u->last}}</div>
        <div class="user-score" id="pt">0</div>
    </div>
    /*
    <!--div class="info">
        <span class="time-bar"><span class="bar_inner"></span><span id="song-name">{{$song->author}}
                - {{$song->name}}</span></span>
        <span class="bpm"> [{{$song->bpm}} BPM]</span>
        <div class="score">Очки: <span id="pt">0</span><br/>

            /*
                Perfect: <span id="p">0</span>
                Cool: <span id="c">0</span>
                Good: <span id="g">0</span>
                Bad: <span id="b">0</span>
                Miss: <span id="m">0</span>
            */


        </div-->
    </div>
</div>
<div class="result">
    <div class="result_head">
        <div class="result_song">{{$song->author}} - {{$song->name}}</div>
        <div class="result_bpm">{{$song->bpm}} BPM</div>
    </div>
    <div class="result_info">
        <div class="result_part"></div>
        <div class="result_info_more">
            <div class="result_avgs">
                <div class="result_avg">
                    <div class="avg_part">
                    <img src="/dance_media/image/perfect_min.png" height="17" alt="">
                    </div>
                    <span id="p">0</span>
                </div>
                <div class="result_avg">
                    <div class="avg_part">
                    <img src="/dance_media/image/cool.png" height="17" alt="">
                    </div>
                    <span id="c">0</span>
                </div>
                <div class="result_avg">
                    <div class="avg_part">
                    <img src="/dance_media/image/good.png" height="17" alt="">
                    </div>
                    <span id="g">0</span>
                </div>
                <div class="result_avg">
                    <div class="avg_part">
                    <img src="/dance_media/image/bad.png" height="17" alt="">
                    </div>
                    <span id="b">0</span>
                </div>
                <div class="result_avg">
                    <div class="avg_part">
                    <img src="/dance_media/image/miss.png" height="17" alt="">
                    </div>
                    <span id="m">0</span>
                </div>
                <div class="result_avg">
                    <div class="avg_part">
                    <img src="/dance_media/image/points.png" height="17" alt="">
                    </div>
                    <span id="pts">0</span>
                </div>
            </div>
            <div class="result_etc">
                <div class="result_bonus">
                    <div class="bonus bonus_exp">
                        <img src="/img/exp.svg" width="48" alt=""><span id="exp">Опыт +0</span>
                    </div>
                    <div class="bonus bonus_money">
                        <img src="/img/money.svg" width="48" alt=""> <span id="coins">Кристаллы +0</span>
                    </div>
                </div>
                <div class="result_button"><span>Продолжить</span></div>
            </div>

        </div>
    </div>
</div>


<script src="{{asset('dance_media/danceByMe.js')}}"></script>
<script>
    var tag = document.createElement('script');

    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var player;

    function onYouTubeIframeAPIReady() {
        player = new YT.Player('ytplayer', {
            events: {
                'onReady': onPlayerReady
            }
        });
    }

    function onPlayerReady() {
        player.playVideo();
        // Mute!
        player.mute();
    }
</script>
</body>
</html>
