<?php
require_once 'DB.php';
class TypeBac{
    public $bac;
    public function __construct($bac)
    {
        $this->bac = $bac;
    }
    static function getTypeBac(){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT * FROM type_bac");
        $stm->execute();
        return $stm->fetchAll();
    }
    static function delete($id){
        $db = DB::getConnection();
        $stm = $db->prepare("DELETE FROM type_bac WHERE id = ?");
        $stm->execute([$id]);
        header('location: inscription.php');
    }
    
    static function update($id,$newValue){
        $db = DB::getConnection();
        $stm = $db->prepare("UPDATE type_bac SET type_bac = ? WHERE id = ?");
        $stm->execute([$newValue,$id]);
        header('location: inscription.php');
    }
    public function add(){
        $db = DB::getConnection();
        $stm = $db->prepare("INSERT INTO type_bac (type_bac) values (?)");
        $stm->execute([$this->bac]);
        header('location: inscription.php');
    }
}