import {checkEmpty, checkFields, checkValue, formEvent} from "../../functions.js";

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
        let urlRedirect = '/';

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
        // formEvent(form, main_error_block, urlRequest, urlRedirect)
        if (access) {
            let formData = new FormData();
            let categories = "";
            for (let i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    categories += checkboxes[i].dataset.parents;
                    categories += " " + checkboxes[i].dataset.id;
                    if (i + 1 != checkboxes.length)
                        categories += " ";
                }
            }
            let allCategories = categories.split(' ');
            let categoriesSet = new Set(allCategories);
            let uniqueCategories = Array.from(categoriesSet);

            for (let i = 0; i < uniqueCategories.length; i++) {
                formData.append('categories[]', uniqueCategories[i]);
            }


            let author_sel = form.querySelector('[name="authors"]');
            formData.append('name', form.querySelector('input[name="name"]').value);
            formData.append('count', form.querySelector('input[name="count"]').value);
            formData.append('date', form.querySelector('input[name="creation_date"]').value);
            formData.append('author_id', author_sel.options[author_sel.selectedIndex].dataset.id);
            formData.append('selling_price', form.querySelector('input[name="selling_price"]').value);
            formData.append('purchase_price', form.querySelector('input[name="purchase_price"]').value);


            if (image == false) {
                // image = form.querySelector('img').src;
                // if (image != "") {
                //     formData.append('image', image);
                // }
            } else {
                formData.append('image', image);
            }

            // if (action == 'update') {
            //     formData.append('id', $(this).data('id'));
            // }
            //
            //
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
                        $(form).find('img')[0].src = result.image;
                        // setTimeout(redirect, 1000, '../pages/profile.php');
                    }

                },
                error: function () {
                    console.log('Error!');
                }
            });
        }


    });

});