<?php
require_once APPROOT . "/views/admin/inc/header.php";
require_once APPROOT . "/views/admin/inc/nav.php";
?>

<div id="layoutSidenav">
    <?php require_once APPROOT . "/views/admin/inc/sidebar.php"; 
    ?>
    <div id="layoutSidenav_content">



        <!-- drop Modal start -->

        <!-- drop modal end -->



        <div class="container-fluid px-4">
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <?php //flash('order_create_success');
                    //flash('item_remove_success');
                    //flash('item_remove_fail');
                    ?>
                    <h4 class="mb-0">Order View</h4>
                    <a href="/admin/orders" class="btn btn-danger float-end">Back</a>
                </div>
                <div class="card-body">
                    <!-- data if start -->
                    <?php if ($data): ?>
                        <div class="card card-body shadow border-1 mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Order Details</h4>
                                    <label class="mb-1">
                                        Tracking No: <span class="fw-bold"><?= $data->tracking_no; ?></span>
                                    </label>
                                    <br>
                                    <label class="mb-1">
                                        Order Date: <span class="fw-bold"><?= $data->order_date; ?></span>
                                    </label>
                                    <br>
                                    <label class="mb-1">
                                        Order status: <span class="fw-bold"><?= $data->order_status; ?></span>
                                    </label>
                                    <br>
                                    <label class="mb-1">
                                        Payment Mode: <span class="fw-bold"><?= $data->payment_mode; ?></span>
                                    </label>
                                    <br>
                                </div>
                                <div class="col-md-6">
                                    <h4>User Details</h4>
                                    <label class="mb-1">
                                        Full Name: <span class="fw-bold"><?= $data->name; ?></span>
                                    </label>
                                    <br>
                                    <label class="mb-1">
                                        Email Address: <span class="fw-bold"><?= $data->email; ?></span>
                                    </label>
                                    <br>
                                    <label class="mb-1">
                                        Phone Number: <span class="fw-bold"><?= $data->phnumber; ?></span>
                                    </label>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <!-- product if start -->
                        <?php if ($productDatas): ?>
                            <h4 class="my-3">Order Items Details</h4>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="fw-bold text-center">Product</th>
                                        <th class="fw-bold text-center">Image</th>
                                        <th class="fw-bold text-center">Price</th>
                                        <th class="fw-bold text-center">Quantity</th>
                                        <th class="fw-bold text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php //dd($productDatas); 
                                    ?>
                                    <?php foreach ($productDatas as $productData): ?>
                                        <tr>
                                            <td class="fw-bold text-center"><?= $productData->name; ?></td>
                                            <td><img src="<?= $productData->image != '' ? '/app/resources/uploads/' . $productData->image : ''; ?>" height='50px' width='50px'></td>
                                            <td width="15%" class="fw-bold text-center"><?= number_format($productData->price, 0); ?></td>
                                            <td width="15%" class="fw-bold text-center"><?= number_format($productData->quantity, 0); ?></td>
                                            <td width="15%" class="fw-bold text-center"><?= number_format($productData->price * $productData->quantity, 0); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td class="text-end fw-bold">Total Price:</td>
                                        <td colspan="4" class="text-end fw-bold"><?= number_format($productData->total_amount, 0); ?> Kyat</td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h5>No product founds</h5>
                        <?php endif; ?>
                        <!-- product if end -->
                    <?php else: ?>
                        <h5>No order found</h5>
                    <?php endif; ?>
                    <!-- data if end -->
                </div>
            </div>
        </div>

        <?php require_once APPROOT . "/views/admin/inc/footer.php"; ?>