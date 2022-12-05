<?php
require_once 'DB.php';
class Inscription{
    public function abstractGetFun($param){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT * FROM $param");
        $stm->execute();
        $data = $stm->fetchAll();
        return $data;
    }
    public function getRegions(){
        return $this->abstractGetFun('region');
    }
    public function getVilles(){
        return $this->abstractGetFun('ville');
    }
    public function getMentions(){
        return $this->abstractGetFun('mention');
    }
    public function getTypesBac(){
        return $this->abstractGetFun('type_bac');
    }
    public function getCategorieDocument(){
        return $this->abstractGetFun('categorie_document');
    }
    public function getFilieres(){
        return $this->abstractGetFun('filiere');
    }
    public function getInsciption($id){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT * FROM inscription WHERE id=? ");
        $stm->execute([$id]);
        $data = $stm->fetchAll();
        return $data[0];
    }
    public function getFileUrl($documentCategorie,$numero_inscription){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT chemin FROM inscription JOIN document JOIN categorie_document ON inscription.inscription_numero = document.inscription_numero AND categorie_document.document_id = document.document_id
        Where categorie_document.abbr=? AND inscription.inscription_numero=?");
        $stm->execute([$documentCategorie,$numero_inscription]);
        $data = $stm->fetchAll();
        return $data[0];
    }
    public function add($id, $data)
    {
        if(isset($data['nom']) && isset($data['prenom']) && isset($data['dateNaissance']) && isset($data['email']) && isset($data['cin']) && isset($data['cne']) && isset($data['note']) && isset($data['noteExamRegional']) && isset($data['noteExamNational']) && isset($data['region']) && isset($data['mention']) && isset($data['typeBac']) && isset($data['ville']) && isset($data['choix1']) && isset($data['choix2']) ){
            $imgUrl = $this->uploaded('IMG-',array("jpg","png","jpeg"),$_FILES['img']);$bac = $this->uploaded('DOC-BAC-',array("pdf"),$_FILES['bac']);
            $releve = $this->uploaded('DOC-RELEVE-',array("pdf"),$_FILES['releve']);
            $carte = $this->uploaded('DOC-CARTE-',array("pdf"),$_FILES['carte']);
            if($this->isSubscribe($id) === 0){
                $db = DB::getConnection();
                $stm = $db->prepare("INSERT INTO `inscription`  ( `inscription_date`, `inscription_modification`, `nombre_modification`, `nom`, `prenom`,`dateNaissance`, `email`, `photo`, `cin`, `cne`,  `adresse`,`tele`, `note_generale`, `note_regional`, `note_national`, `annee_bac`, `id`, `id_region`, `id_mention`, `id_type_bac`, `id_ville`, `id_choix1`, `id_choix2`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,  ?, ?);");
                $stm->execute([date("Y-m-d H:i:s"),date("Y-m-d H:i:s"),0,$data['nom'],$data['prenom'],$data['dateNaissance'],$data['email'],$imgUrl,$data['cin'],$data['cne'],$data['adresse'],$data['tele'],$data['note'],$data['noteExamRegional'],$data['noteExamNational'],$data['bacAnnee'],$id,$data['region'],$data['mention'],$data['typeBac'],$data['ville'],$data['choix1'],$data['choix2']]);
                $stm2 = $db->prepare("SELECT inscription_numero FROM inscription WHERE id=?");
                $stm2->execute([$id]);
                $numero_inscription = $stm2->fetchAll()[0]['inscription_numero'];
                $stmDoc = $db->prepare("INSERT INTO `document` (`document_id`, `inscription_numero`, `chemin`) VALUES (?, ?, ?);");
                $stmDoc->execute([1, $numero_inscription, $bac]);
                $stmDoc->execute([2, $numero_inscription, $releve]);
                $stmDoc->execute([3, $numero_inscription, $carte]);
            }else{
                $db = DB::getConnection();
                $stmInscription = $db->prepare("SELECT inscription_numero,photo,nombre_modification FROM inscription WHERE id=?");
                $stmInscription->execute([$id]);
                $inscriptionData = $stmInscription->fetchAll();
                $numero_inscription =  $inscriptionData[0]['inscription_numero'];
                $nombre_modification = $inscriptionData[0]['nombre_modification'];
                if($_FILES['img']['name']===""){
                   $imgUrl = $inscriptionData[0]['photo'];
                }
                $stm = $db->prepare("UPDATE `inscription` SET `inscription_modification` = ?, `nombre_modification` = ?, `nom` = ?, `prenom` = ?,`dateNaissance` = ?,  `email` = ?, `photo` = ?, `cin` = ?, `cne` = ?, `adresse` = ?, `tele` = ?, `note_generale` = ?, `note_regional` = ?, `note_national` = ?, `annee_bac` = ?, `id_region` = ?, `id_mention` = ?, `id_type_bac` = ?, `id_ville` = ?, `id_choix1` = ?, `id_choix2` = ? WHERE `inscription`.`inscription_numero` = ?");
                $stm->execute([date("Y-m-d H:i:s"),$nombre_modification+1,$data['nom'],$data['prenom'],$data['dateNaissance'],$data['email'],$imgUrl,$data['cin'],$data['cne'],$data['adresse'],$data['tele'],$data['note'],$data['noteExamRegional'],$data['noteExamNational'],$data['bacAnnee'],$data['region'],$data['mention'],$data['typeBac'],$data['ville'],$data['choix1'],$data['choix2'],$numero_inscription ]);
                $stmDoc = $db->prepare("UPDATE `document` SET  `chemin` = ? WHERE `document_id`= ? AND `inscription_numero`= ?");   
                if($_FILES['bac']['name']!==""){
                    $stmDoc->execute([$bac,1,$numero_inscription]);
                }
                if($_FILES['releve']['name']!==""){
                    $stmDoc->execute([$releve,2, $numero_inscription]);
                }
                if($_FILES['carte']['name']!==""){
                    $stmDoc->execute([$carte,3, $numero_inscription]);
                }
            }
           header('location: index.php?succes');
        } else {
            header('location: index.php?infoNonComplet' );
        }
    }
    public function uploaded($type,$all_ex_po,$file){
        $filename = $file["name"];
        $filetmpname = $file["tmp_name"];
        $filerror = $file["error"];
        if ($filerror === 0) {
            $file_ex =  pathinfo($filename, PATHINFO_EXTENSION);
            $file_ex_lc = strtolower($file_ex);
            if (in_array($file_ex_lc, $all_ex_po)) {
                $new_name = uniqid($type, true) . '.' . $file_ex;
                $img_upload_path = 'images/' . $new_name;
                move_uploaded_file($filetmpname, $img_upload_path);
                return $img_upload_path;
            }
        }
    }
    public function isSubscribe($id){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT inscription_numero FROM compte JOIN inscription ON compte.id = inscription.id WHERE compte.id = ?");
        $stm->execute([$id]);
        $data = $stm->fetchAll();
        return count($data);
    }
    public function getNomFiliere($id_filiere)
    {
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT filiere FROM filiere WHERE id = ?");
        $stm->execute([$id_filiere]);
        return $stm->fetch()['filiere'];
    }
}