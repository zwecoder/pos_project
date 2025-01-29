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
                    <h4 class="mb-0">Orders</h4>
                    <a href="/admin" class="btn btn-danger float-end">Back</a>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="POST">
                        <div class="row mb-3 g-1">
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="date" value="<?= isset($date) == true ? $date : ''; ?>">
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" id="payment_mode" name="payment_mode">
                                    <option value="">Select a payment</option>
                                    <option value="Cash payment" <?= isset($payment_mode) == true ? ($payment_mode == 'Cash payment' ? 'selected' : '') : ''; ?>>Cash Payment</option>
                                    <option value="Online payment" <?= isset($payment_mode) == true ? ($payment_mode == 'Online payment' ? 'selected' : '') : ''; ?>>Online Payment</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="/admin/orders" class="btn btn-danger">Reset</a>
                            </div>
                        </div>

                    </form>
                    <!-- End Filter Form -->
                    <?php if ($orders): ?>
                        <table class="table table-striped table-bordered align-items-center justify-content-end">
                            <thead>
                                <tr>
                                    <th scope="col">Tracking No.</th>
                                    <th scope="col">CustomerName.</th>
                                    <th scope="col">Customer_Ph.</th>
                                    <th scope="col">Order Date</th>
                                    <th scope="col">Order Status</th>
                                    <th scope="col">Payment Mode</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php //dd($orders); 
                                ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td class="fw-bold"><?= $order->tracking_no; ?></td>
                                        <td><?= $order->name; ?></td>
                                        <td><?= $order->phnumber; ?></td>
                                        <td><?= $order->order_date; ?></td>
                                        <td><?= $order->order_status; ?></td>
                                        <td><?= $order->payment_mode; ?></td>
                                        <td>
                                            <a href="/admin/order_view/<?= $order->tracking_no; ?>" class="btn btn-info mb-0 px-2 btn-sm">View</a>
                                            <a href="/admin/order_view_print/<?= $order->tracking_no; ?>" class="btn btn-primary mb-0 px-2 btn-sm">Print</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <h5>No record found</h5>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php require_once APPROOT . "/views/admin/inc/footer.php"; ?>