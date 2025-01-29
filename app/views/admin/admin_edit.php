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
                    <?php flash('admin_update_fail');?>
                    <h4 class="mb-0">Edit Admin</h4>
                    <a href="/admin/ad_view" class="btn btn-primary float-end">Back</a>
                </div>
                <div class="card-body">
                    <form action="/admin/ad_edited/<?= $data['id']; ?>" method="POST">
                        <div class="row">
                            <div class="col-md-12 mb-3">

                                <label for="">Name*</label>
                                <input type="text" name="name" class="form-control <?= !empty($data['name_err']) ? 'is-invalid' : ''; ?>" value="<?= $data['name']; ?>" />
                                <div class="invalid-feedback"><?= !empty($data['name_err']) ? $data['name_err'] : ''; ?> </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="">Email*</label>
                                <input type="email" name="email" class="form-control <?= !empty($data['email_err']) ? 'is-invalid' : ''; ?>" value="<?= $data['email']; ?>" />
                                <div class="invalid-feedback"><?= !empty($data['email_err']) ? $data['email_err'] : ''; ?></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Phone*</label>
                                <input type="tel" name="phnumber" class="form-control <?= !empty($data['phnumber_err']) ? 'is-invalid' : ''; ?>" value="<?= $data['phnumber']; ?>" />
                                <div class="invalid-feedback"><?= !empty($data['phnumber_err']) ? $data['phnumber_err'] : ''; ?></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Password*</label>
                                <input type="password" name="password" class="form-control <?= !empty($data['password_err']) ? 'is-invalid' : ''; ?>" />
                                <div class="invalid-feedback"><?= !empty($data['password_err']) ? $data['password_err'] : ''; ?></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Comfirm Password*</label>
                                <input type="password" name="comfirm_password" class="form-control <?= !empty($data['comfirm_password_err']) ? 'is-invalid' : ''; ?>" />
                                <div class="invalid-feedback"><?= !empty($data['comfirm_password_err']) ? $data['comfirm_password_err'] : ''; ?></div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Is Ban</label>
                                <input type="checkbox" name="is_ban" <?= $data['is_ban'] == true ? 'checked' : ''; ?> style="width:30px;height: 30px;" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" name="savename" class="btn btn-primary float-end">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php require_once APPROOT . "/views/admin/inc/footer.php"; ?>