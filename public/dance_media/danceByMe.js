/**
 * fandance.ru
 * Created by Lev Belousov vk.com/leosan
 * created 15.11 / complete 17.11 /release 22.11 / last vers. 22.01.2014
 *  + Отредактирован параметр, по которому расчитывается бит.
 *  + Исправлен баг с отображением стрелок в конце песни.
 *  + Изменена система расчета очков

 last vers. 28.01.2017
 Обновление дизайна, смена механики выбора песни.

 last vers/ 09.03.2017
 Обновление. Отправка результатов танца на сервер для статистики.
 +js prettify
 - отказ от keypress.js

 */

$(function () {
    var level = 0;
    var arrow = 0; //Сколько стрелок выведено
    var status = 1;
    var barSpace = 0;
    var musica = document.getElementById("music");
    var sec = (4 * (60 / bpm)) * 1000;
    var pre_level = 3;
    var perfect = 0;
    var cool = 0;
    var good = 0;
    var bad = 0;
    var miss = 0;
    var RecordsShow = 0;
    var pt = 0;

    function obsOcenka() {
        steps = perfect + cool + good + bad + miss;
        pointos = (perfect * 5) + (cool * 4) + (good * 3) + (bad * 2) + miss;
        srArefm = Math.round(pointos / steps);
        if (srArefm == 5) {
            Obshocenka = "SS";
        } else if (srArefm == 4) {
            Obshocenka = "S";
        } else if (srArefm == 3) {
            Obshocenka = "A";
        } else if (srArefm == 2) {
            Obshocenka = "B";
        } else if (srArefm <= 1) {
            Obshocenka = "C";
        }
        if(steps == perfect){
            Obshocenka = "P";
        }
        $('.result_part').addClass(Obshocenka.toLocaleLowerCase());
    }

    function minObshOcenk() {
        steps = perfect + cool + good + bad + miss;
        pointos = (perfect * 5) + (cool * 4) + (good * 3) + (bad * 2) + miss;
        srArefm = Math.round(pointos / steps);
        return {steps: steps, points: pointos, arefm: srArefm};
    }

    function results() {
        if (song.ended) {
            $('.video-bg').addClass('blurred');
            $('.effects').remove();
            RecordsShow++;
            if (RecordsShow == 1) {
                setTimeout(function () {
                    $('#p').text(perfect);
                    $('#c').text(cool);
                    $('#g').text(good);
                    $('#b').text(bad);
                    $('#m').text(miss);
                    scoresPts = pt;
                    $('#pts').text(scoresPts);
                    obsOcenka();
                    if (song_type == 1) {
                        //some code will be here
                    } else {
                        $.post('/api/result', {
                            _token: crsf, song_type: song_type, song_id: song_id, bpm: bpm, points: scoresPts,
                            baseinfo: minObshOcenk(),
                            parts: {p: perfect, c: cool, g: good, b: bad, m: miss}
                        }, function (json) {
                            //some info after sending
                            $('#coins').text('Кристаллы +' + json.coins);
                            $('#exp').text('Опыт +' + json.exp);
                            $.each(json.rating, function(i, val){
                                $('.rating_peoples').append('<div class="rating_people"><span class="fio">'+val.name+' '+val.last+'</span><span class="score">'+val.score+'</span></div>');
                            });

                        }, 'json');
                    }

                    res = $('.result');
                    $('.dansez').html(res);
                    res.slideDown(500);
                }, sec + sec / 2);

            }
        }
    }

    function points(ocenka) {
        var coolRating = {
            1: 600,
            2: 675,
            3: 825,
            4: 1050,
            5: 1350,
            6: 1725,
            7: 2175,
            8: 2700,
            9: 3300,
            10: 3975,
            11: 4725
        };
        var points = {
            perfect: coolRating[level] / 100 * 200,
            cool: coolRating[level],
            good: coolRating[level] / 100 * 70,
            bad: coolRating[level] / 100 * 45,
            miss: 0
        };
        pt = Math.floor(pt + points[ocenka]);
        $('#pt').text(pt);
        return pt;
    }

    function codeOcenka(ocenka) { ///////КОДОВАЯ ОЦЕНКА, ТАК СКАЗАТЬ///////
        $('.ocenka').css('opacity', 1).addClass(ocenka);
        if (ocenka == 'perfect') {
            $('.effects').addClass('perfect');
        } else {
            $('.effects').removeClass('perfect');
        }
        if (ocenka == 'miss') {
            $('.effects').addClass('miss');
        } else {
            $('.effects').removeClass('miss');
        }
        if (ocenka == 'bad') {
            $('.effects').addClass('bad');
        } else {
            $('.effects').removeClass('bad');
        }
        if (ocenka == 'cool') {
            $('.effects').addClass('cool');
        } else {
            $('.effects').removeClass('cool');
        }
        if (ocenka == 'good') {
            $('.effects').addClass('good');
        } else {
            $('.effects').removeClass('good');
        }

        mus[ocenka].volume = 1;
        mus[ocenka].pause();
        mus[ocenka].play();
        ocenkos = ocenka + "++";
        eval(ocenkos);
        points(ocenka);
        $('.panel').html("");
    }

    function TextToNum(left) {
        var spacer = Number(left.replace('px', ""));
        return spacer;
    }

    /* function codeOcenka(ocenka){ ///////КОДОВАЯ ОЦЕНКА, ТАК СКАЗАТЬ///////
     $('.ocenka').css({background: 'url(image/'+ocenka+'.png) center center no-repeat'});
     }*/
    function ocenkaHide() {
        setTimeout(function () {
            $('.ocenka').animate({opacity: 0}, 500, function () {
                $(this).removeClass('perfect').removeClass('good').removeClass('cool').removeClass('bad').removeClass('miss');
            });
        }, sec + sec / 2);
    }

    function buttons(arr0) { /////ПРОВЕРКА СТРЕЛОЧЕК!!!!!!//////
        var has = $(".panel>div.non:first").hasClass(arr0);
        if (has == true) {
            $('.panel>div.non:first').removeClass('non').removeClass(arr0).addClass(arr0 + "kl");
            //arr.play();
            new Audio(arrSource).play();
        } else if ($(".panel>div").hasClass("non") == false) {
        } else {
            $('.panel').html(pre);
        }
    }

    function spacer() { //Анимашка для пробела//////ТУТ ВСЯ СУТЬ, ДА. НЕ ЗАБУДЬ РАСПЕЧАТАТЬ И ЗАПОМНИТЬ ЭТО, МОЙ ЛЮБОПЫТНЫЙ ДРУГ./////
        if (song.ended == false && song.paused == false) {
            $('.spacer').animate({left: '182px'}, sec, 'linear', function () {
                $(this).css({left: '0px'});
                if (status <= 0) {
                    if (song.currentTime * 1000 + sec * 2 < song.seekable.end(0) * 1000) {
                        if (barSpace == 0) {
                            codeOcenka("miss");
                        }
                    }

                    //$('.panel').html("");
                    status++;
                } else {

                    if (pre_level > 2) {
                        if (level > 9) {
                            level = 1;
                        } else {
                            level++;
                        }
                        pre_level = 1;
                    }
                    $('.lvlnum').css({background: 'url(' + imgSource + level + '.png) center center no-repeat'});
                    arrow = 0;
                    getArrow(level, arrow);
                    ocenkaHide();
                    pre_level++;
                    status--;
                    barSpace = 0;
                    // $('.ocenka').css({visibility: 'hidden'});
                }
                return arrow, level, status;
            });
        } else {
            $(this).css({left: '0px'});
        }
    }

    function randomFromInterval(from, to) { ///TYPICAL RANDOM, BY WORLD!////
        return Math.floor((Math.random() * (to - from + 1)) + from);
    }

    function getArrow(level, arrow) { //////СТРЕЛОЧКИИИ!!!//////

        $('.panel').html("");
        pre = "";
        if (song.currentTime * 1000 + sec * 2 < song.seekable.end(0) * 1000) {
            var now = 0;
            while (arrow != level) {
                generator = randomFromInterval(1, 8);
                if (now == generator) {
                    generator = randomFromInterval(1, 8);
                }
                var storons = ["", "right", "up", "left", "down", "right", "up", "left", "down"];
                pre = pre + '<div class="' + storons[generator] + ' arrow' + generator + ' non ar"></div>';
                arrow++;
                now = generator;
            }
            $('.panel').html(pre);
        }
        return pre;
    }

////////КНОПКИ УПРАВЛЕНИЯ////////
    $(document).on('keydown', function (e) {
        key = e.key;
        if (key == "ArrowUp" || key == "w" || key == "Up") {
            var arr0 = "up";
            buttons(arr0);
        }
        if (key == "ArrowDown" || key == "s" || key == "Down") {
            var arr0 = "down";
            buttons(arr0);
        }
        if (key == "ArrowLeft" || key == "a" || key == "Left") {
            var arr0 = "left";
            buttons(arr0);
        }
        if (key == "ArrowRight" || key == "d" || key == "Right") {
            var arr0 = "right";
            buttons(arr0);
        }
        if (key == "Home") {
            $('.video-bg').remove();
        }
        if (key == ' ' || key == 'Control') {
            if (barSpace == 0) {
                spacebar();
                //$('.music').html(space);
                barSpace = 1;
            }
            return barSpace;
        }

    });


    function spacebar() { /////////SPACE'BARCHIK//////////

        $('.panel>div').fadeOut();
        proverka_on_miss = $(".panel>div").hasClass("non");
        if (proverka_on_miss) {
            codeOcenka("miss");
        } else {
            //переписать
            var spacer = TextToNum($('.spacer').css('left'));
            if (spacer >= 142 && spacer <= 148) {
                codeOcenka("perfect");
            } else if (spacer >= 139 && spacer <= 142 || spacer > 148 && spacer <= 151) {
                codeOcenka("cool");
            } else if (spacer >= 135 && spacer <= 139 || spacer > 151 && spacer <= 155) {
                codeOcenka("good");
            } else if (spacer >= 130 && spacer <= 135 || spacer > 155 && spacer <= 160) {
                codeOcenka("bad");
            } else {
                codeOcenka("miss");
            }
        }
    }

    songP = 0;

    function songPlay() {
        if (songP == 0) {
            song.play();
            songP = 1;
        } else {

        }
        return songP;
    }

/////TIMERSSSSSSSSSSS!!!!!//////////

    song.addEventListener('canplaythrough', function () {
        songPlay();
        $('.on_load_inputs').remove();
        $('.loader').fadeOut(500);

        $('#p').text(perfect);
        $('#c').text(cool);
        $('#g').text(good);
        $('#b').text(bad);
        $('#m').text(miss);
        setInterval(function () {
            spacer();
        }, sec);
    }, false);

    var lastTime = 0;
    song.addEventListener('timeupdate', function () {
        var duration = song.currentTime; //song is object of audio.  song= new Audio();

        var sec= new Number();
        var min= new Number();
        sec = Math.floor( duration );
        min = Math.floor( sec / 60 );
        min = min >= 10 ? min : '0' + min;
        sec = Math.floor( sec % 60 );
        sec = sec >= 10 ? sec : '0' + sec;
        $('#time-current').text(min + ':' + sec);
        newTime = song.currentTime / song.duration;
        $('.counter').circleProgress({
            size: 200,
            value: newTime,
            lineCap: 'round',
            startAngle: 0.5 * -Math.PI,
            emptyFill: "rgba(255, 255, 255, .2)",
            animation: { duration: 50, easing: "linear" },
            animationStartValue: lastTime,
            fill: {
                gradient: ["#00dbde", "#fc00ff"]

            }
        });
        lastTime = newTime;
        //time = Math.floor(song.currentTime / 60) + ':' + Math.floor(song.currentTime % 60) + "/" + Math.floor(song.seekable.end(0) / 60) + ':' + Math.floor(song.seekable.end(0) % 60);
        //$('.time').html(time);
        //$('.bar_inner').css('width', song.currentTime / song.duration * 100 + '%');
        //(song.currentTime/song.duration)*100
    });
    song.addEventListener('ended', function () {
        song.pause();
        //player.stopVideo();
        results();
    }, false);

    $('.result_button').click(function () {
        window.location = '/dance';
    });
});
