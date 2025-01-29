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
                    <?php flash('customer_create_fail');?>
                    <h4 class="mb-0">Add Customer</h4>
                    <a href="/admin/customer_view" class="btn btn-danger float-end">Back</a>
                </div>
                <div class="card-body">
                    <form action="customer_create" method="POST">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Name*</label>
                                <input type="text" name="name" class="form-control <?= !empty($data['name_err']) ? 'is-invalid' : ''; ?>" />
                                <div class="invalid-feedback"><?= !empty($data['name_err']) ? $data['name_err'] : ''; ?> </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="">Email*</label>
                                <input type="email" name="email" class="form-control <?= !empty($data['email_err']) ? 'is-invalid' : ''; ?>" />
                                <div class="invalid-feedback"><?= !empty($data['email_err']) ? $data['email_err'] : ''; ?></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Phone*</label>
                                <input type="tel" name="phnumber" class="form-control <?= !empty($data['phnumber_err']) ? 'is-invalid' : ''; ?>" />
                                <div class="invalid-feedback"><?= !empty($data['phnumber_err']) ? $data['phnumber_err'] : ''; ?></div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="">Is Ban</label>
                                <input type="checkbox" name="is_ban" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" name="addname" class="btn btn-primary float-end">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php require_once APPROOT . "/views/admin/inc/footer.php"; ?>