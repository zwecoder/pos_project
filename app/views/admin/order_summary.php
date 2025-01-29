<?php
require_once APPROOT . "/views/admin/inc/header.php";
require_once APPROOT . "/views/admin/inc/nav.php";

?>

<div id="layoutSidenav">
    <?php require_once APPROOT . "/views/admin/inc/sidebar.php";
    ?>
    <div id="layoutSidenav_content">
        <!-- drop Modal start -->
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="orderSuccessModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="mb3 p-4">
                            <h5 id="orderPlaceSuccessMessage"></h5>
                        </div>

                        <a href="/admin/orders" class="btn btn-secondary">Close</a>
                        <button type="button" class="btn btn-danger" onclick="printMyBillingArea()">print</button>
                        <button type="button" class="btn btn-primary" onclick="downloadPDF('<?= $data['invoiceNo']; ?>')">Download PDF</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- drop modal end -->





        <div class="container-fluid px-4 py-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Order summary
                                <a href="/admin/order_create" class="btn btn-warning float-end">Back to Create order</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <?php //alert_Message(); 
                            ?>

                            <div id="myBillingArea">
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
                                                <p style="font-size: 14px; line-height: 20px; margin: 0px; padding:0;">Customer Name: <?= $data['name']; ?></p>
                                                <p style="font-size: 14px; line-height: 20px; margin: 0px; padding:0;">Customer Phone No: <?= $data['phnumber']; ?></p>
                                                <p style="font-size: 14px; line-height: 20px; margin: 0px; padding:0;">Customer Email: <?= $data['email']; ?></p>
                                            </td>
                                            <td align="end">
                                                <h5 style="font-size: 20px; line-height: 30px; margin: 0px; padding:0;">Invoice Details</h5>
                                                <p style="font-size: 14px; line-height: 20px; margin: 0px; padding:0;">Invoice No: <?= $data['invoiceNo']; ?></p>
                                                <p style="font-size: 14px; line-height: 20px; margin: 0px; padding:0;">Invoice Date: <?= date('d-m-Y'); ?></p>
                                                <p style="font-size: 14px; line-height: 20px; margin: 0px; padding:0;">Address </p>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                                <?php if (isset($_SESSION['productItems'])): ?>

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
                                                $totalAmount = 0;
                                                foreach ($data['sessionProducts'] as $key => $value):
                                                    $totalAmount += $value['price'] * $value['quantity'];
                                                ?>
                                                    <tr>
                                                        <td style="border-bottom: 1px solid #ccc;"><?= 1 + $key; ?></td>
                                                        <td style="border-bottom: 1px solid #ccc;"><?= $value['name'] ?></td>
                                                        <td style="border-bottom: 1px solid #ccc;"><?= $value['price'] ?></td>
                                                        <td style="border-bottom: 1px solid #ccc;"><?= $value['quantity'] ?></td>
                                                        <td style="border-bottom: 1px solid #ccc;"><?= number_format($value['price'] * $value['quantity'], 0); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <tr>
                                                    <td colspan="4" align="end" style="font-weight:bold;">Grand Total:</td>
                                                    <td colspan="1" style="font-weight:bold;"><?= number_format($totalAmount, 0) ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">Payment Mode: <?= urldecode($_SESSION['payment_mode']); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <h5>No Items added</h5>
                                <?php endif; ?>
                            </div>

                            <?php if (isset($_SESSION['productItems'])): ?>
                                <div class="mt-4 text-end">
                                    <button type="button" class="btn btn-primary" id="saveOrder">Save</button>
                                    <button type="button" class="btn btn-danger" onclick="printMyBillingArea()">Print</button>
                                    <button type="button" class="btn btn-warning" onclick="downloadPDF('<?= $data['invoiceNo']; ?>')">Download PDF</button>
                                    <!-- <!--   <a href="/admin/order_error_checker" class="btn btn-primary">save</a>  -->
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php require_once APPROOT . "/views/admin/inc/footer.php"; ?>