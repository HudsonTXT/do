var songId = 0;
$(function () {
    VK.init({
        apiId: 4004433
    });


    $('#logout').click(function () {
        location.href='/api/logout';
    });
    /*
    $.getJSON('/api/songs', function (json) {
        if (json) {
            $('.dance__songs').html(' ');
            for (var i = json.length - 1; i >= 0; i--) {
                music = '<div class="block_element" data-song-id="' + json[i].id + '">';
                music += '<div class="block__separator dance__track">' + json[i].author + ' - ' + json[i].name + '</div>';
                music += '<div class="block__separator dance__bpm">' + json[i].bpm + ' BPM</div>';
                music += '<div class="block__separator dance__time">' + json[i].length + '</div>';
                music += '</div>';
                $('.dance__songs').append(music);
            }
        }
    });*/
    //check_login();
    //getActivity();
    VK.Api.call('users.get', {
        user_ids: vkId,
        fields: 'photo_100'
    }, function (r) {
        user = r.response[0];
        $('.sidebar_userinfo__avatar').attr('src', user.photo_100);
    });
});


/*
function check_login() {
    $.getJSON('/api/check', function (json) {
        if (json.loginned) {
            //Loginned user
            VK.Api.call('users.get', {
                user_ids: json.user.mid,
                fields: 'photo_100'
            }, function (r) {
                user = r.response[0];

                $('.sidebar_userinfo__avatar').attr('src', user.photo_100);
                $('.about__fio').text(user.first_name + ' ' + user.last_name);
                $('.about__money span').text(json.user.coins);
                $('.about__exp span').text(json.user.lvl);
            });
            getActivity();
        } else {
            //location.href = 'https://fandance.ru/music';
        }
    });
}
*/


/*
function getActivity() {
    $.getJSON('/api/activity', function (json) {
        $('.activity').html(' ');
        for (var i = json.length - 1; i >= 0; i--) {
            music = ' <div class="block_element">';
            music += '<div class="news__icon block__separator">';
            music += '<img src="/img/' + json[i].img + '">';
            music += '</div>';

            music += '<div class="news__text block__separator">' + json[i].text + '</div>';
            music += '</div>';
            $('.activity').append(music);
        }


    });
}
*/