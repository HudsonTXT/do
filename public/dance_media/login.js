var auth;
$(function() {
    VK.init({
        apiId: 4004433
    });
    $('.loginVK').click(function() {
        VK.Auth.login(function(a) {
            if (a.session) {
                auth = a.session;
                $.post('http://fandance.ru/music/events.php?do=login', { id: auth.mid, name: auth.user.first_name, last: auth.user.last_name, href: auth.user.href },
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
        $.getJSON('http://fandance.ru/music/events.php?do=logout', function(json){
            alert(json.mes);
            location.reload();
        });
    });
});

function check_login(){
        $.getJSON('http://fandance.ru/music/events.php?do=check_login', function(json) {
        if (json.loginned) {
            //Loginned user
             VK.Api.call('users.get', {user_ids: json.user.mid, fields: 'photo_50'}, function(r){
                user = r.response[0];
                
                $('.user-image img').attr('src', user.photo_50);
                $('span.username').text(user.first_name + ' ' + user.last_name);
                $('span.coins').text(user.coins);
            })            
            $('section#login').slideUp(500, function() {
                $('section#select-music').slideDown();
            });
        } else {
            //Not lodinned
        }
    });
}
