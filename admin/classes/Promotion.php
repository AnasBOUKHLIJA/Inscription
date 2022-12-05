<?php 
require_once 'DB.php';
class Promotion{ 
    static function getInfoPromotion(){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT * FROM promotion");
        $stm->execute();
        return $stm->fetch();
    }
    static function Update($promotion_id, $promotion_date_debut, $promotion_date_fin, $promotion){
        try{  
            $db = DB::getConnection();
            $stm = $db->prepare("UPDATE `promotion` SET `date_debut`=?,`date_fin`=?,`promotion`=? WHERE `promotion`.`id` = ?");
            $stm->execute([$promotion_date_debut, $promotion_date_fin, $promotion,$promotion_id]);
            header('location: inscription.php');
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
}
