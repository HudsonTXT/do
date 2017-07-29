var auth;
$(function () {
    VK.init({
        apiId: 4004433
    });
    $('.loginVK').click(function () {
        VK.Auth.login(function (a) {
            if (a.session) {
                auth = a.session;
                $.post('http://fandance.ru/music/events.php?do=login', {id: auth.mid, name: auth.user.first_name, last: auth.user.last_name, href: auth.user.href}, 
                    function(data){
                    if(data.length > 0){
                        alert(data[0]);
                    }else{
                        $('section#login').slideUp(500, function () {
                            $('section#select-music').slideDown();
                        });
                    }
                }, "json");
                //alert('Добро Пожаловать, ' + auth.user.first_name);

            }else{
                $('#login p').html('К сожалению, вы не смогли авторизоваться.<br/>Пожалуйста, повторите попытку ещё раз.').css({color: 'red', fontWeight:'bolder'});
            }
            console.log(auth);

        });


    });
});