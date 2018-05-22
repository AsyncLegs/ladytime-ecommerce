$(document).ready( () => {
    $('.item_add').on('click', (e) => {
        let productId = $(e.currentTarget).data('product');
        e.preventDefault();
        $.ajax('/api/v1/cart/'+productId, {
            method: 'POST'
        });
    });
});
