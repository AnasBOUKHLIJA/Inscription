<?php
session_start();
require_once 'classes/Admin.php';
require_once 'classes/inscription.php';
require_once 'classes/Filiere.php';
if (isset($_SESSION['admin'])) {
} else {
    header('location: connexion.php');
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
    <title>Statistique</title>
</head>

<body id="body">
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
    <?php require 'includes/header.php' ?>
    <div id="filieres-container">
        <?php foreach (Filiere::getAllFiliere() as $filiere) { ?>
            <div class="filiere-container">
                <div class="filiere-container-option">
                    <span>Filiere</span>
                    <h1><?php echo $filiere['filiere'] ?></h1>
                </div>
                <div class="filiere-container-core">
                    <div class="loader">
                        <div></div>
                    </div>
                    <div class="content">
                        <div class="title">Nom d'inscription</div>
                        <div class="value"><?php echo Filiere::getCountOfInscription($filiere['id']) ?></div>
                        <div class="title">Nom d'inscription pour premiere choix</div>
                        <div class="value"><?php echo Filiere::getCountOfInscriptionChoix1($filiere['id']) ?></div>
                        <div class="title">Nom d'inscription pour deuxieme choix</div>
                        <div class="value"><?php echo Filiere::getCountOfInscriptionChoix2($filiere['id']) ?></div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <script src="js/Url.js"></script>
    <script src="js/loader.js"></script>
</body>

</html>