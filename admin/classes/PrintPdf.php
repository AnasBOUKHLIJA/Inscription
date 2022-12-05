<?php
session_start();
require('Inscription.php');
require('Filiere.php');
require('./../../classes/FPDF/fpdf.php');

$effective = (int)$_GET['effective'];
$cmp = 0;
//Création d'un nouveau doc pdf (Portrait, en mm , taille A5)
$pdf = new FPDF('P', 'mm', 'A5');

//Ajouter une nouvelle page
$pdf->AddPage();

// entete

// Saut de ligne
$pdf->Ln(18);


// Police Arial gras 16
$pdf->SetFont('Arial', 'B', 16);
$pdf->Image('./../../images/parametre/nouveau_photo.gif', 1, 1, 25, 25);
$pdf->Image('./../../images/parametre/logo_universite.png', 122, 1, 25, 25);
// Titre
$pdf->Cell(0, 10, " Listes des admis \"" . Filiere::getNomFiliere($_GET['filiere']) . "\"", 'TB', 1, 'C');
// Saut de ligne
$pdf->Ln(10);

// Début en police Arial normale taille 10

$pdf->SetFont('Arial', '', 10);

$pdf->Cell(32, 5, 'Numero inscription', 'LTRB', 0, 'L', 0);   //empty cell with left,top, and right borders
$pdf->Cell(32, 5, 'CNE', 1, 0, 'L', 0);
$pdf->Cell(32, 5, 'CIN', 1, 0, 'L', 0);
$pdf->Cell(32, 5, 'Nom et Prenom', 1, 1, 'L', 0);

foreach (Inscription::faireSelectionParFiliere($_GET['filiere']) as $Inscritpion) {
    if ($cmp == $effective) {
        $pdf->AddPage();
        $pdf->Ln(18);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Image('./../../images/parametre/nouveau_photo.gif', 1, 1, 25, 25);
        $pdf->Image('./../../images/parametre/logo_universite.png', 122, 1, 25, 25);
        // Titre
        $pdf->Cell(0, 10, "Listes attente \"" . Filiere::getNomFiliere($_GET['filiere']) . "\"", 'TB', 1, 'C');
        // Saut de ligne
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(32, 5, 'Numero inscription', 'LTRB', 0, 'L', 0);   //empty cell with left,top, and right borders
        $pdf->Cell(32, 5, 'CNE', 1, 0, 'L', 0);
        $pdf->Cell(32, 5, 'CIN', 1, 0, 'L', 0);
        $pdf->Cell(32, 5, 'Nom et Prenom', 1, 1, 'L', 0);
    }
    $pdf->Cell(32, 5, $Inscritpion['inscription_numero'], 1, 0, 'L', 0);
    $pdf->Cell(32, 5, $Inscritpion['cne'], 1, 0, 'L', 0);
    $pdf->Cell(32, 5, $Inscritpion['cin'], 1, 0, 'L', 0);
    $pdf->Cell(32, 5, $Inscritpion['nom'] . ' ' . $Inscritpion['prenom'], 1, 0, 'L', 0);
    $pdf->Cell(0.1, 5, '', 'LBR', 1, 'L', 0);
    
    $cmp++;
}
//Afficher le pdf
$pdf->Output('', '', true);
