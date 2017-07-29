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

function obsOcenka() {
    steps = perfect + cool + good + bad + miss;
    pointos = (perfect * 5) + (cool * 4) + (good * 3) + (bad * 2) + miss;
    srArefm = Math.round(pointos / steps);
    if (srArefm == 5) {
        Obshocenka = "S";
    } else if (srArefm == 4) {
        Obshocenka = "A";
    } else if (srArefm == 3) {
        Obshocenka = "B";
    } else if (srArefm == 2) {
        Obshocenka = "C";
    } else if (srArefm <= 1) {
        Obshocenka = "D";
    }
    $('.Obshocenka').text(Obshocenka);
}

function results() {
    if (song.ended) {
        RecordsShow++;
        if (RecordsShow == 1) {
            setTimeout(function() {
                $('#p').text(perfect);
                $('#c').text(cool);
                $('#g').text(good);
                $('#b').text(bad);
                $('#m').text(miss);
                scoresPts = $('#pt').text();
                $('#pts').text(scoresPts);
                obsOcenka();
                $('.shared').html(VK.Share.button({
                    url: 'http://fandance.ru/music',
                    title: 'Dance Online - FanDance.Ru',
                    description: 'Я станцевал под песню ' + $('.result > .artist').text() + ' и набрал ' + scoresPts + ' очков!'
                }, { type: "round", text: "Рассказать друзьям" }));

                res = $('.result');
                $('.dansez').html(res);
                res.slideDown(500);
            }, sec + sec / 2);

        }
    }
}

function proverkaFlasha() {
    if (navigator.plugins["Shockwave Flash"]) {
        //$('.control').html('<embed width="44px" height="18px" name="plugin" src="ClassicKey/Sprite/sprite332.swf" wmode="transparent" type="application/x-shockwave-flash">');
        $('.control').css({ background: 'url(image/control.png)' });
    } else {
        $('.control').css({ background: 'url(image/control.png)' });
    }
}

function points(ocenka) {
    pt = Number($('#pt').text());
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
    var points = { perfect: coolRating[level] / 100 * 200, cool: coolRating[level], good: coolRating[level] / 100 * 70, bad: coolRating[level] / 100 * 45, miss: 0 };
    pt = Math.floor(pt + points[ocenka]);
    $('#pt').text(pt);
    return pt;
}

function codeOcenka(ocenka) { ///////КОДОВАЯ ОЦЕНКА, ТАК СКАЗАТЬ///////
    $('.ocenka').css({ background: 'url(image/' + ocenka + '.png) center center no-repeat', visibility: 'visible' });
    mus[ocenka].volume = 0.7;
    mus[ocenka].pause();
    mus[ocenka].play();
    ocenkos = ocenka + "++";
    eval(ocenkos);
    points(ocenka);
}

function TextToNum(left) {
    var spacer = Number(left.replace('px', ""));
    return spacer; }
/* function codeOcenka(ocenka){ ///////КОДОВАЯ ОЦЕНКА, ТАК СКАЗАТЬ///////
 $('.ocenka').css({background: 'url(image/'+ocenka+'.png) center center no-repeat'});
 }*/
function ocenkaHide() { setTimeout(function() { $('.ocenka').css({ 'background': '' }); }, sec + sec / 2); }

function buttons(arr0) { /////ПРОВЕРКА СТРЕЛОЧЕК!!!!!!//////
    var has = $(".panel>div.non:first").hasClass(arr0);
    if (has == true) { $('.panel>div.non:first').removeClass('non').removeClass(arr0).addClass(arr0 + "kl");
        arr.play(); } else if ($(".panel>div").hasClass("non") == false) {} else { $('.panel').html(pre); }
}

