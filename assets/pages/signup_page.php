<?php
require_once "../includes/classes/form.php";
require_once "../includes/classes/user.php";

session_start();
require_once "../includes/config.php";
require_once "../includes/authentication/cookie/cookie.php";

if (!empty($_SESSION['auth']))
{
    header('Location: /assets/pages/cabinet_page.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Регистрация</title>

        <link rel="stylesheet" href="/assets/styles/header.css">
        <link rel="stylesheet" href="/assets/styles/main.css">

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script type="text/javascript" src="/assets/js/jquery-3.6.1.min.js"></script>

    </head>
    <body>

    <?php
    require_once "../includes/header.php";
    ?>

    <div class="workspace">
        <form class="auth_reg" name="reg_form">
            <?php
            $form = new Form("reg_form");

            $form->setInput('Имя', 'text', 'first_name', 'Введите своё имя');
            $form->setInput('Электронная почта', 'email', 'email', 'Введите свой email', 'autofocus');
            $form->setInput('Пароль', 'password', 'password', 'Введите пароль');
            $form->setInput('Подтверждение пароля', 'password', 'password_2', 'Повторно введите пароль');

            $form->print();
            ?>


            <div class="g-recaptcha" data-sitekey="<?php echo $config['SITE_KEY'] ?>" style="margin: 0px auto 20px; ";></div>

            <button class="button" type="submit">Зарегистрироваться</button>

            <p class="p_reg">
                У вас уже есть аккаунт? - <a href="signin_page.php" class="a_reg">авторизуйтесь</a>!
            </p>

            <div class="error_block"></div>
        </form>




    </div>

    <script type="module" src="../js/authentication/register.js"></script>

    </body>
</html>