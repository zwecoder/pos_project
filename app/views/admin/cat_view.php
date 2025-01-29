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
                    <?php flash('cat_create_success');
                    flash('cat_create_fail');
                    flash('cat_update_success');
                    flash('cat_Deleted_success');
                    flash('cat_Deleted_fail');
                    ?>
                    <h4 class="mb-0">Categories</h4>
                    <a href="cat_create" class="btn btn-primary float-end">Add category</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Name</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cats as $cat): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($cat->id); ?></td>
                                        <td><?= htmlspecialchars($cat->name); ?></td>
                                        <td>
                                            <h5><span class="badge text-bg-primary"><?= htmlspecialchars($cat->status) ? 'visible' : 'hidden'; ?></span></h5>
                                        </td>
                                        <td>
                                            <a href="cat_edit/<?= $cat->id; ?>" class="btn btn-success btn-sm">Edit</a>
                                            <a href="cat_delete/<?= $cat->id; ?>" class="btn btn-danger btn-sm">Delete</a>
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