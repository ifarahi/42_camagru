<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="co-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
        <?php if (!empty($data['email_notif'])) {
        if ($data['email_notif'] == 'alert-success'){
            echo '<div class="alert ' . $data['email_notif'] . '" role="alert"> Your account is now activated you can login </div> ';
        }
        if ($data['email_notif'] == 'alert-danger'){
            echo '<div class="alert ' . $data['email_notif'] . '" role="alert">This account does not exists! </div> ';
        }
        if ($data['email_notif'] == 'alert alert-danger'){
            echo '<div class="' . $data['email_notif'] . '" role="alert"> Your account is not activated yet check your email! </div> ';
        }
        if ($data['email_notif'] == 'class="alert alert-danger'){
            echo '<div ' . $data['email_notif'] . '" role="alert"> Incorrect password or email! </div> ';
        }
        if ($data['email_notif'] == 'alert-info'){
            echo '<div class="alert ' . $data['email_notif'] . '" role="alert"> Check your email to confirm you registration </div> ';
        }
        }
        ?>
        <h2 class="mb-3">Please enter your acount email</h2>
        <form action="<?php echo URLROOT; ?>/users/forgetpassword" method="post">
            <div class="form-group">
            <label for="email">Email: <sup>*</sup></label>
            <input type="text" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
            <span class="invalid-feedback"><?php echo $data['email_error']; ?></span>
            </div>
            <div class="row">
                <div class="col">
                <input type="submit" value="Send verification Email" class="btn btn-success btn-block">
                </div>
                <br >
            </div>
        </form>
        </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>