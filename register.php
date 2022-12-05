<?php
session_start();
require_once 'classes/User.php';
if (isset($_POST["submit"])) {
    $user = new User($_POST["user"], $_POST["pass"]);
    $user->enregistrer();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- box icons link -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <title>Registre</title>
</head>

<body>
    <div id="loader">
        <div class="lds-roller">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div id="index">
        <div id="bg-index">
            <img src="images/parametre/registre.png" alt="registre logo" />
            <img src="images/parametre/nouveau_photo.gif" alt="ESTS logo" class="logo-index" />
            <div class="bg-index-footer">
                <span><img src="icons/icon-envelope.png" class="icon-png"/> contact.ests@uca.ma </span>
                <span><img src="icons/icon-phone.png" class="icon-png"/> (+212) 5 24 62 50 53</span>
            </div>
        </div>
        <div id="bg-index-form">
            <form id="formlogin" action="" method="POST" autocomplete="off">
                <img src="icons/icon-unlock.png" class="icon-png-log"/>
                <h2>Creation de compte</h2>
                <br>
                <div class="input-container">
                    <label for="user"><img src="icons/icon-user.png" class="icon-png-form"/> username</label>
                    <input name="user" type="text" id="user" placeholder="Entrer votre nom d'utilisateur" autocomplete="off">
                </div>
                <div class="input-container">
                    <label for="pass"><img src="icons/icon-lock.png" class="icon-png-form"/> password</label>
                    <input type="password" name="pass" id="pass" placeholder="Entrer votre mot de passe" autocomplete="off">
                </div>
                <?php if (isset($_GET["error"])) { ?>
                    <p class="erreur">Les informations sont invalide</p>
                <?php } ?>
                <input class="btn" id="connexion" type="submit" name="submit" value="Enregistrer">
                <a class="btn-href-register" href="connexion.php">S'identifier</a>
            </form>

        </div>
    </div>
    <script src="js/loader.js"></script>
</body>

</html>