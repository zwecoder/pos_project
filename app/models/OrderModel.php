<?php

namespace app\models;

use app\core\Database;
use PDO;

class OrderModel extends Database
{
    private $database;
    private $pdo;
    public function __construct()
    {
        $this->database = new Database;
        $this->pdo = $this->database->db;
    }
    public function joinTables()
    {
        $stmt = $this->pdo->prepare("SELECT o.*,c.* FROM orders o,customers c  WHERE c.id=o.customer_id ORDER BY o.id DESC");
        $stmt->execute();
       $result = $stmt->fetchAll(\PDO::FETCH_OBJ);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    public function SelectByTrackNo($id)
    {
        $stmt = $this->pdo->prepare("SELECT o.*,c.* FROM orders o,customers c  
        WHERE c.id=o.customer_id AND tracking_no=? ORDER BY o.id DESC");
        $stmt->execute([$id]);
        $result = $stmt->fetch(\PDO::FETCH_OBJ);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    public function SelectProductByTrackNo($id)
    {
        $stmt=$this->pdo->prepare("SELECT o.*,oi.*,p.image,p.name FROM orders as o,order_items as oi,products as p 
        WHERE oi.order_id=o.id AND p.id=oi.product_id AND o.tracking_no=?");
        $stmt->execute([$id]);
        $result=$stmt->fetchAll(\PDO::FETCH_OBJ);
        if($result){
            return $result;
        }else{
            return false;
        }
    }
    public function SelectByDate($date)
    {
        $stmt = $this->pdo->prepare("SELECT o.*,c.* FROM orders o,customers c  
        WHERE c.id=o.customer_id AND o.order_date=? ORDER BY o.id DESC");
        $stmt->execute([$date]);
        $result = $stmt->fetchAll(\PDO::FETCH_OBJ);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    public function SelectByPaymentMode($payment_mode)
    {
        $stmt = $this->pdo->prepare("SELECT o.*,c.* FROM orders o,customers c  
        WHERE c.id=o.customer_id AND o.payment_mode=? ORDER BY o.id DESC");
        $stmt->execute([$payment_mode]);
        $result = $stmt->fetchAll(\PDO::FETCH_OBJ);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    public function SelectByDateAndPaymentMode($date,$payment_mode){
    
        $stmt=$this->pdo->prepare("SELECT o.*,c.* FROM orders o,customers c  
        WHERE c.id=o.customer_id AND o.order_date=? AND o.payment_mode=? ORDER BY o.id DESC");
        $stmt->execute([$date,$payment_mode]);
        $result=$stmt->fetchAll(\PDO::FETCH_OBJ);
        if($result){
            return $result;
        }else{  
            return false;
        }
    }
}
