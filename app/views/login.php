<?php
require_once(APPROOT . "/views/inc/header.php");
require_once(APPROOT . "/views/inc/nav.php");
?>
<?php if(getUserSession()): ?>
<script>
window.location.href='/';
</script>
<?php endif; ?>
<div class="py-5">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow rounded-4">
                    <div class="p-5">
                        <h4>Sign into Our POS system</h4>
                        <?= flash("banned_user"); ?>
                        <form action="login" method="POST">
                            <div class="mb-3">
                                <label>Enter Email :</label>
                                <input type="email" class="form-control <?= !empty($data['email_err']) ? 'is-invalid' : ''; ?>" name="email" />
                                <div class="invalid-feedback"><?= !empty($data['email_err']) ? $data['email_err'] : ''; ?></div>
                            </div>
                            <div class="mb-3">
                                <label>Enter Password :</label>
                                <input type="password" class="form-control <?= !empty($data['password_err']) ? 'is-invalid' : ''; ?>" name="password" />
                                <div class="invalid-feedback"><?= !empty($data['password_err']) ? $data['password_err'] : ''; ?></div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary" name="loginBtn">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once(APPROOT . "/views/inc/footer.php"); ?>