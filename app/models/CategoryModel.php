<?php
namespace app\models;

use app\core\Database;
use PDO;

class CategoryModel extends Database{
    private $database;
    private $pdo;
    public function __construct()
    {
        $this->database=new Database;
        $this->pdo=$this->database->db;
    }
    public function getCategoryByName($table,$name){
        $stmt=$this->pdo->prepare("SELECT * FROM $table WHERE name=?");
        $stmt->execute([$name]);
        $result=$stmt->fetch(PDO::FETCH_OBJ);
        if($result){
            return $result;
        }else{
            return false;
        }
        
    }
}