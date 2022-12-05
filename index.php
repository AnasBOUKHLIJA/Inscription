<?php
session_start();
require_once 'classes/User.php';
require_once 'classes/Inscription.php';
if (isset($_SESSION['user'])) {
    $Inscription1 = new Inscription();
    $isSubscribe = $Inscription1->isSubscribe($_SESSION['user']['id']);
    $InscriptionData =  NULL;
    if ($isSubscribe !== 0) {
        $InscriptionData = $Inscription1->getInsciption($_SESSION['user']['id']);
    }
    if (isset($_POST['submit'])) {
        $Inscription2 = new Inscription();
        $Inscription2->add($_SESSION['user']['id'], $_POST);
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
    <header>
        <div><img src="images/parametre/ESTS_logo.png" alt="ESTS logo" class="logo-accueil" />
            <h4>ecole supérieure de technologie safi</h4>
        </div>
        <form method="POST" action="connexion.php">
            <button type="submit" name="deconnexion">Se deconnecter <img src="icons/icon-logout.png" class="icon-png"/></ </button>
        </form>
    </header>
    <main>
        <section id="side1">
            <?php if ($InscriptionData && !empty($InscriptionData['photo'])) { ?>
                <img src="<?php echo $InscriptionData['photo']; ?>" id="pic" class="user-logo">
            <?php } else { ?>
                <img src="images/parametre/user.png" id="pic" class="user-logo">
            <?php } ?>
            <br />
            <div class="input-img">
                <input type=file>
                <span><img src="icons/icon-edit.png" class="icon-png"/> Changer votre photo</span>
            </div>
            <br />
            <h5><?php echo $_SESSION['user']['username'] ?></h5>
            <br />
            <br />
            <?php if($Inscription1->isSubscribe($_SESSION['user']['id'])  !== 0){ ?>
                <a href="classes/PrintPdf.php" class="btn-download" download=""><img src="icons/icon-download.png" class="icon-png"/> Télécharger la fiche d'inscription</a>
            <?php } ?>
            
        </section>
        <section id="side2">
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="side2-title" style="margin-top: 0;">informations personnelles</div>
                <input type="file" id="pic2" name="img" hidden>
                <div class="input-container">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" id="nom" placeholder="Entrer votre nom" value="<?php if ($InscriptionData && !empty($InscriptionData['nom'])) echo $InscriptionData['nom']; ?>" required>
                </div>
                <div class="input-container">
                    <label for="prenom">Prenom</label>
                    <input type="text" name="prenom" id="prenom" placeholder="Entrer votre prénom" value="<?php if ($InscriptionData && !empty($InscriptionData['prenom'])) echo $InscriptionData['prenom']; ?>" required>
                </div>
                <div class="input-container">
                    <label for="dateNaissance">Date de naissance</label>
                    <input type="date" name="dateNaissance" id="dateNaissance" placeholder="Entrer votre date de naissance" value="<?php if ($InscriptionData && !empty($InscriptionData['dateNaissance'])) echo $InscriptionData['dateNaissance']; ?>" required>
                </div>
                <div class="input-container">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" placeholder="Entrer votre email" value="<?php if ($InscriptionData && !empty($InscriptionData['email'])) echo $InscriptionData['email']; ?>" required>
                </div>
                <div class="input-container">
                    <label for="cin">CIN</label>
                    <input type="text" name="cin" id="cin" placeholder="Entrer votre CIN" value="<?php if ($InscriptionData && !empty($InscriptionData['cin'])) echo $InscriptionData['cin']; ?>" required>
                </div>
                <div class="input-container">
                    <label for="cne">CNE</label>
                    <input type="text" name="cne" id="cne" placeholder="Entrer votre CNE" value="<?php if ($InscriptionData && !empty($InscriptionData['cne'])) echo $InscriptionData['cne']; ?>" required>
                </div>
                <div class="input-container">
                    <label for="adresse">Adresse</label>
                    <input type="text" name="adresse" id="adresse" placeholder="Entrer votre adresse" value="<?php if ($InscriptionData && !empty($InscriptionData['adresse'])) echo $InscriptionData['adresse']; ?>" required>
                </div>
                <div class="input-container">
                    <label for="tele">Téléphone</label>
                    <input type="text" name="tele" id="tele" placeholder="Entrer votre numéro téléphone" value="<?php if ($InscriptionData && !empty($InscriptionData['tele'])) echo $InscriptionData['tele']; ?>" required>
                </div>
                <br />
                <div class="side2-title">informations accadimique</div>
                <div class="input-container">
                    <label for="region">Region</label>
                    <select name="region" id="region" required>
                        <option disabled selected>Choisissez votre bac</option>
                        <?php foreach ($Inscription1->getRegions() as $item) { ?>
                            <option value="<?php echo $item['id'] ?>" <?php if ($InscriptionData && $InscriptionData['id_region'] == $item['id']) {
                                                                            echo "selected";
                                                                        } ?>><?php echo $item['region'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-container">
                    <label for="ville">Ville</label>
                    <select name="ville" id="ville" required>
                        <option disabled selected>Choisissez votre bac</option>
                        <?php foreach ($Inscription1->getVilles() as $item) { ?>
                            <option value="<?php echo $item['id'] ?>" <?php if ($InscriptionData && $InscriptionData['id_ville'] == $item['id']) {
                                                                            echo "selected";
                                                                        } ?>><?php echo $item['ville'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-container">
                    <label for="typeBac">Type de Baccalauréat</label>
                    <select name="typeBac" id="typeBac" required>
                        <option disabled selected>Choisissez type de votre bac</option>
                        <?php foreach ($Inscription1->getTypesBac() as $item) { ?>
                            <option value="<?php echo $item['id'] ?>" <?php if ($InscriptionData && $InscriptionData['id_type_bac'] == $item['id']) {
                                                                            echo "selected";
                                                                        } ?>><?php echo $item['type_bac'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-container">
                    <label for="bacAnnee">Annee d'obtion Baccalauréat</label>
                    <input type="number" min="1000" max="3000" step="1" name="bacAnnee" id="bacAnnee" placeholder="Entrer année d'obtion baccalauréat" value="<?php if ($InscriptionData && !empty($InscriptionData['annee_bac'])) echo $InscriptionData['annee_bac']; ?>" required>
                </div>
                <div class="input-container">
                    <label for="mention">Mentions du Baccalauréat</label>
                    <select name="mention" id="mention" required>
                        <option disabled selected>Choisissez votre bac</option>
                        <?php foreach ($Inscription1->getMentions() as $item) { ?>
                            <option value="<?php echo $item['id'] ?>" <?php if ($InscriptionData && $InscriptionData['id_mention'] == $item['id']) {
                                                                            echo "selected";
                                                                        } ?>><?php echo $item['mention'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-container">
                    <label for="note">Note du Baccalauréat</label>
                    <input type="number" max="20" min="0" step="0.01" name="note" id="note" placeholder="Entrer note du baccalauréat" value="<?php if ($InscriptionData && !empty($InscriptionData['note_generale'])) echo $InscriptionData['note_generale']; ?>" required>
                </div>
                <div class="input-container">
                    <label for="noteExamNational">Examen national</label>
                    <input type="number" max="20" min="0" step="0.01" name="noteExamNational" id="noteExamNational" placeholder="Entrer note du examen national" value="<?php if ($InscriptionData && !empty($InscriptionData['note_national'])) echo $InscriptionData['note_national']; ?>" required>
                </div>
                <div class="input-container">
                    <label for="noteExamRegional">Examen régional</label>
                    <input type="number" max="20" min="0" step="0.01" name="noteExamRegional" id="noteExamRegional" placeholder="Entrer note du examen régional" value="<?php if ($InscriptionData && !empty($InscriptionData['note_regional'])) echo $InscriptionData['note_regional']; ?>" required>
                </div>
                <?php foreach ($Inscription1->getCategorieDocument() as $item) { ?>
                    <div class="input-container">
                        <label for="<?php echo $item['abbr'] ?>"><?php echo $item['document'] ?></label>
                        <input type="file" name="<?php echo $item['abbr'] ?>" id="<?php echo $item['abbr'] ?>" required>
                        <?php if ($InscriptionData) { ?>
                            <embed src="<?php echo $Inscription1->getFileUrl($item['abbr'], $InscriptionData['inscription_numero'])['chemin']; ?>#toolbar=0&navpanes=0&scrollbar=0" width="425" height="425" />
                        <?php } ?>
                    </div>
                <?php } ?>
                <br />
                <div class="side2-title">les choix de filières universitaires</div>
                <div class="input-container">
                    <label for="choix1">Le premier choix</label>
                    <select name="choix1" id="choix1" required>
                        <option disabled selected>Choisissez votre premier choix</option>
                        <?php foreach ($Inscription1->getFilieres() as $item) { ?>
                            <option value="<?php echo $item['id'] ?>" <?php if ($InscriptionData && $InscriptionData['id_choix1'] == $item['id']) {
                                                                            echo "selected";
                                                                        } ?>><?php echo $item['filiere'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-container">
                    <label for="choix2">Le deuxième choix</label>
                    <select name="choix2" id="choix2" required>
                        <option disabled selected>Choisissez votre deuxième choix</option>
                        <?php foreach ($Inscription1->getFilieres() as $item) { ?>
                            <option value="<?php echo $item['id'] ?>" <?php if ($InscriptionData && $InscriptionData['id_choix2'] == $item['id']) {
                                                                            echo "selected";
                                                                        } ?>><?php echo $item['filiere'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button class="btn" type="submit" name="submit" style="margin: 50px auto;">Enregistrer</button>
            </form>
        </section>
    </main>
</body>
<script src="js/main.js"></script>
<script src="js/loader.js"></script>
</html>