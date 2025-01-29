<?php
namespace app\models;

use app\core\Database;


class HomeModel extends Database{
    protected $database;
    protected $pdo;
    public function __construct()
    {
        $this->database=new Database;
        $this->pdo=$this->database->db;
    }
   
}