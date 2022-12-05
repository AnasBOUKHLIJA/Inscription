<?php
require_once 'DB.php';
class Filiere
{
    public $filiere;
    public function __construct($filiere)
    {
        $this->filiere = $filiere;
    }
    static function getAllFiliere()
    {
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT * FROM filiere");
        $stm->execute();
        return $stm->fetchAll();
    }
    static function getNomFiliere($id_filiere)
    {
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT filiere FROM filiere WHERE id = ?");
        $stm->execute([$id_filiere]);
        return $stm->fetchAll()[0]['filiere'];
    }
    static function delete($id)
    {
        $db = DB::getConnection();
        $stm = $db->prepare("DELETE FROM filiere WHERE id = ?");
        $stm->execute([$id]);
        header('location: inscription.php');
    }
    static function update($id, $newValue)
    {
        $db = DB::getConnection();
        $stm = $db->prepare("UPDATE filiere SET filiere = ? WHERE id = ?");
        $stm->execute([$newValue, $id]);
        header('location: inscription.php');
    }
    public function add()
    {
        $db = DB::getConnection();
        $stm = $db->prepare("INSERT INTO filiere (filiere) values (?)");
        $stm->execute([$this->filiere]);
        header('location: inscription.php');
    }
    static function getCountOfInscription($id)
    {
        return Filiere::getCountOfInscriptionChoix1($id) + Filiere::getCountOfInscriptionChoix2($id);
    }
    static function getCountOfInscriptionChoix1($id)
    {
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT inscription_numero FROM inscription INNER JOIN filiere ON inscription.id_choix1 = filiere.id WHERE filiere.id = ?");
        $stm->execute([$id]);
        return count($stm->fetchAll());
    }
    static function getCountOfInscriptionChoix2($id)
    {
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT inscription_numero FROM inscription INNER JOIN filiere ON inscription.id_choix2 = filiere.id WHERE filiere.id = ?");
        $stm->execute([$id]);
        return count($stm->fetchAll());
    }
}
