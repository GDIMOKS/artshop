import {checkCaptcha, checkEmpty, formEvent} from "../functions.js";

$(function () {

    $('[name=auth_form]').find('input')
        .not('[type=submit]')
        .on('input', function (e) {
        let input = this;

        checkEmpty(input);
    });

    $('[name=auth_form]').on('submit', function (e) {
        e.preventDefault();

        let form = this;
        let main_error_block = $('[name=auth_form]').children('.error_block');
        let urlRequest = '/assets/includes/authentication/auth.php';
        let urlRedirect = '/';
        let formData = new FormData(form)

        checkCaptcha(grecaptcha.getResponse(), main_error_block);

        formEvent(form, formData, main_error_block, urlRequest, urlRedirect)

    });

});