<?php namespace app\controllers;

use app\core\Controller;
use app\models\QueryBuilder;
use app\models\OrderModel;


class OrderController extends Controller{
    private $query;
    private $orderModel;
    public function __construct(){
        $this->query = new QueryBuilder;
        $this->orderModel=new OrderModel;
    }
   
    public function orderIncDec($qtyVal, $productId)
    {
                $flag = false;
                foreach ($_SESSION['productItems'] as $key => $item) {
                    $flag = true;
                    if ($item['product_id'] == $productId) {
                        $_SESSION['productItems'][$key]['quantity'] = $qtyVal;
                    }
                }
                if ($flag) {
                    jsonResponse(200,'success','Quantity Updated');
                    exit();//filter html layout for json parse
                } else {
                    jsonResponse(500,'error','something went wrong.Please re-fresh');
                    exit();
                }
    }
    public function orderCreate()
    {
        $products = $this->query->selectAll('products');
       
        $this->view('admin/order_create', [
            'products' => $products,  
        ]);
    }
   
    public function orderAdd()
    {
        if(!isset($_SESSION['productItems'])){
            $_SESSION['productItems']=[];
        }
        if (!isset($_SESSION['productItemIds'])) {
            $_SESSION['productItemIds'] = [];
        }
       
        $filter = [
            'product_id' => FILTER_SANITIZE_NUMBER_INT,
            'quantity' => FILTER_SANITIZE_NUMBER_INT,
        ];
        $input = filter_input_array(INPUT_POST, $filter);
        /////////hash password /////////


        $data = [
            'products'=> $this->query->selectAll('products'),
            'product_id' => $input['product_id'],
            'quantity' => $input['quantity'],
            'created_at' => created_at(),
            'updated_at' => created_at(),
            'product_id_err' => '',
            'quantity_err' => '',
        ];
       
        if (empty($data['product_id'])) {
            $data['product_id_err'] = "Category name must be supplied";
        }
        if (empty($data['quantity'])) {
            $data['quantity_err'] = "quantity must be a least one";
        }

         $quantityCheck = $this->query->selectById("products", $input['product_id']);
        if(isset($quantityCheck->quantity)){
            if ($quantityCheck->quantity < $data['quantity']) {
                $data['quantity_err'] = "Only " . $quantityCheck->quantity . " quantity available";
            } 
        }
        
        if (empty($data['product_id_err'])&& empty($data['quantity_err'])) {
           // // dd($quantityCheck->quantity);
            $orderData = [
                'product_id' => $quantityCheck->id,
                'name' => $quantityCheck->name,
                'image' => $quantityCheck->image, // Ensure this is correctly set
                'price' => $quantityCheck->price,
                'quantity' => $input['quantity']
            ];
            if(!in_array($quantityCheck->id,$_SESSION['productItemIds'])){
                array_push($_SESSION['productItemIds'], $quantityCheck->id);
                array_push($_SESSION['productItems'],$orderData);
            }else{
                foreach($_SESSION['productItems'] as $key=> $item){
                    //echo $item['id']. "and " .$key;
                    if($item['product_id']==$quantityCheck->id){
                        $newQuantity = $item['quantity'] + $input['quantity'];
                        $orderData = [
                            'product_id' => $quantityCheck->id,
                            'name' => $quantityCheck->name,
                            'image' => $quantityCheck->image,
                            'price' => $quantityCheck->price,
                            'quantity' => $newQuantity
                        ];
                        $_SESSION['productItems'][$key] = $orderData;
                    }
                }
            }
            
          
            /////ajax post data
          // // if (isset($_POST['productIncDec'])) {
              //  //var_dump($_POST);
               // // $filter = [
               // //     'product_id' => FILTER_SANITIZE_NUMBER_INT,
              //  //     'quantity' => FILTER_SANITIZE_NUMBER_INT,
              //  // ];
               // // $input = filter_input_array(INPUT_POST, $filter);
               // // $productId = $input['product_id'];
               // // $quantity = $input['quantity'];
               // // $flag = false;
              //  // foreach ($_SESSION['productItems'] as $key => $item) {
               // //     $flag = true;
               // //     if ($item['product_id'] == $productId) {
               // //         $_SESSION['productItems'][$key]['quantity'] = $quantity;
               // //     }
               // // }
                // // if ($flag) {
               // //     jsonResponse(200, 'success', 'Quantity Updated');
               // // } else {
               // //     jsonResponse(500, 'error', 'something went wrong.Please re-fresh');
               // // }
            ////} /////ajax post data end

            
            // //$this->query->insertData("categories", $orderData);
            //  //  echo $result;
           // //dd($orderData);
            flash('order_create_success', "Item Added ".$quantityCheck->name);
            redirect('order_create');
                
          
        } else {
            
            $this->view("admin/order_create", $data);
        }
       

    }
    public function orderDelete($key)
    {
        // dd($key);
        // $data = $this->query->selectById("products", $id);
        if (isset($_SESSION['productItems'])&& isset($_SESSION['productItemIds'])) {
            unset($_SESSION['productItems'][$key]);
            unset($_SESSION['productItemIds'][$key]);
            flash('item_remove_success', "Item removed success");
            redirect('/admin/order_create');
            // }
        } else {
            flash('item_remove_fail', "Item remove fail");
            redirect('/admin/order_create');
        }
    }

///////////////////////////////////////////////////////////////
    public function orderPayment($paymentMethod,$cphone){

        //checking for customer/////
       $checkCustomer=$this->query->selectByPhNumber('customers',$cphone);
       //echo $checkCustomer;

       if($checkCustomer){

       
            $_SESSION['invoice_no']="INV_".rand(111111,999999);
            $_SESSION['cphone']=$cphone;
            $_SESSION['payment_mode']=$paymentMethod;
            jsonResponse(200, "success","Customer found");
        }else{
            $_SESSION['cphone'] = $cphone;
            jsonResponse(404, "warning", "Customer Not found"); 
            exit();  
        }
        //exit();
        // $this->view('admin/order_create', [
        //     'products' => $products,
        // ]);
    }
    public function orderPaymentCustomer()
    {
        $filter = [
                    'cname' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                    'cemail' => FILTER_SANITIZE_EMAIL,
                    'cphone' => FILTER_SANITIZE_NUMBER_INT,
                    //from ajax data arrary
                 ];
         $input = filter_input_array(INPUT_POST, $filter);
         //check customer
        $checkCustomer = $this->query->selectByPhNumber('customers', $input['cphone']);
        if ($checkCustomer) {
            jsonResponse(404, "warning", "Customer already exist");
            exit();
        }

        $data = [
            'name' => $input['cname'],
            'email' => $input['cemail'],
            'phnumber' => $input['cphone'],
            'is_ban' => 1,
            'created_at' => created_at(),
            'updated_at' => created_at(),
        ];
        if($data['name']!=''&&$data['email']!=''&&$data['phnumber']!=''){
            
            //add customer data to table/////
            $insertData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phnumber' => $data['phnumber'],
                'is_ban' => $data['is_ban'], // Ensure this is correctly set
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ];
            $addCustomer = $this->query->insertData('customers', $insertData);
          
            jsonResponse(200, "success", "customers added successful");
        }else{
            jsonResponse(422, "warning", "please fill required field");
        }
    
    }

 //// order summary       
    public function orderSummary(){
        ////order
        if (!isset($_SESSION['productItems'])) {
            echo '<script> window.location.href ="/admin/order_create"</script>';
        } 
        if (isset($_SESSION['cphone'])) {
            $phone = $_SESSION['cphone'];
            $invoiceNo = $_SESSION['invoice_no'];
            $checkCustomer = $this->query->selectByPhNumber('customers', $phone);
            if($checkCustomer){
                    $data = [
                        'name' => $checkCustomer->name,
                        'email' => $checkCustomer->email,
                        'phnumber' => $checkCustomer->phnumber,
                        'is_ban' => $checkCustomer->is_ban,
                        'invoiceNo'=> $invoiceNo,
                        'sessionProducts'=>$_SESSION['productItems'],
                    ];
                $this->view('admin/order_summary', $data);    
            }else{
            redirect('/admin/order_create');
            }  
        }
       
    }
    ////order Save
    public function orderSave(){
        $phone = $_SESSION['cphone'];
        $invoiceNo = $_SESSION['invoice_no'];
        $paymentMethod= urldecode($_SESSION['payment_mode']);
        $sessionProducts = $_SESSION['productItems'];
        $orderPlaceById= getUserSession()->id;
        $checkCustomer = $this->query->selectByPhNumber('customers', $phone);
        if(!$checkCustomer){
            jsonResponse(500, "error", "something went wrong");
            exit();
        }
        else if(!isset($_SESSION['productItems'])){
            jsonResponse(404,"warning","No Items to place order!");
        }
        ////insert orders
        $totalAmount=0;
       foreach($sessionProducts as $key =>$value){
        $totalAmount+= $value['price']*$value['quantity'];
        }
        $data=[
          'customer_id'=> $checkCustomer->id,
          "tracking_no" => rand(11111,99999),  
          "invoice_no" => $invoiceNo,
          'total_amount'=>$totalAmount,
          'order_date'=> date('Y-m-d'),  
          'order_status'=> 'Booked',  
          'payment_mode'=> $paymentMethod,  
          'order_placed_by_id'=>$orderPlaceById,  
        ];
        
        $this->query->insertData('orders',$data);
        ////insert order Items data
        $lastInsertId=$this->query->lastInsertId();
       
        foreach ($sessionProducts as $productItem) {
            $productId=$productItem['product_id'];
            $price = $productItem['price'];
            $quantity = $productItem['quantity'];
            $orderDataItem=[
                'order_id'=>$lastInsertId,
                'product_id'=>$productId,
                'price'=>$price,
                'quantity'=>$quantity,
            ];
           $this->query->insertData('order_items',$orderDataItem);
            ////order items quantity reupdate after booking
            $checkProductQuantity=$this->query->selectById('products',$productId);
            $newProductQuantity=$checkProductQuantity->quantity-$quantity;
           //////error checker for php
            $dataUpdate=[
                'quantity'=>$newProductQuantity
            ];
            $this->query->updatebyId('products',$productId,$dataUpdate);
         
        }
        ////dd($checkProductQuantity); 
        unset($_SESSION['productItemIds']);
        unset($_SESSION['productItems']);
        unset($_SESSION['cphone']);
        unset($_SESSION['payment_mode']);
        unset($_SESSION['invoice_no']);
        jsonResponse(200,'success','Order Placed Successfully');
    }
    public function orders(){
        $orders=$this->orderModel->joinTables();
        if($orders){
                $this->view('admin/orders',[
                'orders'=>$orders
                ]);
         
        }else{
            // $orders['error'] = "something  went wrong";
            $this->view('admin/orders', [
                'orders' => $orders
            ]);
        }
    }
    public function orderView($trackNo){
       $data=$this->orderModel->SelectByTrackNo($trackNo);
       $productDatas=$this->orderModel->SelectProductByTrackNo($trackNo);
        $this->view('admin/order_view',[
            'data'=>$data,
            'productDatas'=>$productDatas
        ]);
    }
    public function orderViewPrint($trackNo){
        $data = $this->orderModel->SelectByTrackNo($trackNo);
        $productDatas=$this->orderModel->SelectProductByTrackNo($trackNo);
        $this->view('admin/order_view_print',[
            'data'=>$data,
            'productDatas'=>$productDatas
        ]);
    }
  
    public function ordersFilter()
    {
        $filter = [
            'date' => FILTER_SANITIZE_SPECIAL_CHARS,
            'payment_mode' => FILTER_SANITIZE_SPECIAL_CHARS,
        ];
        $input = filter_input_array(INPUT_POST, $filter);
        //dd($input['payment_mode']);
        $orders = $this->orderModel->joinTables();
        if($input['date']!=''&&$input['payment_mode']==''){
            $dateFilter = $this->orderModel->SelectByDate($input['date']);
            $this->view('admin/orders',[
                'orders'=>$dateFilter,
                'date'=>$input['date']
            ]);
        }
        elseif($input['date']==''&&$input['payment_mode']!=''){
            $paymentFilter = $this->orderModel->SelectByPaymentMode($input['payment_mode']);
            $this->view('admin/orders',[
                'orders'=>$paymentFilter,
                'payment_mode'=>$input['payment_mode']
            ]);
        }elseif($input['date']!=''&&$input['payment_mode']!=''){
            $dateAndPaymentFilter=$this->orderModel->SelectByDateAndPaymentMode($input['date'],$input['payment_mode']);
                $this->view('admin/orders',[
                'orders'=>$dateAndPaymentFilter,
                'date'=>$input['date'],
                'payment_mode'=>$input['payment_mode']
            ]);
        }else{
            $this->view('admin/orders', [
                'orders' => $orders
            ]);
        }
    }       
  
   
}