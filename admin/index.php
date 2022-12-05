<?php
session_start();
require_once 'classes/Admin.php';
require_once 'classes/inscription.php';
require_once 'classes/Filiere.php';
require_once 'classes/Promotion.php';
if (isset($_SESSION['admin'])) {
    $promotion = Promotion::getInfoPromotion();
    $date_Limite = $promotion['date_fin'];
    $promotion = $promotion['promotion'];
    if (isset($_GET['filiere']) && $_GET['filiere'] != "all") {
        $inscriptions = Inscription::getAllInscriptionByFiliere($_GET['filiere']);
    } else {
        $inscriptions = Inscription::getAllInscription();
    }
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
    <title>Accueil</title>
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
    <div id="home">
        <div id="home-text-container">
            ouverture <br />des inscriptions pour DUT première année
            <br />
            pour l'année universitaire <?php echo $promotion; ?>
            <p id="countdown"></p>
        </div>
        <div id="home-img-container">
            <img src="./../images/parametre/registre.png" />
        </div>
    </div>
    <span id="table"></span>
    <main id="main-home">
        <h1>inscription en ligne DUT <?php echo $promotion; ?></h1>
        <div id="recherche-container">
            <span>Recherche</span>
            <input type="text" name="recherche" id="recherche" placeholder="Recherche par Nom ou Prenom">
        </div>
        <div id="filtre">
            <div><?php echo count($inscriptions) ?> Inscriptions</div>
            <a href="index.php?filiere=all#table"><button>Toutes les filières</button></a>

            <?php foreach (Filiere::getAllFiliere() as $item) { ?>
                <a href="index.php?filiere=<?php echo $item['id']; ?>#table"><button><?php echo $item['filiere']; ?></button></a>
            <?php } ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>cne</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>cin</th>
                    <th>inscription_date</th>
                    <th>Choix 1</th>
                    <th>Choix 2</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inscriptions as $item) { ?>
                    <tr class="table-item">
                        <td class="inscription-item-img"><a href="inscriptionDetails.php?inscription_numero=<?php echo $item['inscription_numero']; ?>"><img src="<?php echo "./../" . $item['photo']; ?>" /></a></td>
                        <td><?php echo $item['cne']; ?></td>
                        <td class="nom"><?php echo $item['nom']; ?></td>
                        <td class="prenom"><?php echo $item['prenom']; ?></td>
                        <td><?php echo $item['cin']; ?></td>
                        <td><?php echo $item['inscription_date']; ?></td>
                        <td><?php echo Filiere::getNomFiliere($item['id_choix1']) ?></td>
                        <td><?php echo Filiere::getNomFiliere($item['id_choix2']) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
    <br />
    <br />
    <br />
    <script src="js/Url.js"></script>
    <script src="js/loader.js"></script>
    <script src="js/main.js"></script>
    <script src="lib/scrollreal.js"></script>
    <script src="lib/main.js"></script>
</body>

</html>