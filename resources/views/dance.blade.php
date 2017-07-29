@extends('layouts.app')
@section('scripts')
    @if($u->tut)
        <script src="{{asset('js/intro.min.js')}}"></script>
        <link rel="stylesheet" href="{{asset('js/introjs.min.css')}}">
        <script>
            $(function () {
                var intro = introJs();
                intro.setOptions({
                    steps: [
                        {
                            intro: "Привет, {{$u->name}}! Давай я расскажу тебе о DanceOnline?"
                        },
                        {
                            element: '.sidebar_userinfo',
                            intro: "Здесь отображается актуальная информация о самом важном: монетах и уровне.",
                        },
                        {
                            element: '.activity_menu',
                            intro: "А тут можно посмотреть уведомления.",
                        },
                        {
                            intro: "Главная цель проекта - это танцы! Давай посмотрим, как начать танец?"
                        },
                        {
                            element: '.dance .block_content',
                            intro: "Чтобы начать танец, тебе необходимо выбрать трек...",
                        },
                        {
                            element: '.godance',
                            intro: "Затем нажать сюда.",
                        },
                        {
                            intro: "Во время танца твоей задачей будет нажимать стрелки, изображенные на экране и пробел, когда бегунок достигнет подсвеченой зоны.",
                        },
                        {
                            element: '.sidebar_menu__item:nth-child(3)',
                            intro: "После каждого танца ты будешь получать опыт и кристаллы. Самые активные и богатые танцоры попадают в рейтинг.",
                        },
                        {
                            intro: "Добро пожаловать в мир танцев, {{$u->name}}! За завершение обучения ты получаешь 1000 очков опыта и 10 монет! Если у тебя появятся вопросы, то пиши их в <a href='https://vk.com/fan_dance'>нашу группу.</a>",

                        },
                    ]
                });
                intro.setOption("skipLabel", "Выход").setOption("nextLabel", "Далее").setOption("prevLabel", "Назад").setOption("doneLabel", "Завершить").setOption('showProgress', true).start();
                intro.oncomplete(function () {
                    $.getJSON('/api/tutorialEnd', function (json) {
                        if (json) {
                            location.reload();
                        }

                    });
                });

            });

        </script>
    @endif
@endsection
@section('content')
    <div class="block dance">
        <div class="block_header">Выбор трека</div>
        <div class="block_description">Выбери трек и нажми кнопку Танцевать! Во время танца нажимай стрелки, появляющиеся на экране, а также пробел, когда бегунок достигнет подсвеченой зоны.</div>
        <div class="block_content">
            <div class="block_element dance__fixed ">
                <div class="block__separator dance__track">Исполнитель - Название</div>
                <div class="block__separator dance__bpm">BPM</div>
                <div class="block__separator dance__time">Время</div>
            </div>
            <div class="dance__songs">
                @foreach ($s as $song)
                    <div class="block_element" data-song-id="{{$song->id}}">
                        <div class="block__separator dance__track">{{$song->author}} - {{$song->name}}</div>
                        <div class="block__separator dance__bpm">{{$song->bpm}}</div>
                        <div class="block__separator dance__time">{{$song->length}}</div>
                    </div>
                @endforeach


            </div>

        </div>
        <div class="button godance">Танцевать</div>
    </div>
@endsection