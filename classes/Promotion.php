<?php 
require_once 'DB.php';
class Promotion{ 
    static function getInfoPromotion(){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT * FROM promotion WHERE id = ?");
        $stm->execute([1]);
        return $stm->fetch();
    }
}