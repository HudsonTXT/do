<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" lang="ru">
    <title>DanceOnline!</title>
    <meta name="csrf-token" content="{{ $token }}">

    <meta name="viewport" content="width=940, user-scalable=no">
    <link rel="stylesheet" href="landing/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <meta name="description" content="«DanceOnline!» – сервис, позволяющий заменить все танцевальные игры!В «DanceOnline!» вы можете тренировать свои танцевальные навыки. Просто авторизируйтесь, выберите песню и танцуйте! ">
    <meta property="og:title" content="DanceOnline!" />
    <meta property="og:type" content="page" />
    <meta property="og:image" content="http://fandance.ru/images/prew.jpg" />
    <meta property="og:description" content="«DanceOnline!» – сервис, позволяющий заменить все танцевальные игры!В «DanceOnline!» вы можете тренировать свои танцевальные навыки. Просто авторизируйтесь, выберите песню и танцуйте! " />
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="landing/js/wow.min.js"></script>

    <script>
        new WOW().init();
        var crsf = '{{ $token }}';
    </script>
    <script src="landing/js/script.js"></script>
    <script src="landing/js/login.js"></script>
</head>

<body>
<section id="home" class="wow fadeIn">
    <div class="head">
        <span>Танцуй</span>
        <div class="button">Авторизация</div>

    </div>
    <div class="scroll-go"></div>
    <iframe id="ytplayer" type="text/html" src="https://www.youtube.com/embed/bDChhe7hhII?rel=0&enablejsapi=1&autoplay=1&controls=0&showinfo=0&loop=1&iv_load_policy=3&playlist=bDChhe7hhII" frameborder="0" allowfullscreen></iframe>
</section>

<section id="about">
    <div class="wrap">
        <div class="about-left wow fadeInDown">
            <h2>О сервисе</h2>
            <p>«DanceOnline!» – сервис, позволяющий заменить все танцевальные игры! <br><br> Сервис создан в 2014 году, форумом танцевальных игр – FanDance. Мы регулярно проводим опросы у пользователей, и добавляем песни в свою музыкальную коллекцию. Также, мы постоянно совершенствуем и оптимизируем сервис. <br><br> В «DanceOnline!» вы можете тренировать свои танцевальные навыки. Просто авторизируйтесь, выберите песню и танцуйте! Набирайте комбинацию стрелок, которую видите на экране, а также нажимайте пробел, когда бегунок достигнет подсвеченной зоны. После завершения танца вы получите кристаллы и опыт, а также сможете посмотреть результаты танца и поделиться ими с друзьями!
            </p>
        </div>
        <div class="about-right wow fadeInRight"></div>
    </div>

</section>
<section id="music" class="wow fadeInDown">
    <div class="wrap">
        <h2>Музыка <span>— наша музыкальная коллекция регулярно обновляется, а пользователи могут танцевать под свои треки!</span></h2>
        <div class="music-slider">
            <div class="m-block wow fadeInLeft"><img src="landing/img/m-1.png" alt="">
                <div class="song-info">
                    <span class="author">Madonna</span><span class="song">Living for love</span>
                </div>
            </div>
            <div class="m-block active wow fadeInUp"><img src="landing/img/m-2.png" alt="">
                <div class="song-info">
                    <span class="author">Adele</span><span class="song">Hello</span>
                </div>
            </div>
            <div class="m-block wow fadeInRight"><img src="landing/img/1.jpg" alt="">
                <div class="song-info">
                    <span class="author">BLACKPINK</span><span class="song">Boombayah</span>
                </div>
            </div>
        </div>
        <div class="m-pagination" style="display: none;">
            <div class="m-pag active"></div>
            <div class="m-pag"></div>
            <div class="m-pag"></div>
        </div>
    </div>
