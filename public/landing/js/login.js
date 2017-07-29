var auth;
var authorized = false;
$(function () {
    VK.init({
        apiId: 4004433
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.button').click(function () {
        if (authorized == false) {
            VK.Auth.login(function (a) {
                if (a.session) {
                    auth = a.session;
                    $.post('api/login', {
                            auth: auth,
                        _token: crsf,
                        },
                        function (data) {
                            if (data != true) {
                                alert('Ошибка авторизации. Пожалуйста, свяжитесь с администрацией');
                            } else {
                                location.href = 'dance/';
                            }
                        }, "json");
                   // location.href = 'dance/';

                } else {
                    alert('К сожалению, вы не смогли авторизоваться. Попробуйте ещё раз!');
                }
                //console.log(auth);

            });
        } else {
            location.href = 'dance/';
        }



    });
    check_login();
});

function check_login() {
    $.getJSON('/api/check', function (json) {
        if (json.loginned) {
            authorized = true;
            $('.button').text('Продолжить');
        } else {
            authorized = false;
        }
    });
}