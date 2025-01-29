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
                    <h4 class="mb-0">Add Category</h4>
                    <a href="/admin/cat_view" class="btn btn-danger float-end">Back</a>
                </div>
                <div class="card-body">
                    <form action="cat_create" method="POST">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Name*</label>
                                <input type="text" name="name" class="form-control <?= !empty($data['name_err']) ? 'is-invalid' : ''; ?>" />
                                <div class="invalid-feedback"><?= !empty($data['name_err']) ? $data['name_err'] : ''; ?> </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Description*</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="description" rows="3"></textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" name="status" checked>
                                    <label class="form-check-label" for="flexCheckChecked">
                                        status (check=Visible,uncheck=Hidden)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" name="addcat" class="btn btn-primary float-end">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php require_once APPROOT . "/views/admin/inc/footer.php"; ?>