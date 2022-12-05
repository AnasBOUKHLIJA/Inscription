<?php
require_once 'DB.php';
class Inscription{
    static function abstractGetFun($param,$id){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT * FROM $param WHERE id = $id");
        $stm->execute();
        $data = $stm->fetch();
        return $data;
    }
    static function getRegion($id){
        return Inscription::abstractGetFun('region',$id);
    }
    static function getVille($id){
        return Inscription::abstractGetFun('ville',$id);
    }
    static function getMention($id){
        return Inscription::abstractGetFun('mention',$id);
    }
    static function getTypesBac($id){
        return Inscription::abstractGetFun('type_bac',$id);
    }
    static function getCategorieDocument($id){
        return Inscription::abstractGetFun('categorie_document',$id);
    }
    static function getFiliere($id){
        return Inscription::abstractGetFun('filiere',$id);
    }
    static function getAllInscription(){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT inscription_numero,nom,prenom,photo,cne,cin,inscription_date,id_choix1,id_choix2 FROM inscription ORDER BY inscription_date");
        $stm->execute();
        return $stm->fetchAll();
    }

    static function getAllInscriptionByFiliere($id){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT inscription_numero,nom,prenom,photo,cne,cin,inscription_date,id_choix1,id_choix2 FROM inscription WHERE id_choix1 = ? OR id_choix2 = ? ORDER BY inscription_date");
        $stm->execute([$id,$id]);
        return $stm->fetchAll();
    }

    static function getInscriptionDetails($inscription_numero){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT * FROM inscription WHERE inscription_numero = ?");
        $stm->execute([$inscription_numero]);
        return $stm->fetch();
    }
    static function getDocsOfInscription($inscription_numero){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT document,chemin FROM inscription INNER JOIN document INNER JOIN categorie_document ON inscription.inscription_numero = document.inscription_numero AND categorie_document.document_id = document.document_id WHERE inscription.inscription_numero = ?");
        $stm->execute([$inscription_numero]);
        return $stm->fetchAll();
    }

    static function faireSelectionParFiliere($id_filiere){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT inscription_numero,cne,cin,prenom,nom,photo,(note_national*0.75+note_regional*0.25)*facteur as note,etat
        FROM inscription INNER JOIN filiere INNER JOIN type_bac INNER JOIN facteurs
        ON (inscription.id_choix1 = filiere.id OR inscription.id_choix2 = filiere.id) 
        AND inscription.id_type_bac = type_bac.id 
        AND facteurs.id_filiere = filiere.id
        AND facteurs.id_type_bac = type_bac.id
        WHERE filiere.id = ? AND etat != -1
        ORDER BY note DESC");
        $stm->execute([$id_filiere]);
        return $stm->fetchAll();
    }
    static function faireSelectionParFiliereEffective($id_filiere,$limit){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT inscription_numero,cne,cin,prenom,nom,photo,(note_national*0.75+note_regional*0.25)*facteur as note,etat
        FROM inscription INNER JOIN filiere INNER JOIN type_bac INNER JOIN facteurs
        ON (inscription.id_choix1 = filiere.id OR inscription.id_choix2 = filiere.id) 
        AND inscription.id_type_bac = type_bac.id 
        AND facteurs.id_filiere = filiere.id
        AND facteurs.id_type_bac = type_bac.id
        WHERE filiere.id = ? AND etat != -1
        ORDER BY note DESC
        LIMIT $limit");
        $stm->execute([$id_filiere]);
        return $stm->fetchAll();
    }

    static function changerEtatOfInscription($newEtat,$inscription_numero){
        $db = DB::getConnection();
        $stm = $db->prepare('UPDATE `inscription` SET `etat` = ? WHERE `inscription`.`inscription_numero` = ?;');
        $stm->execute([$newEtat,$inscription_numero]);
    }
}