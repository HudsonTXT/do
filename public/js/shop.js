$(function(){
    $('.item').click(function(){
        itemName = $(this).find('.item_name').text();
        if (confirm('Купить ' + itemName + '?')) {
            itemId = $(this).attr('data-item-id');
            $.getJSON('/shop/buy/'+itemId, function (json) {
                alert(json);
            });
        } else {
            // Do nothing!
        }
    });
});