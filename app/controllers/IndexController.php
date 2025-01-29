<?php

namespace app\controllers;

use app\core\Controller;
use app\models\AdminModel;
use app\models\OrderModel;
use app\models\QueryBuilder;


class IndexController extends Controller
{
    private $query;
    private $orderModel;
    public function __construct()
    {
        // echo "I am construnct";
        $this->query = new QueryBuilder;
        $this->orderModel=new OrderModel;
    }
    public function index()
    {   
        $totalCategories=$this->query->selectAll("categories");
        $totalproducts=$this->query->selectAll("products");
        $totalAdmins=$this->query->selectAll("admins");
        $totalCustomers=$this->query->selectAll("customers");
        $totalOrders=$this->query->selectAll("orders");
        $todayOrders=$this->orderModel->SelectByDate(date("Y-m-d"));
        if($todayOrders){
            $todayOrders=count($todayOrders);
        }else{
            $todayOrders=0;
        }
        $this->view('admin/index',[
            'totalCategories'=> count($totalCategories),
            'totalProducts'=>count($totalproducts),
            'totalAdmins'=>count($totalAdmins),
            'totalCustomers'=>count($totalCustomers),
            'todayOrders'=> $todayOrders,
            'totalOrders' => count($totalOrders),
    ]);
    }
}