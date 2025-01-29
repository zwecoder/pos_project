<?php
require_once(APPROOT . "/views/inc/header.php");
require_once(APPROOT . "/views/inc/nav.php");
?>
<div class="py-5">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <?php foreach ($insertData as $user) : ?>
                    <li><?= $user->name . " age is " . $user->age; ?></li>
                <?php endforeach; ?>
                <a href="login.php" class="btn btn-primary mt-4">Login</a>
            </div>
        </div>
    </div>
</div>

<?php require_once(APPROOT . "/views/inc/footer.php"); ?>