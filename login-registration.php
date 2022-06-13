<?php
require ('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="GeniusOcean">
    <title>Gamify</title>
    <link href="assets/css/login-registration-css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/login-registration-css/style.css" rel="stylesheet">
    <link href="assets/css/login-registration-css/custom.css" rel="stylesheet">
    <link href="assets/css/login-registration-css/responsive.css" rel="stylesheet">
    <script src="assets/js/login.js" defer></script>
    <script src="assets/js/lib/jquery.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php require('includes/head.php');?>
    <style>
        body {
            text-align: center;
            background-color: var(--color__body-background);
        }
    </style>
</head>
<body>
<div id="loader">

</div>
<?php
if (isset($_SESSION['id'])) {
    header("Location: " . URL . "/index.php");
}
?>

<section class="login-signup">
    <div class="container p-5" style="display: none" id="error-div">
        <div class="row no-gutters">
            <div class="col-lg-6 col-md-12" id="error-message-div" style="display: none; margin: auto;">
                <div class="alert-danger shadow my-3" role="alert" style="border-radius: 0">
                    <div class="row">
                        <div class="col-2">
                            <div class="text-center" style="background:#721C24">
                                <svg width="3em" height="3em" style="color:#F8D7DA" viewBox="0 0 16 16"
                                     class="m-1 bi bi-exclamation-circle-fill" fill="currentColor"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="alert col-10 my-auto">
                            <div class="row">
                                <p style="font-size:18px" class="mb-0 font-weight-light" id="error"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="login-area">
                    <div class="header-area">
                        <a href="index.php"><img src="assets/images/mainLogo.png" alt="logo"></a>
                    </div>
                    <div class="login-form" id="login">
                        <form name="monForm" id="monForm" method="post">
                            <div class="form-input">
                                <input type="text" name="login" id="username" placeholder="Username" required=""
                                       autofocus="" autocomplete="">
                                <i class="icofont-user-alt-5"></i>
                            </div>
                            <div class="form-input">
                                <input type="password" name="pass" id="password" placeholder="Password">
                                <i class="icofont-ui-password"></i>
                            </div>
                            <div class="register_switch">
                                <span id="forgor">No Account? Register now!</span>
                            </div>
                            <div class="form-forgot-pass">
                                <span id="forgor">Forgot your password?</span>
                            </div>
                            <div class="captchaL">
                                <div class="g-recaptcha" data-sitekey="6Lcb2w0gAAAAAHuidaQ1moOAE1l5OAHobm1SDnYS" data-theme="dark"></div>
                            </div>
                            <input type="button" class="submit-btn login" name="envoyer" value="Login">
                        </form>
                    </div>
                    <div class="login-form" id="register" style="display: none">
                        <form name="monForm" id="monForm" method="post">
                            <div class="form-input">
                                <input type="email" name="login" id="email" placeholder="Email" required=""
                                       autofocus="" autocomplete="">
                                <i class="icofont-user-alt-5"></i>
                            </div>
                            <div class="form-input">
                                <input type="text" name="username" id="usernameR" placeholder="Username" required="">
                            </div>
                            <div class="form-input">
                                <input type="password" name="pass" id="passwordR" placeholder="Password">
                                <i class="icofont-ui-password"></i>
                            </div>
                            <div class="form-input">
                                <input type="password" name="pass" id="confirmpassword" placeholder="Confirm Password">
                                <i class="icofont-ui-password"></i>
                            </div>
                            <div class="login_switch">
                                <span id="forgor">Already have an account? Sign in now!</span>
                            </div>
                            <div class="captchaR">

                            </div>
                            <input type="button" class="submit-btn register" name="envoyer" value="Register">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function onSubmit(token) {
        document.getElementById("demo-form").submit();
    }
    // function wpf_dev_change_captcha_theme( ) {
    //
    //     jQuery(function ($) {
    //
    //         $('.g-recaptcha').attr('data-theme', 'dark');
    //
    //     });
    // }
</script>
</body>
</html>