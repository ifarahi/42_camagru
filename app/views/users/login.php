<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="co-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
        <?php if (!empty($data['email_verification'])) {
        if ($data['email_verification'] == 'alert-success'){
            echo '<div class="alert ' . $data['email_verification'] . '" role="alert"> Your account is now activated you can login </div> ';
        }
        if ($data['email_verification'] == 'alert alert-success'){
            echo '<div class="' . $data['email_verification'] . '" role="alert"> An email has been sent to set new password </div> ';
        }
        if ($data['email_verification'] == 'alert-danger'){
            echo '<div class="alert ' . $data['email_verification'] . '" role="alert"> Somthing went wrong! </div> ';
        }
        if ($data['email_verification'] == 'alert alert-danger'){
            echo '<div class="' . $data['email_verification'] . '" role="alert"> Your account is not activated yet check your email! </div> ';
        }
        if ($data['email_verification'] == 'class="alert alert-danger'){
            echo '<div ' . $data['email_verification'] . '" role="alert"> Incorrect password or username! </div> ';
        }
        if ($data['email_verification'] == 'alert-info'){
            echo '<div class="alert ' . $data['email_verification'] . '" role="alert"> Check your email to confirm you registration </div> ';
        }    
        }
        if (!empty($data['notification'])){
            echo '<div class="alert alert-success" role="alert"> ' . $data['notification'] . ' </div> ';
        }
        ?>
        <h2 class="mb-3">Login</h2>
        <form action="<?php echo URLROOT; ?>/users/login" method="post">
            <div class="form-group">
            <label for="username">Username: <sup>*</sup></label>
            <input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($data['username_error'])) ? 'is-invalid' : ''; ?>" value="">
            <span class="invalid-feedback"><?php echo $data['username_error']; ?></span>
            </div>
            <div class="form-group">
            <label for="password">Password: <sup>*</sup></label>
            <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_error'])) ? 'is-invalid' : ''; ?>" value="">
            <span class="invalid-feedback"><?php echo $data['password_error']; ?></span>
            </div>
            <div class="row">
                <div class="col">
                <input type="submit" value="Login" class="btn btn-success btn-block">
                </div>
                <br >
            </div>
            <div class="row mt-3">
                <div class="col">
                    <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-light btn-block">No account ? Register</a>
                </div>
                <div class="col">
                    <a href="<?php echo URLROOT; ?>/users/forgetpassword" class="btn btn-light btn-block">Forget password?</a>
                </div>
            </div>
        </form>
        </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>