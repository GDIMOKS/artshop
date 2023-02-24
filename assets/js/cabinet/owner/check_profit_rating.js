import {checkDate} from "../../functions.js";

$(function () {

    $('[class="button"]').on('click', function (e) {
        e.preventDefault();

        let form = $(this).closest('form');
        let begin = $(this).closest('form').find('[name="begin_date"]');
        let end = $(this).closest('form').find('[name="end_date"]');
        let name = $(this).attr('name');
        let main_error_block = $('form').children('.error_block');
        $(main_error_block).text('');

        checkDate(begin, end);

        let error_blocks = $(form).find('.error_block');
        let access = true;

        for (let i = 0; i < error_blocks.length; i++) {
            if ($(error_blocks[i]).text().length != 0) {
                access = false;
                break;
            }
        }

        if (access) {
            $.ajax({
                url: "/assets/includes/cabinet/owner/check_profit_rating.php",
                type: 'POST',
                data: {owner_action: name, begin_date: $(begin).val(), end_date: $(end).val()},
                dataType: 'json',
                success: function (result) {
                    if (result.code == 'ERROR') {
                        $(main_error_block).text(result.message);
                    } else {
                        if (name == 'profit'){
                            $(main_error_block).addClass('error_block_good');
                            $(main_error_block).css('fontSize', '24px');
                            $(main_error_block).text('Прибыль: ' + result.total_price + ' рублей');
                        } else {
                            let workspace = $('.profit_rating_area');
                            $('.profit_rating_order').remove();

                            if (result.pictures.length != 0) {
                                let order = $('<div class="profit_rating_order"></div>').appendTo(workspace);
                                $('<h1 >Рейтинг самых прибыльных товаров</h1>').appendTo(order);

                                for(let i = 0; i < result.pictures.length; i++) {
                                    let product = result.pictures[i];
                                    let product_area = $('<a class="product_area" href="#"></a>').appendTo(order);
                                    $('<div class="profit_name_container">' +
                                        '<div class="cart_image_container">' +
                                            '<img class="mini_image" src="/media/'+ product.imageHREF +'" alt="'+ product.name +'" class="mini_image">' +
                                        '</div>' +
                                        '<div class="product_info_container">' +
                                            '<div class="text title">'+ product.name +'</div>' +
                                        '</div>'+
                                      '</div>').appendTo(product_area);
                                    $('<div class="text profit_total_price">' +
                                        'Прибыль: '+ product.total_price + ' рублей</div>').appendTo(product_area);

                                    console.log(result.pictures[i])
                                }
                            }

                        }

                    }
                },
                error: function () {
                    console.log('Error!');
                }
            });
        }

    });

});