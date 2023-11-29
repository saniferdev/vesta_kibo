<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Phppot\Member;
require_once __DIR__ . '/lib/Member.php';
require_once __DIR__ . '/lib/Api.php';

session_start();
session_destroy();

if (!empty($_REQUEST["login-btn"])) {    
    $member = new Member();
    $loginResult = $member->loginMember();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <TITLE>Login || KIBO</TITLE>
    <link rel="icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css" crossorigin="anonymous">
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <link href="vendor/fontawesome/css/all.css"	rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="assets/css/styles.min.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">

</head>
<body>
    <div id="authPage">
        <div id="submit-login-clicill" class="login-container">
            <div class="login-header">
                <div class="picto-login">
                    <span class="login"></span>
                    <span class="boutique hidden"></span>
                </div>
            </div>

            <div id="login-content">
                <form method="POST" name="login" action="" id="loginForm">     
                    <input type="hidden" name="login-btn" value="Login">       
                    <div class="form-group">
                        <div class="input-group input-login">
                            <span class="input-group-addon"><span class="picto-input identifiant"></span></span>
                            <input type="text" class="form-control input-lg" name="username" maxlength="70" required="required" placeholder="Login" autocomplete="nope">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-login">
                            <span class="input-group-addon"><span class="picto-input password"></span></span>
                            <input type="password" class="form-control input-lg" name="password" maxlength="80" pattern=".{2,80}" required="required" placeholder="Mot de passe" autocomplete="nope">                             
                        </div>
                    </div>
                    <?php if(!empty($loginResult)){?>
                    <div class="form-group">
                        <span class="text-danger text-left"><?php echo $loginResult;?></span>
                    <?php }?>
                    </div>
                    <button type="submit" class="btn btn-custom submit-login"><!--<span class="glyphicon glyphicon-ok">--></span> Valider</button>

                </form>

            </div>
        </div>
    </div>
</body>
</html>