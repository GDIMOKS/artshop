import {checkInputs, formEvent} from "../../functions.js";

function getData() {
    $.ajax({
        url: '/assets/includes/cabinet/client/edit_data.php',
        type: 'POST',
        data: {client_action: 'get_data'},
        dataType: 'json',
        success: function (result) {
            let form = $('form[name="edit_form"]');
            form.find('input[name="first_name"]').val(result.user.first_name);
            form.find('input[name="last_name"]').val(result.user.last_name ?? "");
            form.find('input[name="patronymic_name"]').val(result.user.patronymic_name ?? "");
            form.find('input[name="email"]').val(result.user.email);
            form.find('input[name="birthday"]').val(result.user.birthday ?? "");
            form.find('input[name="phone"]').val(result.user.phone ?? "");
        },
        error: function () {
            console.log('Error!');
        }
    });
}
function editData(form, formData) {
    let main_error_block = $(form).children('.error_block');
    let urlRequest = '/assets/includes/cabinet/client/edit_data.php';
    formEvent(form, formData, main_error_block, urlRequest, '')
}

$(function () {

    getData();

    checkInputs('edit_form');
    checkInputs('password_form');


    $('.edit_form').on('submit', function (e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);
        formData.append('client_action', 'edit_data');

    })

    $('.password_form').on('submit', function (e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);
        formData.append('client_action', 'edit_password');
        editData(form, formData);
        editData(form);
    })




});