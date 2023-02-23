$(function () {
    function change_status() {
        $('.change_status').on('click', function (e) {
            e.preventDefault();

            if (e.target.type == 'select-one')
                return;

            let status_id = $(this).find('select').val();
            let order = $(this).closest('.order');
            let order_id = $(order).data('id');

            $.ajax({
                url: '/assets/includes/cabinet/seller/change_order_status.php',
                type: 'POST',
                data: {seller_action: 'change_status', status_id: status_id, order_id: order_id},
                dataType: 'json',
                success: function (result) {
                    if (result.code == 'OK') {
                        $('.orders').load(location.href + " .orders",function (){
                            change_status();
                        });
                    }

                },
                error: function () {
                    console.log('Error!');
                }
            });

        });
    }

    change_status();


});