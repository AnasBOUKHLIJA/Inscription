<?php
class DB
{
    static public function getConnection()
    {
        $db = new PDO("mysql:host=localhost;dbname=inscription", "root", "");
        $db->exec("set names utf8");
        return $db;
    }  
}