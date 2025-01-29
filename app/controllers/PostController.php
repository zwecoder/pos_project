<?php
namespace app\controllers;

use app\core\Controller;


class PostController extends Controller
{
    public function __construct()
    {
        echo "I am construct of Post controller";
    }
    public function index(){
    echo "I am index of post controller";
    }
    public function show($id)
    {
        //echo "I am show id is $id";
        // // For simplicity, let's assume this is your data retrieval.
        $post = ["id" => $id, "title" => "Post Title {$id}", "content" => "Content of post {$id}"];
        $this->view('post', ['post' => $post]);
        
    }

}