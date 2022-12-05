<?php
session_start();
require_once 'classes/User.php';
if (isset($_POST["submit"])) {
    $user = new User($_POST["user"], "");
    $user->reinitialiser($_POST);
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
    <title>Réinitialiser</title>
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
                <h2>Réinitialiser votre mot de passe</h2>
                <br>
                <div class="input-container">
                    <label for="user"><img src="icons/icon-user.png" class="icon-png-form"/> username</label>
                    <input name="user" type="text" id="user" placeholder="Entrer votre nom d'utilisateur" autocomplete="off">
                </div>
                <div class="input-container">
                    <label for="cne"><img src="icons/icon-identity.png" class="icon-png-form"/> CNE</label>
                    <input name="cne" type="text" id="cne" placeholder="Entrer votre CNE" autocomplete="off">
                </div>
                <div class="input-container">
                    <label for="date"><img src="icons/icon-calendar.png" class="icon-png-form"/> Date de naissance</label>
                    <input name="date" type="date" id="date" placeholder="Entrer votre Date de naissance" autocomplete="off">
                </div>
                <?php if (isset($_GET["success"])) { ?>
                    <p class="erreur">Votre mot de passe est réinitialisé avec success le nouveau mot de passe est <?php echo $_GET["success"]; ?></p>
                <?php } elseif (isset($_GET["error"])) { ?>
                    <p class="erreur">Les informations sont invalide</p>
                <?php } ?>
                <input class="btn" id="connexion" type="submit" name="submit" value="Réinitialiser">
                <a class="btn-href-register" href="connexion.php">S'identifier</a>
            </form>

        </div>
    </div>
    <script src="js/loader.js"></script>
</body>

</html>