<?php
session_start();
require_once 'classes/Admin.php';
if (isset($_POST["submit"])) {
    $Admin = new Admin($_POST["email"], $_POST["pass"]);
    $Admin->authenticate();
} elseif (isset($_POST['deconnexion'])) {
    $Admin = new Admin('', '');
    $Admin->deconnexion();
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
    <link rel="stylesheet" href="./../css/style.css">
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
    <div id="index">
        <div id="bg-index">
            <img src="./../images/parametre/ESTS_logo.png" alt="ESTS logo" class="logo-index" />
        </div>
        <div id="bg-index-form">
            <img src="./../images/parametre/logo_universite.png" alt="ESTS logo" class="logo-index-side2" />
            <form id="formlogin" action="connexion.php" method="POST" autocomplete="off">
                <i class="icon fas fa-lock"></i>
                <h2>S'identifier</h2>
                <br>
                <div class="input-container">
                    <label for="email"><i class='bx bxs-user'></i> email</label>
                    <input name="email" type="text" id="email" placeholder="Entrer votre Email" value="">
                </div>
                <div class="input-container">
                    <label for="pass"><i class='bx bxs-lock'></i> password</label>
                    <input type="password" name="pass" id="pass" placeholder="Entrer votre mot de passe" autocomplete="off">
                </div>
                <?php if (isset($_GET["error"])) { ?>
                    <p class="erreur">Les informations sont incorrectes !</p>
                <?php } ?>
                <input class="btn" id="connexion" type="submit" name="submit" value="Se Connecter">
            </form>
        </div>
    </div>
    <script src="js/loader.js"></script>
</body>

</html>