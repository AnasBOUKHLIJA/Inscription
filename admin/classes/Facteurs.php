<?php 
require_once 'DB.php';
class Facteurs{
    public $id_filiere;
    public $id_type_bac;
    public $facteur;
    public function __construct($id_type_bac,$id_filiere,$facteur)
    {
        $this->id_type_bac = $id_type_bac;
        $this->id_filiere = $id_filiere;
        $this->facteur = $facteur;
    }
    public function add(){
        $db = DB::getConnection();
        if(!Facteurs::getFacteursOfTypeBac($this->id_type_bac,$this->id_filiere)){
            $stm = $db->prepare("INSERT INTO `facteurs` (`id_type_bac`, `id_filiere`, `facteur`) VALUES (?,?,?);");
            $stm->execute([$this->id_type_bac,$this->id_filiere,$this->facteur]);
            $stm->fetch();
        }else{
            $stm = $db->prepare("UPDATE `facteurs` SET `facteur` = ? WHERE `facteurs`.`id_type_bac` = ? AND `facteurs`.`id_filiere` = ?;");
            $stm->execute([$this->facteur,$this->id_type_bac,$this->id_filiere]);
            $stm->fetch();
        }
        header('location: inscription.php#facteurs');
    }
    static function getFacteursOfTypeBac($id_type_bac,$id_filiere){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT facteur FROM facteurs WHERE id_type_bac = ? AND id_filiere = ?");
        $stm->execute([$id_type_bac,$id_filiere]);
        $result = $stm->fetch();
        return $result;
    }
}