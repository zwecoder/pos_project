<?php
session_start();
function redirect($uri)
    {
        header("Location:$uri");
    }
function dd($data)
    {
    echo "<pre>".die(var_dump($data,true))."</pre>";
    }
function flash($name='',$message='')
    {
        if(!empty($name)){
            if(!empty($message)){
                if(isset($_SESSION[$name])){
                    unset($_SESSION[$name]);
                }
            $_SESSION[$name]=$message;
            }else{
                if(isset($_SESSION[$name])){
                    echo "<div class='alert alert-success english rounded-3'><h6>".$_SESSION[$name]. "</h6></div>";
                    unset($_SESSION[$name]);
                }
            }
        }
    }
function setUserSession($user)
    {
        $_SESSION['currentUser']=$user;
    }
function getUserSession()
    {
        if(isset($_SESSION['currentUser'])){
            return $_SESSION['currentUser'];
        }else{
            return false;
        }
    }

function unsetUserSession()
    {
        unset($_SESSION['currentUser']);
    }
    
function request($data){
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        echo "POST method";
    }
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        echo "GET method";
    }
}
function created_at(){
    return date("Y-m-d H:m:s",time());
}

function jsonResponse($status,$status_type,$message){
    $response = [
        'status' => $status,
        'status_type' => $status_type,
        'message' => $message,
    ];
    echo json_encode($response);
    return;
}

