<?php
session_start();
require_once 'classes/User.php';
require_once 'classes/Promotion.php';
$promotion = Promotion::getInfoPromotion();

if ($promotion['date_fin'] < date("Y-m-d H:i:s")) {
} else {
}
if (isset($_POST["submit"])) {
    $user = new User($_POST["user"], $_POST["pass"]);
    $user->authenticate();
} elseif (isset($_POST['deconnexion'])) {
    $user = new User('', '');
    $user->deconnexion();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- box icons link -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
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
    <?php if ($promotion['date_fin'] > date("Y-m-d H:i:s")) { ?>
        <div id="index">
            <div id="bg-index">
                <img src="images/parametre/registre.png" alt="registre logo" />
                <h1 id="date_fin" style="display: none"><?php echo $promotion['date_fin']; ?></h1>
                <img src="images/parametre/nouveau_photo.gif" alt="ESTS logo" class="logo-index" />
                <div id="countdown"></div>
                <!-- <img src="images/parametre/logo_universite.png" alt="logo universite" class="logo-index2" /> -->
                <div class="bg-index-footer">
                <span><img src="icons/icon-envelope.png" class="icon-png"/> contact.ests@uca.ma </span>
                <span><img src="icons/icon-phone.png" class="icon-png"/> (+212) 5 24 62 50 53</span>
            </div>
            </div>
            <div id="bg-index-form">
                <form id="formlogin" action="connexion.php" method="POST" autocomplete="off">
                    <img src="icons/icon-unlock.png" class="icon-png-log"/>
                    <h2>S'identifier</h2>
                    <br>
                    <div class="input-container">
                        <label for="user"><img src="icons/icon-user.png" class="icon-png-form"/> username</label>
                        <input name="user" type="text" id="user" placeholder="Entrer votre nom d'utilisateur" value="">
                    </div>
                    <div class="input-container">
                        <label for="pass"><img src="icons/icon-lock.png" class="icon-png-form"/> password</label>
                        <input type="password" name="pass" id="pass" placeholder="Entrer votre mot de passe" autocomplete="off">
                    </div>
                    <?php if (isset($_GET["error"])) { ?>
                        <p class="erreur">Les informations sont incorrectes !</p>
                    <?php } ?>
                    <input class="btn" id="connexion" type="submit" name="submit" value="Se Connecter">
                    <a class="btn-href-register" href="register.php">Crée un nouveau compte</a>
                    <a class="btn-href-mot-passe" href="reinitialiser.php">Vous avez oublié votre mot de passe ?</a>
                </form>
            </div>
        </div>
    <?php } else { ?>
        <div id="end">
            <h1>La fin de la phase d'inscription dans les différentes filières de notre établissement</h1>
        </div>
    <?php } ?>
    <script src="js/countDown.js"></script>
    <script src="js/loader.js"></script>
</body>
</html>