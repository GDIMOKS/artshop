$(function () {

    function setChecked(target) {

        let checked = $(target).find("input[type='checkbox']:checked").length;
        if (checked) {
            $(target).find('select option:first').html('Выбрано: ' + checked);
        } else {
            $(target).find('select option:first').html('Выберите из списка');
        }
    }



    $.fn.checkselect = function() {

        this.each(function(){
            setChecked(this);
        });

        this.find('input[type="checkbox"]').click(function(){
            setChecked($(this).parents('.checkselect'));
        });



        this.parent().find('.checkselect-control').on('click', function(){

            $popup = $(this).next();

            $('.checkselect-popup').not($popup).css('display', 'none');

            if ($popup.is(':hidden')) {

                $popup.css('display', 'block');

                $(this).find('select').focus();

            } else {
                $popup.css('display', 'none');
            }

        });

            $('html, body').on('click', function(e){
            if ($(e.target).closest('.checkselect').length == 0){
                $('.checkselect-popup').css('display', 'none');
            }
        });

    };




$('.checkselect').checkselect();

$('.checkselect').find('input[type=checkbox]').closest('label').on('mouseenter', function (){
    if (!$(this).find('input[type=checkbox]').is(':checked')) {
        $(this).closest('label').css('background-color', '#cb6800');
        $(this).closest('label').css('color', '#ffffff');
    }
})

$('.checkselect').find('input[type=checkbox]').closest('label').on('mouseleave', function (){
    if (!$(this).find('input[type=checkbox]').is(':checked')) {
        $(this).closest('label').css('color', '#000000');
        $(this).closest('label').css('background-color', '#ffffff');
    }
})

$('.checkselect').find('input[type=checkbox]').on('click', function (){
    if ($(this).is(':checked')) {
        $(this).closest('label').css('background-color', '#cb6800');
        $(this).closest('label').css('color', '#ffffff');
    } else {
        $(this).closest('label').css('color', '#000000');
        $(this).closest('label').css('background-color', '#ffffff');
    }
})

});