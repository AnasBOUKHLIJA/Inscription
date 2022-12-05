<?php 
session_start();
require('Inscription.php');
require('Promotion.php');
require('FPDF/fpdf.php');

$Inscription  = new Inscription();
$InscriptionData = $Inscription->getInsciption($_SESSION['user']['id']);
$Promotion = Promotion::getInfoPromotion()['promotion'];
//Création d'un nouveau doc pdf (Portrait, en mm , taille A5)
$pdf = new FPDF('P', 'mm', 'A5');

//Ajouter une nouvelle page
$pdf->AddPage();

// entete

// Saut de ligne
$pdf->Ln(18);


// Police Arial gras 16
$pdf->SetFont('Arial', 'B', 16);
$pdf->Image('../images/parametre/nouveau_photo.gif', 1, 1, 25, 25);
$pdf->Image('../images/parametre/logo_universite.png', 122, 1, 25, 25);
// Titre
$pdf->SetFillColor(31,163,221);
$pdf->SetTextColor(255,255,255);
$pdf->SetDrawColor(31,163,221);
$pdf->Cell(0, 10, "La fiche d'inscription", 'TB', 1, 'C',true);
$pdf->Cell(0, 10, "La phase d'inscription ".$Promotion, 'TB', 1, 'C',true);

$pdf->Cell(0, 10, "Numero d'inscription : ".$InscriptionData['inscription_numero'], 0, 1, 'C',true);
// Saut de ligne
$pdf->Ln(50);

// Début en police Arial normale taille 10

$pdf->SetFont('Arial', '', 12);

// $pdf->Image('../'.$InscriptionData['photo'], 122, 1, 25, 25);

$pdf->Image('../'.$InscriptionData['photo'],60,62,30,0,'','http://www.fpdf.org');

//Ecriture normal
$pdf->SetFillColor(31,163,221);
$pdf->SetTextColor(255,255,255);
$pdf->SetDrawColor(255,255,255);
 $pdf->Cell(50,6,'Nom et Prenom ','LTRB',0,'L',true);
$pdf->SetFillColor(142,202,230);
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(255,255,255);
 $pdf->Cell(80,6,$InscriptionData['nom'].' '.$InscriptionData['prenom'],1,1,'LTR',true);

 $pdf->Write(1,"\n");
 $pdf->SetFillColor(31,163,221);
 $pdf->SetTextColor(255,255,255);
 $pdf->SetDrawColor(255,255,255);
 $pdf->Cell(50,6,'CNE','LTRB',0,'L',true);
 $pdf->SetFillColor(142,202,230);
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(255,255,255);
 $pdf->Cell(80,6,$InscriptionData['cne'],1,1,'L',true);

 $pdf->Write(1,"\n");
 $pdf->SetFillColor(31,163,221);
 $pdf->SetTextColor(255,255,255);
 $pdf->SetDrawColor(255,255,255);
 $pdf->Cell(50,6,'CIN','LTRB',0,'L',true);
 $pdf->SetFillColor(142,202,230);
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(255,255,255);
 $pdf->Cell(80,6,$InscriptionData['cin'],1,1,'L',true);

 $pdf->Write(1,"\n");
 $pdf->SetFillColor(31,163,221);
 $pdf->SetTextColor(255,255,255);
 $pdf->SetDrawColor(255,255,255);
 $pdf->Cell(50,6,'Email','LTRB',0,'L',true);
 $pdf->SetFillColor(142,202,230);
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(255,255,255);
 $pdf->Cell(80,6,$InscriptionData['email'],1,1,'L',true); 


 $pdf->Write(1,"\n");
 $pdf->SetFillColor(31,163,221);
 $pdf->SetTextColor(255,255,255);
 $pdf->SetDrawColor(255,255,255);
 $pdf->Cell(50,6,'adresse','LTRB',0,'L',true);
 $pdf->SetFillColor(142,202,230);
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(255,255,255);
 $pdf->Cell(80,6,$InscriptionData['adresse'],1,1,'L',true);

 $pdf->Write(1,"\n");
 $pdf->SetFillColor(31,163,221);
 $pdf->SetTextColor(255,255,255);
 $pdf->SetDrawColor(255,255,255);
 $pdf->Cell(50,6,'Note generale','LTRB',0,'L',true);
 $pdf->SetFillColor(142,202,230);
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(255,255,255);
 $pdf->Cell(80,6,$InscriptionData['note_generale'],1,1,'L',true); 

 $pdf->Write(1,"\n");
 $pdf->SetFillColor(31,163,221);
 $pdf->SetTextColor(255,255,255);
 $pdf->SetDrawColor(255,255,255);
 $pdf->Cell(50,6,'Note national','LTRB',0,'L',true);
 $pdf->SetFillColor(142,202,230);
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(255,255,255);
 $pdf->Cell(80,6,$InscriptionData['note_national'],1,1,'L',true);

 $pdf->Write(1,"\n");
 $pdf->SetFillColor(31,163,221);
 $pdf->SetTextColor(255,255,255);
 $pdf->SetDrawColor(255,255,255);
 $pdf->Cell(50,6,'Note regional','LTRB',0,'L',true);
 $pdf->SetFillColor(142,202,230);
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(255,255,255);
 $pdf->Cell(80,6,$InscriptionData['note_regional'],1,1,'L',true); 
 
 $pdf->Write(1,"\n");
 $pdf->SetFillColor(31,163,221);
 $pdf->SetTextColor(255,255,255);
 $pdf->SetDrawColor(255,255,255);
 $pdf->Cell(50,6,'1ere Choix','LTRB',0,'L',true);
 $pdf->SetFillColor(142,202,230);
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(255,255,255);
 $pdf->Cell(80,6,$Inscription->getNomFiliere($InscriptionData['id_choix1']),1,1,'L',true); 
 
 $pdf->Write(1,"\n");
 $pdf->SetFillColor(31,163,221);
 $pdf->SetTextColor(255,255,255);
 $pdf->SetDrawColor(255,255,255);
 $pdf->Cell(50,6,'2eme Choix','LTRB',0,'L',true);
 $pdf->SetFillColor(142,202,230);
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(255,255,255);
 $pdf->Cell(80,6,$Inscription->getNomFiliere($InscriptionData['id_choix2']),1,1,'L',true);

//Afficher le pdf
$pdf->Output('', '', true);

?>