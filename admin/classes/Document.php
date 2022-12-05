<?php
require_once 'DB.php';
class Document{
    
    public $document;
    public $abbr;
    public function __construct($document,$abbr)
    {
        $this->document = $document;
        $this->abbr = $abbr;
    }
    static function getAllDocumentType(){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT * FROM 	categorie_document");
        $stm->execute();
        return $stm->fetchAll();
    }
    static function delete($id){
        $db = DB::getConnection();
        $stm = $db->prepare("DELETE FROM categorie_document WHERE document_id = ?");
        $stm->execute([$id]);
        header('location: inscription.php');
    }
    static function update($id,$newValue){
        $db = DB::getConnection();
        $stm = $db->prepare("UPDATE categorie_document SET document = ? WHERE document_id = ?");
        $stm->execute([$newValue,$id]);
        header('location: inscription.php');
    }
    public function add(){
        $db = DB::getConnection();
        $stm = $db->prepare("INSERT INTO categorie_document (document,abbr) values (?,?)");
        $stm->execute([$this->document,$this->abbr]);
        header('location: inscription.php');
    }
}