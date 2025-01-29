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
                    <?php flash('customer_create_success');
                    //   flash('register_fail');
                    flash('customer_update_success');
                    flash('customer_Deleted_success');
                    flash('customer_Deleted_fail');
                    ?>
                    <h4 class="mb-0">Customers</h4>
                    <a href="customer_create" class="btn btn-primary float-end">Add Customer</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Ph:</th>
                                    <th>Is_Ban</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customers as $customer): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($customer->id); ?></td>
                                        <td><?= htmlspecialchars($customer->name); ?></td>
                                        <td><?= htmlspecialchars($customer->email); ?></td>
                                        <td><?= htmlspecialchars($customer->phnumber); ?></td>
                                        <td>
                                            <h5><span class="badge text-bg-primary"><?= htmlspecialchars($customer->is_ban) ? 'banned' : 'active'; ?></span></h5>
                                        </td>
                                        <td>
                                            <a href="customer_edit/<?= $customer->id; ?>" class="btn btn-success btn-sm">Edit</a>
                                            <a href="customer_delete/<?= $customer->id; ?>" class="btn btn-danger btn-sm" onclick="confirm();">Delete</a>
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
            function confirm() {
                alert("are you sure want to delete!");
            }
        </script>