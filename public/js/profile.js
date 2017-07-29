$(function(){
    $('.info_lvl').circleProgress({
        size: 120,
        lineCap: 'round',
        startAngle: 0.5 * -Math.PI,
        fill: {
            gradient: ["#b721ff", "#21d4fd"]
        }
    });
    $('.info_money').circleProgress({
        size: 120,
        lineCap: 'round',
        startAngle: 0.5 * -Math.PI,
        fill: {
            gradient: ["#f6d365", "#fda085"]
        }
    });
    $('.info_dance').circleProgress({
        size: 120,
        lineCap: 'round',
        startAngle: 0.5 * -Math.PI,
        fill: {
            gradient: ["#00dbde", "#fc00ff"]
        }
    });
    VK.Api.call('users.get', {
        user_ids: profileMid,
        fields: 'photo_200'
    }, function (r) {
        user = r.response[0];
        $('.profile_image img').attr('src', user.photo_200);
    });

    $('.profile_medals .block_content').on('mousewheel DOMMouseScroll', function() {
        console.log('mousing');
    });
    var allMedal = $('.medal').size();
    var curPos = 3;
    $('.carousel_right').click(function(){
        if(curPos >= allMedal){
            $('.medals_carousel').animate({left: '25px'}, 300);
            curPos = 3;
        }else{
            $('.medals_carousel').animate({left: '-=150px'}, 300);
            curPos++;
        }

    });
    $('.carousel_left').click(function(){
        if(curPos <= 3){
            $('.medals_carousel').animate({left: '25px'}, 300);
            curPos = 3;
        }else{
            $('.medals_carousel').animate({left: '+=150px'}, 300);
            curPos--;
        }
    });
});
