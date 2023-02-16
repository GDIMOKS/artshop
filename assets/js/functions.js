// export let clearErrors = function (form_name) {
//     let form = document.querySelector('[name='+ form_name +']');
//     let error_blocks = form.querySelectorAll('.error_block');
//
//     for (let i = 0; i < error_blocks.length; i++)
//         error_blocks[i].innerHTML = "";
// }

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
    let inputs = $(form).find('input');

    for (let i = 0; i < inputs.length; i++) {
        checkEmpty(inputs[i]);
    }
}

export let checkEmpty = function (input) {
    let error_block = $('[name='+input.name+']').siblings('.error_block');

    switch (input.name) {
        case 'first_name':
            forEmpty(error_block, input,"Не указано имя");
            break;

        case 'email':
            forEmpty(error_block, input,"Не указана электронная почта");
            break;

        case 'password':
            forEmpty(error_block, input,"Не указан пароль");
            break;

        case 'password_2':
            forEmpty(error_block, input,"Не указано подтверждение пароля");
            break;
    }
}

export function checkValue(input) {
    let error_block = $('[name='+input.name+']').siblings('.error_block');

    if (error_block.text().length != 0)
        return;

    switch (input.name) {
        case 'first_name':
            let regExp = /^[А-Яа-яЁё' .(),-]+$/g;
            if (!regExp.exec(input.value)){
                error_block.text('Имя может содержать только кириллицу, пробел и следующие символы: \' , \( \) \. -');
            }

            break;

        // case 'email':
        //
        //     break;

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
        element.style.borderColor = '#e3e3e3';
        element.style.backgroundColor = '#fcfcfc';
    } else {
        element.style.borderColor = 'red';
        element.style.backgroundColor = '#FF000009';
    }
}

export let formEvent = function (form, main_error_block, urlRequest, urlRedirect) {
    checkFields(form);
    checkCaptcha(grecaptcha.getResponse(), main_error_block);

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
        let formData = new FormData(form);
        $.ajax({
            url: urlRequest,
            method: 'post',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: formData,
            success: function (result) {
                if (result.status == 'ERROR') {
                    grecaptcha.reset();
                    main_error_block.text(result.message);
                } else {
                    $(main_error_block).addClass('error_block_good');
                    main_error_block.text(result.message);

                    setTimeout(redirect, 1000, urlRedirect);
                }
            }
        })
    }
}





