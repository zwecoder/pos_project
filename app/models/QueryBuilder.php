<?php
namespace app\models;

use app\core\Database;
use PDO;

class QueryBuilder extends Database{
    protected $database;
    protected $pdo;
    public function __construct(){
        $this->database=new Database;
        $this->pdo=$this->database->db;
    }
    public function selectAll($table){
        $stmt=$this->pdo->prepare("SELECT * FROM $table");
        $stmt->execute();
        return $tasks = $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    public function selectById($table,$id){
        $stmt=$this->pdo->prepare("SELECT * FROM $table WHERE id=?");
        $stmt->execute([$id]);
        return $tasks=$stmt->fetch(\PDO::FETCH_OBJ);
    }
    public function selectByPhNumber($table,$cphone){
        $stmt=$this->pdo->prepare("SELECT * FROM $table WHERE phnumber=? LIMIT 1");
        $stmt->execute([$cphone]);
        return $task=$stmt->fetch(\PDO::FETCH_OBJ);
    }
    public function insertData($table,$dataArr){
        $getDatakeys=array_keys($dataArr);
        $col=implode(",",$getDatakeys);
        $questionMark="";
        foreach($getDatakeys as $key){
        $questionMark.="?,";
        } 
        $questionMark=rtrim($questionMark,",");
        $sql="INSERT INTO $table ($col) VALUES ($questionMark)";
        $getDataValues=array_values($dataArr);
        $stmt=$this->pdo->prepare($sql);
        $stmt->execute($getDataValues);
    }
    public function updatebyId($table,$id,$dataArr){
        
        $updateCol="";
        $getDataValues = array_values($dataArr);
        $getDataValues[]=$id;
        
        foreach($dataArr as $key=>$value){
        $updateCol.=$key."="."?,";
        }
        $updateCol=rtrim($updateCol, ",");
       
       $sql="UPDATE $table SET $updateCol WHERE id=?";
       $stmt=$this->pdo->prepare($sql);
       $stmt->execute($getDataValues);
    }
    public function delete($table,$id)
    {
        $sql="DELETE FROM $table WHERE id=? LIMIT 1";
        $stmt=$this->pdo->prepare($sql);
        return $result = $stmt->execute([$id]);
    }
    public function lastInsertId(){
        return $this->pdo->lastInsertId();
    }
    


  
}