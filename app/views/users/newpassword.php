<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="co-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
        <h2 class="mb-4">Enter new password</h2>
        <form action="<?php echo URLROOT; ?>/users/newpassword/<?php echo $data['token']; ?>" method="post">
            <div class="form-group">
            <label for="email">New password: <sup>*</sup></label>
            <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_error'])) ? 'is-invalid' : ''; ?>" value="">
            <span class="invalid-feedback"><?php echo $data['password_error']; ?></span>
            </div>
            <div class="form-group">
            <label for="password">Confirm new password: <sup>*</sup></label>
            <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['password_m_error'])) ? 'is-invalid' : ''; ?> " value="">
            <span class="invalid-feedback"><?php echo $data['password_m_error']; ?></span>
            </div>
            <div class="row">
                <div class="col mb-3 mt-2">
                <input type="submit" value="Save" class="btn btn-success btn-block">
                </div>
                <br >
            </div>
        </form>
        </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
