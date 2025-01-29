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
                    <?php

                    ?>
                    <h4 class="mb-0">Print Orders</h4>
                    <a href="/admin/orders" class="btn btn-danger float-end">Back</a>
                </div>
                <div class="card-body">
                    <div id="myBillingArea">
                        <?php if ($data): ?>
                            <table class="" style="width: 100%; margin-bottom:20px;">
                                <tbody>
                                    <tr>
                                        <td style="text-align:center" colspan="2">
                                            <h4 style="font-size: 23px; line-height: 30px; margin: 2px; padding:0;">company xyz</h4>
                                            <p style="font-size: 16px; line-height: 24px; margin: 2px; padding:0;">address</p>
                                            <p style="font-size: 16px; line-height: 24px; margin: 2px; padding:0;">company limited</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5 style="font-size: 20px; line-height: 30px; margin: 0px; padding:0;">Customer Details</h5>
                                            <p style="font-size: 14px; line-height: 20px; margin: 0px; padding:0;">Customer Name: <?= $data->name; ?></p>
                                            <p style="font-size: 14px; line-height: 20px; margin: 0px; padding:0;">Customer Phone No: <?= $data->phnumber; ?></p>
                                            <p style="font-size: 14px; line-height: 20px; margin: 0px; padding:0;">Customer Email: <?= $data->email; ?></p>
                                        </td>
                                        <td align="end">
                                            <h5 style="font-size: 20px; line-height: 30px; margin: 0px; padding:0;">Invoice Details</h5>
                                            <p style="font-size: 14px; line-height: 20px; margin: 0px; padding:0;">Invoice No: <?= $data->invoice_no; ?></p>
                                            <p style="font-size: 14px; line-height: 20px; margin: 0px; padding:0;">Invoice Date: <?= date('d-m-Y'); ?></p>
                                            <p style="font-size: 14px; line-height: 20px; margin: 0px; padding:0;">Address: No 222,yangon </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- product if start -->
                            <?php if ($productDatas): ?>
                                <h4 class="my-3">Order Items Details</h4>
                                <div class="table-responsive mb-3">
                                    <table style="width:100%" cellpadding="5">
                                        <thead>
                                            <tr>
                                                <th align="start" style="border-bottom: 1px solid #ccc;" width="5%">ID</th>
                                                <th align="start" style="border-bottom: 1px solid #ccc;">Product Name</th>
                                                <th align="start" style="border-bottom: 1px solid #ccc;" width="10%">price</th>
                                                <th align="start" style="border-bottom: 1px solid #ccc;" width="10%">Quantity</th>
                                                <th align="start" style="border-bottom: 1px solid #ccc;" width="15%">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $totalAmount = 0;
                                            //dd($productDatas);
                                            foreach ($productDatas as $productData):
                                                //$totalAmount += $productData->price * $productData->quantity;
                                            ?>
                                                <tr>
                                                    <td style="border-bottom: 1px solid #ccc;"><?= $i++; ?></td>
                                                    <td style="border-bottom: 1px solid #ccc;"><?= $productData->name; ?></td>
                                                    <td style="border-bottom: 1px solid #ccc;"><?= $productData->price ?></td>
                                                    <td style="border-bottom: 1px solid #ccc;"><?= $productData->quantity ?></td>
                                                    <td style="border-bottom: 1px solid #ccc;"><?= number_format($productData->price * $productData->quantity, 0); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td colspan="4" align="end" style="font-weight:bold;">Grand Total:</td>
                                                <td colspan="1" style="font-weight:bold;"><?= number_format($productData->total_amount, 0) ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">Payment Mode: <?= $productData->payment_mode; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <h5>No products found</h5>
                            <?php endif; ?>
                            <!-- product if end -->
                        <?php else: ?>
                            <h5>no order found</h5>
                        <?php endif; ?>
                    </div>

                    <div class="mt-4 text-end">
                        <button class="btn btn-warning px-4 mx-1" onclick="printMyBillingArea()">Print</button>
                        <button class="btn btn-primary px-4 mx-1" onclick="downloadPDF('<?= $data->invoice_no; ?>')">Download</button>
                    </div>
                </div>
            </div>
        </div>

        <?php require_once APPROOT . "/views/admin/inc/footer.php"; ?>