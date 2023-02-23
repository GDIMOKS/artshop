$(function () {
    $('.add-to-cart').on('click', function (e) {
        e.preventDefault();

        let id = $(this).data('id');
        let parent = $(this).closest('.product_area');


        $.ajax({
            url: '/assets/includes/cart_validator.php',
            type: 'GET',
            data: {cart: 'add', id: id},
            dataType: 'json',
            success: function (result) {
                if (result.code == 'ok') {
                    $('#cart-num').text(result.total_count);

                    $('#count-'+id).text(result.count);

                    if (parent != undefined) {
                        $('.count').text('Всего товаров: ' + result.total_count);
                        $('.sum').text('Общая сумма: ' + result.total_sum + ' рублей');

                        let cost = $(parent).find('.cart_cost_container');
                        $(cost).text('Цена: ' + result.picture.selling_price * result.count + ' рублей');
                    }
                } else {
                    alert(result.picture);
                }

            },
            error: function () {
                console.log('Error!');
            }
        });
    });

    $('.del-from-cart').on('click', function (e) {
        e.preventDefault();

        let id = $(this).data('id');
        let parent = $(this).closest('.product_area');

        $.ajax({
            url: '/assets/includes/cart_validator.php',
            type: 'GET',
            data: {cart: 'delete', id: id},
            dataType: 'json',
            success: function (result) {
                if (result.code == 'ok') {
                    $('#cart-num').text(result.total_count);
                    $('#count-'+id).text(result.count);


                    if (parent != undefined) {
                        $('.count').text('Всего товаров: ' + result.total_count);
                        $('.sum').text('Общая сумма: ' + result.total_sum + ' рублей');

                        let cost = $(parent).find('.cart_cost_container');
                        $(cost).text('Цена: ' + result.picture.selling_price * result.count + ' рублей');
                        if (result.count == 0) {
                            $(parent).remove();
                        }
                    }

                } else {
                    alert(result.picture);
                }

            },
            error: function () {
                console.log('Error!');
            }
        });
    });

    $('.checkout').on('click', function (e) {
        e.preventDefault();

        let parent = $(this).closest('.order');

        $.ajax({
            url: '/assets/includes/cart_validator.php',
            type: 'POST',
            data: {cart: 'checkout'},
            dataType: 'json',
            success: function (result) {
                if (result.code == 'ok') {
                    $(parent).remove();
                    $('#cart-num').text('0');
                    $('<div>Заказ №' + result.answer + ' добавлен на обработку!</div>').appendTo('.workspace')

                } else {
                    alert(result.answer);
                }

            },
            error: function () {
                console.log('Error!');
            }
        });
    });
});