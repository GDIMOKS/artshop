import {checkEmpty, formEvent, checkValue} from "./functions.js";

$(function () {

    $('[name=reg_form]').find('input').on('input', function (e) {
        let input = this;

        checkEmpty(input);
        checkValue(input);
    });

    $('[name=reg_form]').on('submit', function (e) {
        e.preventDefault();

        let form = this;
        let main_error_block = $('[name=reg_form]').children('.error_block');
        let urlRequest = '/assets/includes/register.php';
        let urlRedirect = '/';

        formEvent(form, main_error_block, urlRequest, urlRedirect)
    });

});