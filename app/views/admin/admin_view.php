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
                    <?php flash('register_success');
                          flash('register_fail');
                          flash('admin_update_success');
                          flash('admin_Deleted_success');
                          flash('admin_Deleted_fail');
                    ?>
                    <h4 class="mb-0">Admins/Staff</h4>
                    <a href="ad_create" class="btn btn-primary float-end">Add admin</a>
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
                                <?php foreach ($admins as $admin): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($admin->id); ?></td>
                                        <td><?= htmlspecialchars($admin->name); ?></td>
                                        <td><?= htmlspecialchars($admin->email); ?></td>
                                        <td><?= htmlspecialchars($admin->phnumber); ?></td>
                                        <td>
                                            <h5><span class="badge text-bg-primary"><?= htmlspecialchars($admin->is_ban) ? 'banned' : 'active'; ?></span></h5>
                                        </td>
                                        <td>
                                            <a href="ad_edit/<?= $admin->id; ?>" class="btn btn-success btn-sm">Edit</a>
                                            <a href="ad_delete/<?= $admin->id; ?>" class="btn btn-danger btn-sm">Delete</a>
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