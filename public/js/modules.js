/* actvivity */

$(function () {
    $('.activity_menu .icon').click(function () {
        if ($('.activity_block').css('display') == 'none') {
            showActivity();
        } else {
            closeActivity();
        }
    });
    $(document).click(function (event) {
        if ($(event.target).closest(".activity_menu").length) return;
        closeActivity();
        event.stopPropagation();
    });
});

function showActivity() {
    $(".activity_block").removeClass('slideOutUp').addClass('animated slideInDown').css({
        display: 'block'
    });
    $.getJSON('/api/checkAct', function(){

    });
    $('div').removeClass('activity_new');
    $('.activity_menu').removeClass('animated');
}

function closeActivity() {
    $(".activity_block").removeClass('slideInDown').addClass('animated slideOutUp').delay(200).fadeOut();
}

/* Selecatble song */
$(document).on('click', '.dance__songs .block_element', function () {
    $('div').removeClass('dance__songs_selected');
    $(this).addClass('dance__songs_selected');
    $('.godance').slideDown()
    songId = $(this).attr('data-song-id');
});

$(document).on('click', '.godance', function () {
    if (songId != 0) {
        location.href = '/dance/go/' + songId;
    } else {
        alert('Пожалуйста, выберите трек!');
    }

});

String.prototype.toHHMMSS = function () {
    var sec_num = parseInt(this, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    return hours+':'+minutes+':'+seconds;
};

$(function(){
    if(chest != 'none' && chest != 'ready'){
        $('.sunduk_after span').text(chest.toString(10).toHHMMSS());
        chest--;
        setInterval(function(){
            if(chest > 0){
                $('.sunduk_after span').text(chest.toString(10).toHHMMSS());
                chest--;
            }else{
                location.reload();
            }

        }, 1000);
    }else{
        $('.sunduk').addClass('animated pulse infinite');
    }

    $('.sunduk').click(function(){
        if(chest == 'none' || chest == 'ready'){
            $.getJSON('/chest/dialy', function(json){
                alert(json);
            });

            chest = 10800;
            $('.sunduk').append('<div class="sunduk_after"><span></span></div>').removeClass('animated');
            setInterval(function(){
                if(chest > 0){
                    $('.sunduk_after span').text(chest.toString(10).toHHMMSS());
                    chest--;
                }else{
                    location.reload();
                }

            }, 1000);

        }
    });
    $('.tourninrs span').text(tournirs.toString().toHHMMSS());
    $('#timer_time').text(tournirs.toString().toHHMMSS());
    tournirs--;
    setInterval(function(){
        if(tournirs <= 0){
            tournirs = 24*3600;
        }
        $('.tourninrs span').text(tournirs.toString().toHHMMSS());
        $('#timer_time').text(tournirs.toString().toHHMMSS());
        tournirs--;
    }, 1000);
});
