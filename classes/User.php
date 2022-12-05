<?php
require_once 'DB.php';
class User
{
    public $user;
    public $pass;
    public function __construct($user, $pass)
    {
        $this->user = $user;
        $this->pass = $pass;
    }
    public function authenticate()
    {
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT * FROM compte WHERE username=? AND password=?");
        $stm->execute([$this->user, $this->pass]);
        $data = $stm->fetchAll();
        if (count($data) !== 0) {
            $_SESSION['user'] = $data[0];
            header('location: index.php');
        } else {
            header('location:connexion.php?error');
        }
    }
    public function deconnexion()
    {
        session_destroy();
    }
    public function enregistrer()
    {
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT * FROM compte WHERE username=?");
        $stm->execute([$this->user]);
        $data = $stm->fetchAll();
        if (count($data) < 1) {
            $stm2 = $db->prepare("INSERT INTO compte (username,password) values(?,?)");
            $stm2->execute([$this->user, $this->pass]);
            $this->authenticate();
        } else {
            header('location:register.php?error');
        }
    }
    public function reinitialiser($data){
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT compte.id as id FROM compte JOIN inscription ON compte.id = inscription.id Where compte.username = ? AND inscription.cne = ?");$stm->execute([$data['user'],$data['cne']]);
        $result = $stm->fetchAll();
        $idCompte = $result[0]['id'];
        if(count($result) === 0){
            header('location:reinitialiser.php?error');
        } else{
            $randomletter = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 10);
            $stm = $db->prepare("UPDATE compte SET password = ? WHERE id = ?");
            $stm->execute([$randomletter,$idCompte]);
            header('location:reinitialiser.php?success='.$randomletter);

        }
    }
    public function get($id)
    {
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT username,password FROM compte WHERE id=?");
        $stm->execute([$id]);
        $data = $stm->fetchAll();
        return $data[0];
    }
}
