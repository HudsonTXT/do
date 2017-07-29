var avs;
$(function () {
    VK.Api.call('users.get', {
        user_ids: tops,
        fields: 'photo_200'
    }, function (r) {
        avs = r;
        if(tops[0] == tops[1]){
            $('.rich .rich_first img').attr('src', r.response[0].photo_200);
            $('.rating__act .rich_first img').attr('src', r.response[0].photo_200);
        }else{
            $('.rich .rich_first img').attr('src', r.response[0].photo_200);
            $('.rating__act .rich_first img').attr('src', r.response[1].photo_200);
        }

    });
    VK.Api.call('users.get', {
        user_ids: tops_10['rich'],
        fields: 'photo_50'
    }, function (r) {
        $.each(r.response, function (index, value) {
            $('.rich .rating_name img').eq(index).attr('src', r.response[index].photo_50);
        });
    });
    VK.Api.call('users.get', {
        user_ids: tops_10['exp'],
        fields: 'photo_50'
    }, function (r) {
        $.each(r.response, function (index, value) {
            $('.rating__act .rating_name img').eq(index).attr('src', r.response[index].photo_50);
        });
    });
});

function getAvatar(id) {
    VK.Api.call('users.get', {
        user_ids: id,
        fields: 'photo_50'
    }, function (r) {
        av50 = r.response[0].photo_50;
        /*avs = r;
         $('.rich .rich_first img').attr('src', r.response[0].photo_200);
         $('.rating__act .rich_first img').attr('src', r.response[1].photo_200);*/
    });
    return av50;
}