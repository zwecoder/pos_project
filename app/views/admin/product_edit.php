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
                    <?= flash('product_update_fail'); ?>
                    <h4 class="mb-0">Edit Product</h4>
                    <a href="/admin/product_view" class="btn btn-danger float-end">Back</a>
                </div>
                <div class="card-body">
                    <form action="/admin/product_edit/<?= $data['id'] ?? ''; ?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Select Category*</label>
                                <select name="cat_id" class="form-select <?= !empty($data['cat_id_err']) ? 'is-invalid' : ''; ?>">
                                    <option value="">Select Category</option>
                                    <?php foreach ($cats as $cat): ?>
                                        <?php if ($cat->id === $data['category_id']): ?>
                                            <option value="<?= $cat->id; ?>" selected><?= $cat->name; ?></option>
                                        <?php else: ?>
                                            <option value="<?= $cat->id; ?>"><?= $cat->name; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <!-- <option value=""></option> -->
                                </select>
                                <div class="invalid-feedback"><?= !empty($data['cat_id_err']) ? $data['cat_id_err'] : ''; ?> </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Product Name*</label>
                                <input type="text" name="name" class="form-control <?= !empty($data['name_err']) ? 'is-invalid' : ''; ?>" value="<?= $data['name']; ?>" />
                                <div class="invalid-feedback"><?= !empty($data['name_err']) ? $data['name_err'] : ''; ?> </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Description*</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="description" rows="3"><?= $data['description']; ?></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="">Price *</label>
                                <input type="text" name="price" class="form-control <?= !empty($data['price_err']) ? 'is-invalid' : ''; ?>" value="<?= $data['price']; ?>" />
                                <div class="invalid-feedback"><?= !empty($data['price_err']) ? $data['price_err'] : ''; ?> </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="">Quantity *</label>
                                <input type="number" name="quantity" class="form-control <?= !empty($data['quantity_err']) ? 'is-invalid' : ''; ?>" value="<?= $data['quantity']; ?>" />
                                <div class="invalid-feedback"><?= !empty($data['quantity_err']) ? $data['quantity_err'] : ''; ?> </div>
                            </div>
                            <div class="col-md-12 my-3 w-25">
                                <img id="img" src="<?= '/app/resources/uploads/' . $data['image'] ?? ''; ?>" class="rounded-0 img-fluid" alt="..." height='200px' width='300px'>
                            </div>
                            <div class="mb-3">
                                <label for="">Image *</label>
                                <input type="file" name="file" class="form-control <?= !empty($data['file_err']) ? 'is-invalid' : ''; ?>" id="imgfile" />
                                <input type="hidden" class="form-control" id="oldfile" name="oldfile" value="<?= $data['image'] ?? ''; ?>">
                                <div class="invalid-feedback"><?= !empty($data['file_err']) ? $data['file_err'] : ''; ?> </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" name="status" <?= $data['status'] == true ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="flexCheckChecked">
                                        status (check=Visible,uncheck=Hidden)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" name="editproduct" class="btn btn-primary float-end">Edit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php require_once APPROOT . "/views/admin/inc/footer.php"; ?>

        <script type="text/javascript">
            let img = document.getElementById('img');
            let input = document.getElementById('imgfile');

            input.onchange = (e) => {
                if (input.files[0]) {
                    img.src = URL.createObjectURL(input.files[0]);
                }
            };
        </script>