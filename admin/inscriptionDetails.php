<?php
session_start();
require_once 'classes/Admin.php';
require_once 'classes/Inscription.php';
if (isset($_SESSION['admin'])) {
    if (isset($_GET['inscription_numero'])) {
        $data = Inscription::getInscriptionDetails($_GET['inscription_numero']);
        $docs = Inscription::getDocsOfInscription($_GET['inscription_numero']);
        if (isset($_POST['eliminer'])) {
            Inscription::changerEtatOfInscription(-1, $_POST['inscription_numero']);
            header('location: inscriptionDetails.php?inscription_numero=' . $data['inscription_numero']);
        } elseif (isset($_POST['admettre'])) {
            Inscription::changerEtatOfInscription(1, $_POST['inscription_numero']);
            header('location: inscriptionDetails.php?inscription_numero=' . $data['inscription_numero']);
        }
    } else {
        header('location: index.php');
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
    <div id="profile-container">
        <img src="./../<?php echo $data['photo'] ?>" />
        <h1>Inscription details</h1>
        <div id="profile-container-details">
            <div class="profile-details">
                <div class="profile-item">Nom</div>
                <div><?php echo $data['nom'] ?></div></span>
            </div>
            <div class="profile-details">
                <div class="profile-item">Prenom</div>
                <div><?php echo $data['prenom'] ?></div>
            </div>
            <div class="profile-details">
                <div class="profile-item">Email</div>
                <div><?php echo $data['email'] ?></div>
            </div>
            <div class="profile-details">
                <div class="profile-item">CIN</div>
                <div><?php echo $data['cin'] ?></div>
            </div>
            <div class="profile-details">
                <div class="profile-item">CNE</div>
                <div><?php echo $data['cne'] ?></div>
            </div>
            <div class="profile-details">
                <div class="profile-item">Adresse</div>
                <div><?php echo $data['adresse'] ?></div>
            </div>
            <div class="profile-details">
                <div class="profile-item">Region</div>
                <div><?php echo Inscription::getRegion($data['id_region'])['region']; ?></div>
            </div>
            <div class="profile-details">
                <div class="profile-item">Ville</div>
                <div><?php echo Inscription::getVille($data['id_ville'])['ville']; ?></div>
            </div>
            <div class="profile-details">
                <div class="profile-item">Bac</div>
                <div><?php echo Inscription::getTypesBac($data['id_type_bac'])['type_bac']; ?></div>
            </div>
            <div class="profile-details">
                <div class="profile-item">Annee Obtion bac</div>
                <div><?php echo $data['annee_bac'] ?></div>
            </div>
            <div class="profile-details">
                <div class="profile-item">Note générale</div>
                <div><?php echo $data['note_generale'] ?></div>
            </div>
            <div class="profile-details">
                <div class="profile-item">Note Regional</div>
                <div><?php echo $data['note_regional'] ?></div>
            </div>
            <div class="profile-details">
                <div class="profile-item">Note National</div>
                <div><?php echo $data['note_national'] ?></div>
            </div>
            <div class="profile-details">
                <div class="profile-item">Mention</div>
                <div><?php echo Inscription::getMention($data['id_mention'])['mention']; ?></div>
            </div>
            <div class="profile-details">
                <div class="profile-item">Choix 1</div>
                <div><?php echo Inscription::getFiliere($data['id_choix1'])['filiere']; ?></div>
            </div>
            <div class="profile-details">
                <div class="profile-item">Choix 2</div>
                <div><?php echo Inscription::getFiliere($data['id_choix2'])['filiere']; ?></div>
            </div>
        </div>
        <div id="profile-container-docs">
            <?php foreach ($docs as $doc) { ?>
                <div class="profile-doc">
                    <h3><?php echo $doc['document']; ?></h3>
                    <embed src="./../<?php echo $doc['chemin']; ?>#toolbar=0&navpanes=0&scrollbar=0" width="425" height="425" />
                </div>
            <?php } ?>
        </div>
        <br />
        <div id="profile-container-footer">
            <h2>état actuel d'inscription <?php if ($data['etat'] == -1) echo " est éliminer";
                                            elseif ($data['etat'] == 1) echo "n'est pas éliminer" ?></h2>
            <form method="POST" action="">
                <input name="inscription_numero" value="<?php echo $data['inscription_numero']; ?>" hidden>
                <?php if ($data['etat'] == 1) { ?>
                    <button name="eliminer" type="submit">éliminer</button>
                <?php } elseif ($data['etat'] == -1) { ?>
                    <button name="admettre" type="submit">admettre</button>
                <?php } ?>
            </form>
        </div>
    </div>
    <br />
    <br />
    <script src="js/Url.js"></script>
    <script src="js/loader.js"></script>
</body>

</html>