import {
    updateProduct,
    updateListOfProducts
} from "./cabinet/seller/update_product.js";

export let redirect = function(reference) {
    location.href = reference;
}

export let checkCaptcha = function (captcha, error) {
    error.text("");
    if (!captcha.length) {
        error.text('Вы не прошли проверку "Я не робот"');
    } else {

    }
}

export let checkFields = function (form) {
    let inputs = $(form).find('input')
        .not('[type=submit]')

    for (let i = 0; i < inputs.length; i++) {
        checkEmpty(inputs[i]);
    }
}

export function checkInputs(formName) {
    $('[name="'+formName+'"]').find('input')
        .not('[type=submit]')
        .on('input', function (e) {

            let input = this;
            $(input).siblings('.error_block').text("");

            checkEmpty(input);
            if (this.type != 'checkbox')
                checkValue(input);
        });
}

export let checkEmpty = function (input) {
    let error_block;

    if (input.name != 'categories[]') {
        error_block = $('[name='+input.name+']').siblings('.error_block');
    } else {
        error_block = $('.checkselect').children('.error_block');
    }


    switch (input.name) {
        case 'first_name':
            forEmpty(error_block, input,"Не указано имя");
            break;

        case 'email':
            forEmpty(error_block, input,"Не указана электронная почта");
            break;

        case 'old_password':
        case 'new_password':
        case 'password':
            forEmpty(error_block, input,"Не указан пароль");
            break;

        case 'password_2':
            forEmpty(error_block, input,"Не указано подтверждение пароля");
            break;

        case 'name':
            forEmpty(error_block, input,"Не указано название");
            break;

        case 'purchase_price':
        case 'selling_price':
            forEmpty(error_block, input,"Не указана цена");
            break;

        case 'categories[]':
            let checked = $('.checkselect').find("input[type='checkbox']:checked").length;

            if (checked == 0) {
                error_block.text("Выберите категорию(-и)");
            } else {
                error_block.text("");
            }
            changeColor($('select[name=categories]'), error_block);
            break;
    }
}

