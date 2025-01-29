<?php
namespace app\core;
class Database{
private $host=DB_HOST;
private $db_name=DB_NAME;
private $db_user=DB_USER;
private $db_pass=DB_PASS;
protected  $db;

    public function __construct(){
        $dbc="mysql:host=".$this->host.";dbname=".$this->db_name;
        $option=[
        \PDO::ATTR_PERSISTENT=>true,
        \PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION  
        ];
        try{
            $this->db=new \PDO($dbc,$this->db_user,$this->db_pass,$option);
        }catch(\Exception $e){
            exit($e->getmessage());
        }
    }

}