</section>
<section id="features" class="wow slideInUp">
    <div class="wrap">
        <h2>Преимущества</h2>
        <div class="f-slider wow fadeInUp">
            <div class="f-elems">


                <div class="f-elem">
                    <div class="f-img"><img src="landing/img/free.svg" alt=""></div>
                    <div class="f-text">
                        <div class="f-head">Бесплатно</div>
                        <div class="f-desc">Мы предоставляем наш сервис абсолютно бесплатно! Вы можете воспользоваться всеми функциями прямо сейчас.</div>
                    </div>
                </div>

                <div class="f-elem">
                    <div class="f-img"><img src="landing/img/vk.svg" alt=""></div>
                    <div class="f-text">
                        <div class="f-head">Авторизация</div>
                        <div class="f-desc">Для входа в сервис Вам нужно всего лишь иметь аккаунт ВКонтакте.</div>
                    </div>
                </div>
                <div class="f-elem">
                    <div class="f-img"><img src="landing/img/music.svg" alt=""></div>
                    <div class="f-text">
                        <div class="f-head">Любой трек</div>
                        <div class="f-desc">Вы можете выбрать трек из нашей музыкальной коллекции, а можете загрузить свой!</div>
                    </div>
                </div>
                <div class="f-elem">
                    <div class="f-img"><img src="landing/img/favourite.svg" alt=""></div>
                    <div class="f-text">
                        <div class="f-head">Статистика</div>
                        <div class="f-desc">После каждого танца Вы можете посмотреть оценку, заработать кристаллы и попасть в рейтинг танцоров.</div>
                    </div>
                </div>
            </div>
            <div class="f-pag">
                <div class="f-left"></div>
                <div class="f-right"></div>
            </div>
        </div>
    </div>
</section>
<section id="howtostart">
    <div class="wrap">
        <h2>С чего начать?</h2>
        <div class="steps">
            <div class="s-column wow fadeInLeft">
                <div class="s-num">1</div>
                <div class="s-head">Авторизация</div>
                <div class="s-desc">Зайди на play.fandance.ru и авторизиуйся с помощью VK.</div>
            </div>
            <div class="s-column wow fadeInUp">
                <div class="s-num">2</div>
                <div class="s-head">Выбор трека</div>
                <div class="s-desc">Выбери любимый трек из музкальной библиотеки или загрузи свой с помощью URL. Не забудь выбрать бит!</div>
            </div>
            <div class="s-column wow fadeInRight">
                <div class="s-num">3</div>
                <div class="s-head">Танцуй!</div>
                <div class="s-desc">Набирай комбинацию стрелок на клавиатуре, которые ты видишь, жми пробел, когда ползунок достигнет белой области. Зарабатывай очки, получай кристаллы и рассказывай друзьям!</div>
            </div>
        </div>
        <div class="button wow zoomIn">Авторизация</div>
    </div>
</section>
<section id="footer">
    <div class="wrap">
        <div class="f-column">
            <a href="/">Главная</a>
            <a href="#about">О сервисе</a>
            <a href="#music">Музыка</a>
            <a href="#features">Преимущества</a>
            <a href="#howtostart">С чего начать?</a>
            <a href="https://vk.com/topic-55487263_36089582" target="_blank">Помощь</a>
            <a href="https://vk.com/topic-55487263_36089582" target="_blank">Предложить песню</a>
            <a href="https://vk.com/topic-55487263_36089582" target="_blank">Отзыв</a>
        </div>
        <div class="f-column">
            <a href="http://fandance.ru" target="_blank">FanDance</a>
            <a href="http://fandance.ru/news.php" target="_blank">Новости</a>
            <a href="http://fandance.ru/games.php" target="_blank">Каталог игр</a>
            <a href="http://forum.fandance.ru/" target="_blank">Форум</a>
            <a href="https://vk.com/fan_dance" target="_blank">Мы ВКонтакте</a>
        </div>
        <div class="f-column">
            <script type="text/javascript" src="//vk.com/js/api/openapi.js?146"></script>

            <!-- VK Widget -->
            <div id="vk_groups"></div>
            <script type="text/javascript">
                VK.Widgets.Group("vk_groups", {
                    mode: 3,
                    width: "293",
                    color1: '333',
                    color2: 'FFFFFF',
                    color3: 'FFFFFF'
                }, 55487263);

            </script>
        </div>
    </div>
</section>
</body>

</html>
<!--THANK YOU BRACKETS, JQUERY, GITHUB, SASS AND MOM <3 -->
