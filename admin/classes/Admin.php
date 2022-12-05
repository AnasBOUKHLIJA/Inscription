<?php
require_once 'DB.php';
class Admin
{
    public $email;
    public $pass;
    public function __construct($email, $pass)
    {
        $this->email = $email;
        $this->pass = $pass;
    }
    public function authenticate()
    {
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT * FROM admin WHERE email=? AND password=?");
        $stm->execute([$this->email, $this->pass]);
        $data = $stm->fetchAll();
        if (count($data) > 0) {
            $_SESSION['admin'] = $data[0];
            header('location: index.php');
        } else {
            header('location: connexion.php?error');
        }
    }
    public function deconnexion()
    {
        session_destroy();
    }
    public function get($id)
    {
        $db = DB::getConnection();
        $stm = $db->prepare("SELECT emailname,password FROM compte WHERE id=?");
        $stm->execute([$id]);
        $data = $stm->fetchAll();
        return $data[0];
    }
}
