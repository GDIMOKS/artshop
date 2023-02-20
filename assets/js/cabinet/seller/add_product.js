import {checkEmpty, checkFields, checkValue, formEvent, pictureFormEvent} from "../../functions.js";

let image = false;

$(function () {

    $('input[name="imageHREF"]').change(function (e) {
        image = e.target.files[0];
    });

    $('[name=add_picture_form]').find('input')
        .not('[type=submit]')
        .on('input', function (e) {

        let input = this;

        checkEmpty(input);
        if (this.type != 'checkbox')
            checkValue(input);
    });

    $('[name=add_picture_form]').on('submit', function (e) {
        e.preventDefault();

        let form = this;
        let main_error_block = $('[name=add_picture_form]').children('.error_block');
        main_error_block.text("");
        let urlRequest = '/assets/includes/cabinet/seller/add_picture.php';
        let formData = new FormData();

        pictureFormEvent(form, formData, image, main_error_block, urlRequest);


    });

});