function spacer() { //Анимашка для пробела//////ТУТ ВСЯ СУТЬ, ДА. НЕ ЗАБУДЬ РАСПЕЧАТАТЬ И ЗАПОМНИТЬ ЭТО, МОЙ ЛЮБОПЫТНЫЙ ДРУГ./////
    if (song.ended == false && song.paused == false) {
        $('.spacer').animate({ left: '182px' }, sec, 'linear', function() {
            $(this).css({ left: '0px' });
            if (status <= 0) {
                if (song.currentTime * 1000 + sec * 2 < song.seekable.end(0) * 1000) {
                    if (barSpace == 0) { codeOcenka("miss"); } }
                $('.panel').html("");
                status++;
            } else {

                if (pre_level > 2) {
                    if (level > 9) { level = 1; } else { level++; }
                    pre_level = 1;
                }
                $('.lvlnum').css({ background: 'url(image/' + level + '.png) center center no-repeat' });
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
        $(this).css({ left: '0px' });
    }
}

function randomFromInterval(from, to) { ///TYPICAL RANDOM, BY WORLD!////
    return Math.floor((Math.random() * (to - from + 1)) + from);
}

function getArrow(level, arrow) { //////СТРЕЛОЧКИИИ!!!//////

    $('.panel').html("");
    pre = "";
    if (song.currentTime * 1000 + sec * 2 < song.seekable.end(0) * 1000) {
        while (arrow != level) {
            generator = randomFromInterval(1, 4);
            var storons = ["", "right", "up", "left", "down"];
            pre = pre + '<div class="' + storons[generator] + ' arrow' + generator + ' non ar"></div>';
            arrow++;
        }
        $('.panel').html(pre);
    }
    return pre;
}
////////КНОПКИ УПРАВЛЕНИЯ////////
keypress.combo("up", function() {
    var arr0 = "up";
    buttons(arr0);
});
keypress.combo("down", function() {
    var arr0 = "down";
    buttons(arr0);
});
keypress.combo("left", function() {
    var arr0 = "left";
    buttons(arr0);
});
keypress.combo("right", function() {
    var arr0 = "right";
    buttons(arr0);
});
keypress.combo("w", function() {
    var arr0 = "up";
    buttons(arr0);
});
keypress.combo("s", function() {
    var arr0 = "down";
    buttons(arr0);
});
keypress.combo("a", function() {
    var arr0 = "left";
    buttons(arr0);
});
keypress.combo("d", function() {
    var arr0 = "right";
    buttons(arr0);
});


function spacebar() { /////////SPACE'BARCHIK//////////

    $('.panel>div').fadeOut();
    proverka_on_miss = $(".panel>div").hasClass("non");
    if (proverka_on_miss) {
        codeOcenka("miss");
    } else {
        var spacer = TextToNum($('.spacer').css('left'));
        if (spacer >= 143 && spacer <= 145) { codeOcenka("perfect"); } else if (spacer >= 141 && spacer <= 143 || spacer > 145 && spacer <= 147) { codeOcenka("cool"); } else if (spacer >= 138 && spacer <= 141 || spacer > 147 && spacer <= 153) { codeOcenka("good"); } else if (spacer >= 135 && spacer <= 138 || spacer > 153 && spacer <= 160) { codeOcenka("bad"); } else { codeOcenka("miss"); }
    }
}
keypress.combo("space", function() {
    if (barSpace == 0) {
        spacebar();
        //$('.music').html(space);
        barSpace = 1;
    }
    return barSpace;
});
keypress.combo("ctrl", function() {
    if (barSpace == 0) {
        spacebar();
        //$('.music').html(space);
        barSpace = 1;
    }
    return barSpace;
});
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
setInterval(function() {
    if (Math.ceil(song.seekable.end(0)) >= dur + 1) {
        songPlay();
        $('.loader').slideUp(500);
        time = Math.floor(song.currentTime / 60) + ':' + Math.floor(song.currentTime % 60) + "/" + Math.floor(song.seekable.end(0) / 60) + ':' + Math.floor(song.seekable.end(0) % 60);
        $('.time').html(time);
        $('#p').text(perfect);
        $('#c').text(cool);
        $('#g').text(good);
        $('#b').text(bad);
        $('#m').text(miss);
        if (song.ended) {
            song.pause();
            results();
        }
    }

}, 0);
setInterval(function() {
    if (song.seekable.end(0) >= dur) { spacer(); } }, sec);
proverkaFlasha();
