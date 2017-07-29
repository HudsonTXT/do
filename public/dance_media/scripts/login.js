var auth;
$(function() {
    VK.init({
        apiId: 4004433
    });
    $('.loginVK').click(function() {
        VK.Auth.login(function(a) {
            if (a.session) {
                auth = a.session;
                $.post('events.php?do=login', { id: auth.mid, name: auth.user.first_name, last: auth.user.last_name, href: auth.user.href },
                    function(data) {
                        if (data.length > 0) {
                            alert(data[0]);
                        } else {
                            check_login();
                        }
                    }, "json");
                //alert('Добро Пожаловать, ' + auth.user.first_name);

            } else {
                $('#login p').html('К сожалению, вы не смогли авторизоваться.<br/>Пожалуйста, повторите попытку ещё раз.').css({ color: 'red', fontWeight: 'bolder' });
            }
            //console.log(auth);

        });


    });
    check_login();

    $('#logout').click(function(){
        $.getJSON('events.php?do=logout', function(json){
            alert(json.mes);
            location.reload();
        });
    });
});

function check_login(){
        $.getJSON('events.php?do=check_login', function(json) {
        if (json.loginned) {
            //Loginned user
             VK.Api.call('users.get', {user_ids: json.user.mid, fields: 'photo_50'}, function(r){
                user = r.response[0];
                
                $('.user-image img').attr('src', user.photo_50);
                $('span.username').text(user.first_name + ' ' + user.last_name);
                $('span.coins').text(json.user.coins);
            })            
            $('section#login').slideUp(500, function() {
                $('section#select-music').slideDown();
            });

            //load music list
            var musicList;
            $.getJSON('events.php?do=getSongs', function(json){
                //musicList = json;
                if(json){
                    for (var i = json.length - 1; i >= 0; i--) {
                        music = '<div class="music_item" data-song-id="'+json[i].id+'">';
                        music += '<div class="item__name">'+json[i].author+' - '+json[i].name+'</div>';
                        music += '<div class="item__bpm">'+json[i].bpm+' BPM</div>';
                        music += '<div class="item__length">'+json[i].length+'</div>';
                        music += '</div>';
                        $('.music_list').append(music);
                    }
                }
            });
        } else {
            //Not lodinned
        }
    });
}

/* Song select type change */
var song_type; // false = our songs, true = url song
function song_type_middle(){
    if(!song_type){
        //Show URL form
        $('.music_list').slideUp(500, function () {
            $('.music_url').slideDown();
            $('.select_type_buttons').html('<h1><a href="#">Выбрать песню</a> или Ввести URL</h1>');
            song_type = true;
        });
        
    }else{
        //Show song presets form
        $('.music_url').slideUp(500, function () {
            $('.music_list').slideDown();
            $('.select_type_buttons').html('<h1>Выбрать песню или <a href="#">Ввести URL</a></h1>');            
            song_type = false; 
        });        
               
    }
}

var song_id;
/* Controllers */
$(document).on('click', '.select_type_buttons a', song_type_middle);
$(document).on('click', '.music_item', function () {
    $('.music_item').removeClass('active_item');
    $(this).toggleClass('active_item');
    song_id = $(this).attr('data-song-id');
})

$(document).on('click', '.start_dance', function(){  //Button "Начать танец" 
    if(!song_type){
        if(song_id){
            location.href = 'dance.php?type=0&song_id=' + song_id;
        }else{
            alert('Пожалуйста, выберите песню перед началом танца!');
        }
    }else{
        if($('.url').val().length != 0 && $('.bpm').val().length != 0){
            location.href = 'dance.php?type=1&song='+$('.url').val()+'&bpm='+$('.bpm').val();
        }else{
            alert('Пожалуйста, введите URL и BPM!');
        }
    }
});