<?php
require_once APPROOT . "/views/admin/inc/header.php";
require_once APPROOT . "/views/admin/inc/nav.php";
?>

<div id="layoutSidenav">
    <?php require_once APPROOT . "/views/admin/inc/sidebar.php"; ?>
    <div id="layoutSidenav_content">

        <div class="container-fluid px-4">
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <?php flash('product_create_success');
                    flash('product_create_fail');
                    flash('product_update_success');
                    flash('product_Deleted_success');
                    flash('product_Deleted_fail');
                    ?>
                    <h4 class="mb-0">Products</h4>
                    <a href="product_create" class="btn btn-primary float-end">Add Product</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>price</th>
                                    <th>quantity</th>
                                    <th>image</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($product->id); ?></td>
                                        <td><?= htmlspecialchars($product->name); ?></td>
                                        <td><?= htmlspecialchars($product->price); ?></td>
                                        <td><?= htmlspecialchars($product->quantity); ?></td>
                                        <td><img src="<?= '/app/resources/uploads/' . $product->image; ?>" height='30px' width='40px'></td>
                                        <td>
                                            <h5><span class="badge text-bg-primary"><?= htmlspecialchars($product->status) ? 'visible' : 'hidden'; ?></span></h5>
                                        </td>
                                        <td>
                                            <a href="product_edit/<?= $product->id; ?>" class="btn btn-success btn-sm">Edit</a>
                                            <a href="product_delete/<?= $product->id; ?>" class="btn btn-danger btn-sm" onclick="confirm();">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php require_once APPROOT . "/views/admin/inc/footer.php"; ?>
        <script>
            function confirm(){
                alert("are you sure want to delete!");
            }
        </script>