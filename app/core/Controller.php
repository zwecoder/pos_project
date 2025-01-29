<?php
namespace app\core;

class Controller
{
    public function view($view, $data = [])
    {
        extract($data);
       // if (file_exists("../app/views/".$view.".php")) {
        //require_once("../../app/views/$view.php");
        //dd(APPROOT . "/views/$view.php");    
        require_once(APPROOT . "/views/$view.php");
        //}
       
    }
}