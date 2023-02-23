import {pictureFormEvent, checkInputs} from "../../functions.js";

let image = false;

$(function () {

    $('input[name="imageHREF"]').change(function (e) {
        image = e.target.files[0];
    });

    checkInputs('add_picture_form');

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