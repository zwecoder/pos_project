<?php
require_once APPROOT . "/views/admin/inc/header.php";
require_once APPROOT . "/views/admin/inc/nav.php";
?>

<div id="layoutSidenav">
    <?php require_once APPROOT . "/views/admin/inc/sidebar.php"; 
    ?>
    <div id="layoutSidenav_content">


    
        <!-- drop Modal start -->
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="addCustomerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Customer</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Enter Customer Name</label>
                            <input type="text" class="form-control" id="c_name">
                        </div>
                        <div class="mb-3">
                            <label>Enter Customer Phone No.</label>
                            <input type="number" class="form-control" id="c_phone">
                        </div>
                        <div class="mb-3">
                            <label>Enter Customer Email (optional)</label>
                            <input type="email" class="form-control" id="c_email">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveCustomer">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- drop modal end -->



        <div class="container-fluid px-4">
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <?php flash('order_create_success');
                    flash('item_remove_success');
                    flash('item_remove_fail');
                    ?>
                    <h4 class="mb-0">Create Order</h4>
                    <a href="/admin" class="btn btn-danger float-end">Back</a>
                </div>
                <div class="card-body">
                    <form action="order_create" method="POST">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="">Select Product*</label>
                                <select name="product_id" class="form-select myselect2 <?= !empty($data['product_id_err']) ? 'is-invalid' : ''; ?>">
                                    <option value="">----Select Product----</option>
                                    <?php foreach ($products as $product): ?>
                                        <option value="<?= $product->id; ?>"><?= $product->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback"><?= !empty($data['product_id_err']) ? $data['product_id_err'] : ''; ?> </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="">Quantity*</label>
                                <input type="number" min="1" name="quantity" class="form-control <?= !empty($data['quantity_err']) ? 'is-invalid' : ''; ?>" value="1" />
                                <div class="invalid-feedback"><?= !empty($data['quantity_err']) ? $data['quantity_err'] : ''; ?> </div>
                            </div>


                            <div class="col-md-6 mb-3">
                                <br>
                                <button type="submit" name="addOrder" class="btn btn-primary float-end">Add Item</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="mb-0">Products</h4>
                </div>
                <div class="card-body" id="productArea">

                    <?php if (isset($_SESSION['productItems'])): ?>
                        <?php $sessionProducts = $_SESSION['productItems'];
                        if (empty($sessionProducts)) {
                            unset($_SESSION['productItemsId']);
                            unset($_SESSION['productItems']);
                        }
                        ?>
                        <div class="table-responsive mb-3" id="productContent">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total Price</th>
                                        <th scope="col">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($sessionProducts as $key => $value): ?>
                                        <tr>
                                            <th scope="row"><?= 1 + $key; ?></th>
                                            <td><?= $value['name']; ?></td>
                                            <td><?= $value['price']; ?></td>
                                            <td>
                                                <div class="input-group qtyBox" id="qtyBox">
                                                    <input type="hidden" name="" class="proId" id="proId" value="<?= $value['product_id']; ?>">
                                                    <button class="input-group-text decrement" id="decrement">-</button>
                                                    <input type="text" class="quantityInput qty" id="qty" value="<?= $value['quantity']; ?>">
                                                    <button class="input-group-text increment" id="increment">+</button>
                                                </div>
                                            </td>
                                            <td><?= number_format($value['price'] * $value['quantity']); ?></td>
                                            <td><a href="order_Delete/<?= $key; ?>" class="btn btn-danger btn-sm">Remove</a></td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                        <!-- customer payment check start-->
                        <div class="mt-2" id="productContent">
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Select Payment Method*</label>
                                    <select id="payment_mode" id="payment_mode" class="form-select">
                                        <option value="">----Select Payment---</option>
                                        <option value="Cash Payment">Cash Payment</option>
                                        <option value="Online Payment">Online Payment</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="">Enter Customer Phone No*</label>
                                    <input type="number" name="cphone" id="cphone" class="form-control" value="">
                                </div>
                                <div class="col-md-4">
                                    <br>
                                    <button class="btn btn-warning w-100" id="processToPlace">Process to place order </button>
                                    <!-- <a href="/order_payment" class="btn btn-warning w-100" id="processToPlace">Process to place order</a> -->
                                </div>
                            </div>
                        </div>
                        <!-- customer payment check end-->

                    <?php else: ?>
                        <h5>No Item added </h5>
                    <?php endif; ?>

                </div>

            </div>
        </div>

        <?php require_once APPROOT . "/views/admin/inc/footer.php"; ?>