export function checkValue(input) {
    let error_block = $('[name='+input.name+']').siblings('.error_block');
    let textRegExp = /^[А-Яа-яЁё' .(),-]+$/g;

    if (error_block.text().length != 0)
        return;


    switch (input.name) {
        case 'phone':
            if (input.value.length != 0) {
                let phoneRegExp = /^[0-9]+$/g
                if (!phoneRegExp.exec(input.value)){
                    error_block.text('Только цифры от 0 до 9');
                }

                if (input.value.length > 11) {
                    error_block.text('Максимум 11 цифр');
                }

            }
            break;

        case 'patronymic_name':
        case 'last_name':
            if (input.value.length != 0) {
                if (input.value.length > 45) {
                    error_block.text('Максимум 45 символов');
                }
                if (!textRegExp.exec(input.value)){
                    error_block.text('Только кириллица, пробел и \' , \( \) \. -');
                }

            }
            break;
        case 'first_name':
            if (input.value.length > 45) {
                error_block.text('Максимум 45 символов');
            }
            if (!textRegExp.exec(input.value)){
                error_block.text('Только кириллица, пробел и \' , \( \) \. -');
            }
            break;

        case 'name':
            let regExp1 = /^[А-Яа-яЁёa-zA-Z0-9' .(),-]+$/g;
            if (!regExp1.exec(input.value)){
                error_block.text('Может содержать латиницу, кириллицу, арабские цифры, пробел и следующие символы: \' , \( \) \. -');
            }

            break;

        case 'file':
            break;

        case 'selling_price':
            if (+input.value < +$('input[name="purchase_price"]')[0].value) {
                error_block.text('Не может быть < закупочной');
            }
        case 'purchase_price':
            if (+input.value < 0){
                error_block.text('Не может быть меньше нуля');
            }
            break;

        case 'creation_date':
            let today = new Date();
            let year = today.getFullYear();

            if (+input.value < 0) {
                input.value = 0;
            }
            if (+input.value > year) {
                input.value = year;
            }
            break;

        case 'old_password':
        case 'new_password':
        case 'password':
            if (input.value.length < 8) {
                error_block.text('Пароль не должен быть короче 8 символов');
            } else {
                if (!/^[A-Za-z0-9!@#$%^&*]+$/g.exec(input.value)) {
                    error_block.text('Пароль должен содержать только латинские буквы, цифры и спецсимволы');
                    break;
                }
                if (!/(?=.*[0-9])/g.exec(input.value)) {
                    error_block.text('Пароль должен содержать минимум одну цифру');
                    break;
                }
                if (!/(?=.*[!@#$%^&*])/g.exec(input.value)) {
                    error_block.text('Пароль должен содержать один из следующих спецсимволов: !@#$%^&*');
                    break;
                }
                if (!/(?=.*[a-z])/g.exec(input.value)) {
                    error_block.text('Пароль должен содержать как минимум одну латинскую строчную букву');
                    break;
                }
                if (!/(?=.*[A-Z])/g.exec(input.value)) {
                    error_block.text('Пароль должен содержать как минимум одну латинскую прописную букву');
                    break;
                }
            }
            break;

        case 'password_2':
            let password = $('[name=password]')[0];

            if (password.value != input.value || inputIsEmpty(password) && inputIsEmpty(input)) {
                error_block.text('Повторный ввод пароля неверный');
            }
            break;
    }

    changeColor(input, error_block);

}

let forEmpty = function (error_block, input, message) {
    error_block.text("");
    if (inputIsEmpty(input))
        error_block.text(message);

    changeColor(input, error_block);
}

let inputIsEmpty = function (value) {
    return (value.value.length == 0) ? true : false;
}

export let changeColor = function (element, error_block) {
    if (error_block.text().length == 0) {
        $(element).css('border-color', '#e3e3e3');
        $(element).css('background-color', '#fcfcfc');
    } else {
        $(element).css('border-color', 'red');
        $(element).css('background-color', '#FF000009');
    }
}

export let formEvent = function (form, formData, main_error_block, urlRequest, urlRedirect) {
    if (urlRedirect == '')
        main_error_block.text("");
    checkFields(form);

    if (main_error_block.text().length != 0)
        return;

    let error_blocks = $(form).find('.error_block');
    let access = true;

    for (let i = 0; i < error_blocks.length; i++) {
        if (error_blocks[i].innerHTML != "") {
            access = false;
            break;
        }
    }
    if (access) {
        $.ajax({
            url: urlRequest,
            method: 'post',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: formData,
            success: function (result) {
                if (result.code == 'ERROR') {
                    if (urlRedirect != '')
                        grecaptcha.reset();
                    main_error_block.text(result.message);
                } else {
                    $(main_error_block).addClass('error_block_good');
                    main_error_block.text(result.message);

                    if (urlRedirect != '')
                        setTimeout(redirect, 1000, urlRedirect);
                    else if (result.type == 'edit_data')
                        $('.full_name').text(result.full_name);

                }
            }
        })
    }
}


export function setChecked(target) {

    let checked = $(target).find("input[type='checkbox']:checked").length;
    if (checked) {
        $(target).find('select option:first').html('Выбрано: ' + checked);
    } else {
        $(target).find('select option:first').html('Выберите из списка');
    }
}

export function fillUpdateProductForm(result) {
    let form = $('form[name="update_picture_form"]');
    form.find('input[name="name"]').val(result.picture.name ?? "");
    form.find('img').attr('src', result.picture.imageHREF ?? "");
    form.data('id', result.picture.picture_id ?? "");
    form.find('input[name="creation_date"]').val(result.picture.creation_date ?? "");
    form.find('input[name="selling_price"]').val(result.picture.selling_price ?? "");
    form.find('input[name="purchase_price"]').val(result.picture.purchase_price ?? "");

    let checkboxes = form.find("input[type='checkbox']");
    for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
        if (result.picture.categories.includes($(checkboxes[i]).data('id'))) {
            checkboxes[i].checked = true;
            $(checkboxes[i]).closest('label').css('background-color', '#cb6800').css('color', '#ffffff');
        }
    }
    setChecked($('.checkselect'));
}

export function pictureFormEvent(form, formData, image, main_error_block, urlRequest) {
    checkFields(form);

    let checkboxes = $('input[name="categories[]"]');
    let error_blocks = $(form).find('.error_block');
    let access = true;

    for (let i = 0; i < error_blocks.length; i++) {
        if (error_blocks[i].innerHTML != "") {
            access = false;
            break;
        }
    }

    if (access) {
        let categories = "";
        for (let i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                categories += checkboxes[i].dataset.parents + " ";
                categories += checkboxes[i].dataset.id + " ";
            }

        }
        let allCategories = categories.trim().split(' ');
        let categoriesSet = new Set(allCategories);
        let uniqueCategories = Array.from(categoriesSet);

        for (let i = 0; i < uniqueCategories.length; i++) {
            formData.append('categories[]', uniqueCategories[i]);
        }

        formData.append('picture_id', $(form).data('id'));
        formData.append('name', form.querySelector('input[name="name"]').value);
        formData.append('date', form.querySelector('input[name="creation_date"]').value);
        formData.append('selling_price', form.querySelector('input[name="selling_price"]').value);
        formData.append('purchase_price', form.querySelector('input[name="purchase_price"]').value);

        if (image == false) {
            let img = $(form).find('img').attr('src');
            img = img.split('/');
            if (img.at(-1) != "") {
                formData.append('image', img.at(-1));
                formData.append('isDownload', 0);
            } else {
                formData.append('image', 'no_image.jpg');
                formData.append('isDownload', 0)
            }
        } else {
            formData.append('image', image);
            formData.append('isDownload', 1);
        }

        $.ajax({
            url: urlRequest,
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function (result) {
                if (result.code == 'ERROR') {
                    main_error_block.text(result.message);
                } else {
                    $(main_error_block).addClass('error_block_good');
                    main_error_block.text(result.message);
                    $(form).find('img').attr('src', result.image);

                    main_error_block.text(result.message);

                    if (result.mode == 'update') {
                        setTimeout(function () {
                            $('.update_forms').load(location.href + " .update_forms",function (){
                                updateListOfProducts();
                                updateProduct();
                            });
                        }, 1000, );
                    }
                 }

            },
            error: function () {
                console.log('Error!');
            }
        });
    }
}

export function checkDate(begin, end) {

    if (begin.value != '' && end.value != '') {
        let begin_error_block = $(begin).siblings('.error_block');
        let end_error_block = $(end).siblings('.error_block')
        $(begin_error_block).text('');
        $(end_error_block).text('');

        if ($(begin).val() > $(end).val()) {
            $(begin_error_block).text('Начальная дата должна быть меньше конечной');
            $(end_error_block).text('Конечная дата должна быть больше начальной');
        }

        changeColor(begin, begin_error_block);
        changeColor(end, end_error_block);
    }

}