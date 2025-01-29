<?php
namespace app\models;

use app\core\Database;
use PDO;

class AdminModel extends Database{
    protected $database;
    protected $pdo;
    public function __construct()
    {
        $this->database=new Database;
        $this->pdo=$this->database->db;
    }
  
    public function getUserByEmail($table,$email)
    {   
        
        $stmt=$this->pdo->prepare("SELECT * From $table WHERE email=?");
        $stmt->execute([$email]);
        $result =$stmt->fetch(PDO::FETCH_OBJ);
        if($result){
        return $result;
        }else{
        return false;
        }
    }
}