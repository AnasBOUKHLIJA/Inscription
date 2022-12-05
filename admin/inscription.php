<?php
session_start();
require_once 'classes/Admin.php';
require_once 'classes/Inscription.php';
require_once 'classes/Filiere.php';
require_once 'classes/Document.php';
require_once 'classes/TypeBac.php';
require_once 'classes/Promotion.php';
require_once 'classes/Facteurs.php';

if (isset($_SESSION['admin'])) {
    $promotion =  Promotion::getInfoPromotion();
    if (isset($_POST['submit_filiere'])) {
        $filiere = new Filiere($_POST['filiere']);
        $filiere->add();
    } elseif (isset($_POST['submit_document'])) {
        $document = new Document($_POST['document'], $_POST['abbr']);
        $document->add();
    } elseif (isset($_POST['submit_bac'])) {
        $typeBac = new TypeBac($_POST['bac']);
        $typeBac->add();
    } elseif (isset($_POST['facteur'])) {
        $facteur = new Facteurs($_POST['id_type_bac'], $_POST['id_filiere'], $_POST['facteur']);
        $facteur->add();
    } elseif (isset($_POST['eliminer'])) {
        Inscription::changerEtatOfInscription(-1, $_POST['inscription_numero']);
        header('location: inscription.php');
    } elseif (isset($_POST['admettre'])) {
        Inscription::changerEtatOfInscription(1, $_POST['inscription_numero']);
        header('location: inscription.php');
    } elseif (isset($_GET['supprimerFiliere'])) {
        Filiere::delete($_GET['supprimerFiliere']);
    } elseif (isset($_GET['supprimerDoc'])) {
        Document::delete($_GET['supprimerDoc']);
    } elseif (isset($_GET['supprimerBac'])) {
        TypeBac::delete($_GET['supprimerBac']);
    } elseif (isset($_POST['modifyFiliere'])) {
        Filiere::update($_POST['filiere_id'], $_POST['filiere']);
    } elseif (isset($_POST['modifyDoc'])) {
        Document::update($_POST['document_id'], $_POST['document']);
    } elseif (isset($_POST['modifyBac'])) {
        TypeBac::update($_POST['type_bac_id'], $_POST['type_bac']);
    } elseif (isset($_POST['modifyPromotion'])) {
        Promotion::Update($_POST['promotion_id'], $_POST['promotion_date_debut'], $_POST['promotion_date_fin'], $_POST['promotion']);
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
    <title>Inscription</title>
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
    <section id="promotion-container">
        <h1>Inscription </h1>
        <form method="POST" action="">
            <table>
                <thead>
                    <tr>
                        <th>Promotion</th>
                        <th>date début</th>
                        <th>date fin</th>
                        <th>compte à rebours</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input name="promotion" class="input-date" value="<?php echo $promotion['promotion']; ?>"></td>
                        <input name="promotion_id" class="input-date-id" value="<?php echo $promotion['id']; ?>" hidden />
                        <td><input name="promotion_date_debut" class="input-date input-date-debut" name="date_debut" type="datetime-local" value="<?php echo $promotion['date_debut']; ?>"></td>
                        <td><input name="promotion_date_fin" class="input-date input-date-fin" name="date_fin" type="datetime-local" value="<?php echo $promotion['date_fin']; ?>"></td>
                        <?php if ($promotion['date_fin'] > date("Y-m-d H:i:s")) { ?>
                            <td id="countdown"></td>
                        <?php } ?>
                    </tr>
                </tbody>
            </table>
            <button name="modifyPromotion" type="submit" class="save-promotion">Enregistrer</button>
        </form>
        <h1 id="date_fin" style="display: none"><?php echo $promotion['date_fin']; ?></h1>
        <?php if ($promotion['date_fin'] < date("Y-m-d H:i:s")) { ?>
            <?php foreach (Filiere::getAllFiliere() as $item) { ?>
                <h2 class="h2" id="<?php echo $item['filiere']; ?>"><?php echo $item['filiere']; ?></h2>
                <?php
                $faireSelectionParFiliere = Inscription::faireSelectionParFiliere($item['id']);
                if (count($faireSelectionParFiliere) != 0) { ?>
                    <div class="table-selection-container">
                        <table class="table-selection">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nom</th>
                                    <th>Prenom</th>
                                    <th>Cne</th>
                                    <th>Cin</th>
                                    <th>Note</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($faireSelectionParFiliere as $Inscritpion) { ?>
                                    <tr>
                                        <td><a href="inscriptionDetails.php?inscription_numero=<?php echo $Inscritpion['inscription_numero']; ?>"> <img class="table-selection-img" src="./../<?php echo $Inscritpion['photo'] ?>" /></a> </td>
                                        <td><?php echo $Inscritpion['nom'] ?></td>
                                        <td><?php echo $Inscritpion['prenom'] ?></td>
                                        <td><?php echo $Inscritpion['cne'] ?></td>
                                        <td><?php echo $Inscritpion['cin'] ?></td>
                                        <td><?php echo $Inscritpion['note'] . ' ' . $Inscritpion['etat'] ?></td>
                                        <td>
                                            <form method="POST" action="">
                                                <input name="inscription_numero" value="<?php echo $Inscritpion['inscription_numero']; ?>" hidden>
                                                <?php if ($Inscritpion['etat'] == 1) { ?>
                                                    <button name="eliminer" type="submit">éliminer</button>
                                                <?php } elseif ($Inscritpion['etat'] == -1) { ?>
                                                    <button name="admettre" type="submit">admettre</button>
                                                <?php } ?>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <form action="classes/PrintPdf.php" class="form-effective">
                            <input name="filiere" value="<?php echo $item['id']; ?>" hidden>
                            <input type="number" min="1" value="<?php echo count($faireSelectionParFiliere); ?>" max="<?php echo count($faireSelectionParFiliere); ?>" name="effective">
                            <button type="submit" class="btn-form-effective">Télécharger</button>
                        </form>
                        <br />
                        <br />
                    <?php } else { ?>
                        <p class="filiere-vide">Il n'y a pas de candidature pour cette filière.</p>
                    <?php } ?>
                    </div>
            <?php }
        } ?>
    </section>
    <section id="filiere-container">
        <h1>Nos Filieres</h1>
        <?php foreach (Filiere::getAllFiliere() as $item) { ?>
            <span class="item filiere-item">
                <button class="icon-href"><a href="inscription.php?supprimerFiliere=<?php echo $item['id']; ?>"><img src="../icons/icon-cancel.png" class="icon-png" /></a></button>
                <form method="POST" action="" class="form-item-modify">
                    <input name="filiere_id" value="<?php echo $item['id']; ?>" hidden>
                    <textarea name="filiere"><?php echo $item['filiere']; ?></textarea>
                    <button name="modifyFiliere" type="submit" class="btn-href">Enregistrer</button>
                </form>
            </span>
        <?php } ?>
        <form method="POST" action="" class="form">
            <input type="text" name="filiere" placeholder="Entrer nom de la filiere">
            <button type="submit" name="submit_filiere">Ajouter</button>
        </form>
    </section>
    <section id="document-container">
        <h1>les documents demandés</h1>
        <?php foreach (Document::getAllDocumentType() as $item) { ?>
            <span class="item document-item">
                <button class="icon-href"><a href="inscription.php?supprimerDoc=<?php echo $item['document_id']; ?>"><img src="../icons/icon-cancel.png" class="icon-png" /></a></button>
                <form method="POST" action="" class="form-item-modify">
                    <input name="document_id" value="<?php echo $item['document_id']; ?>" hidden>
                    <textarea name="document"><?php echo $item['document']; ?></textarea>
                    <button name="modifyDoc" type="submit" class="btn-href">Enregistrer</button>
                </form>
            </span>
        <?php } ?>
        <form method="POST" action="" class="form">
            <input type="text" name="document" placeholder="Entrer nom de le document">
            <input class="abbr" type="text" name="abbr" placeholder="Entrer abréviation de le document">
            <button type="submit" name="submit_document">Ajouter</button>
        </form>
    </section>
    <section id="bac-container">
        <h1>Les spécialités demandées</h1>
        <?php foreach (TypeBac::getTypeBac() as $item) { ?>
            <item class="item bac-item">
                <button class="icon-href"><a href="inscription.php?supprimerBac=<?php echo $item['id']; ?>"><img src="../icons/icon-cancel.png" class="icon-png" /></a></button>
                <form method="POST" action="" class="form-item-modify">
                    <input name="type_bac_id" value="<?php echo $item['id']; ?>" hidden>
                    <textarea name="type_bac"> <?php echo $item['type_bac']; ?> </textarea>
                    <button name="modifyBac" type="submit" class="btn-href">Enregistrer</button>
                </form>
            </item>
        <?php } ?>
        <form method="POST" action="" class="form">
            <input type="text" name="bac" placeholder="Entrer nom de la spécialité">
            <button type="submit" name="submit_bac">Ajouter</button>
        </form>
    </section>
    <span id="facteurs"></span>
    <section id="bac-filiere-container">
        <h1>Les facteurs de pondération </h1>
        <table>
            <thead>
                <tr>
                    <th class="th-table"></th>
                    <?php foreach (Filiere::getAllFiliere() as $item) { ?>
                        <th><?php echo $item['filiere'] ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach (TypeBac::getTypeBac() as $item) { ?>
                    <tr>
                        <td class="td-type-bac"><?php echo $item['type_bac']; ?></td>
                        <?php foreach (Filiere::getAllFiliere() as $item2) { ?>
                            <td>
                                <form method="POST" action="" class="form">
                                    <input hidden name="id_type_bac" value="<?php echo $item['id'] ?>">
                                    <input hidden name="id_filiere" value="<?php echo $item2['id'] ?>">
                                    <input>
                                    <input name="facteur" value="<?php echo Facteurs::getFacteursOfTypeBac($item['id'], $item2['id'])['facteur'] ?>">
                                    <button type="submit" name="submit"><img src="../icons/icon-save.png" class="icon-png" /></button>
                                </form>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>
    <br />
    <br />
    <br />
    <script src="js/Url.js"></script>
    <script src="js/loader.js"></script>
    <script src="js/inscription.js"></script>
    <script src="lib/scrollreal.js"></script>
    <script src="lib/main.js"></script>
</body>

</html>