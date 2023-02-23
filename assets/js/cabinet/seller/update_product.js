import {
    fillUpdateProductForm,
    pictureFormEvent,
    checkInputs
} from "../../functions.js";

let image = false;

$(function () {


    $('input[name="imageHREF"]').change(function (e) {
        image = e.target.files[0];
    });

    checkInputs('update_picture_form');

    $('.upd_select').on('change', function (e) {
        e.preventDefault();

        let picture_sel = this;
        if (picture_sel.options[picture_sel.selectedIndex].value == 'default') {
            let result = [];
            result['picture'] = [];
            result['picture']['categories'] = [];
            fillUpdateProductForm(result)
            return;
        }

        let picture_id = picture_sel.options[picture_sel.selectedIndex].dataset.id;

        $.ajax({
            url: '/assets/includes/cabinet/seller/update_picture.php',
            type: 'POST',
            data: {seller_action: 'choose', picture_id: picture_id},
            dataType: 'json',
            success: function (result) {
                if (result.code == 'OK') {
                    fillUpdateProductForm(result);
                }

            },
            error: function () {
                console.log('Error!');
            }
        });

    });

    $('.update_picture_form').on('submit', function (e) {
        e.preventDefault();

        let form = this;
        let main_error_block = $('[name=update_picture_form]').children('.error_block');
        main_error_block.text("");
        let urlRequest = '/assets/includes/cabinet/seller/update_picture.php';
        let formData = new FormData();
        formData.append('seller_action', 'update')

        pictureFormEvent(form, formData, image, main_error_block, urlRequest);
    })

})