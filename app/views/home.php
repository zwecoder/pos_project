<?php
require_once(APPROOT . "/views/inc/header.php");
require_once(APPROOT . "/views/inc/nav.php");
?>
<style>

</style>
<div class="py-5 bg-image">
    <?= flash('admin_logout'); ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 py-5 text-center">
                <!-- form start -->
                <div class="box">
                    <h2>Login</h2>
                    <form action="">
                        <div class="inputBox">
                            <input type="text" name="" required="">
                            <label for="">Username</label>
                        </div>
                        <div class="inputBox">
                            <input type="password" name="" required="">
                            <label for="">Password</label>
                        </div>
                        <input type="submit" name="" value="Submit">
                    </form>
                </div>
                <!-- form end -->
            </div>
        </div>
    </div>
</div>

<?php require_once(APPROOT . "/views/inc/footer.php"); ?>