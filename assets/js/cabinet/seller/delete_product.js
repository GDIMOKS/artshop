$(function () {
    $('.del-from-db').on('click', function (e) {
        e.preventDefault();

        let id = this.dataset.id;
        let parent = this.closest('.product');

        $.ajax({
            url: "/assets/includes/cabinet/seller/delete_picture.php",
            type: 'POST',
            data: {seller_action: 'delete', picture_id: id},
            dataType: 'json',
            success: function (result) {
                if (result.code == 'ERROR') {
                    console.log(result.message);
                } else {
                    $(parent).remove();
                }
            },
            error: function () {
                console.log('Error!');
            }
        });
    })
});