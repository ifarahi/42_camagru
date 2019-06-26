<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="co-md-6 mx-auto p-15">
<div class="card card-body bg-light mt-5 p-15">
<?php
if (!empty($data['success_personal'])){
            echo '<div class="alert alert-success" role="alert"> ' . $data['success_personal'] . ' </div> ';
        }
?>
<form action="<?php echo URLROOT; ?>/users/setting" method="post">
<h3>Personal information</h3>
  <div class="form-group">
    <label for="exampleInputEmail1">Name:</label>
    <input type="text" name="name" class="form-control <?php echo (!empty($data['name_error'])) ? 'is-invalid' : ''; ?>"  value="<?php echo $_SESSION['name'];?>">
    <span class="invalid-feedback"><?php echo $data['name_error']; ?></span>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Username:</label>
    <input type="text" name="username" class="form-control <?php echo (!empty($data['username_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $_SESSION['username'];?>">
    <span class="invalid-feedback"><?php echo $data['username_error']; ?></span>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address:</label>
    <input type="text" name="email" class="form-control <?php echo (!empty($data['email_error'])) ? 'is-invalid' : ''; ?>"  value="<?php echo $_SESSION['email'];?>">
    <span class="invalid-feedback"><?php echo $data['email_error']; ?></span>
  </div>
  <button type="submit" name="update_personal_information" class="btn btn-success" style="width:100%">Update</button>
  </form>
</div>
</div>
<hr>
<div class="co-md-6 mx-auto p-15">
<div class="card card-body bg-light mt-2 p-15">
<?php
if (!empty($data['success_password'])){
            echo '<div class="alert alert-success" role="alert"> ' . $data['success_password'] . ' </div> ';
        }
?>
<form action="<?php echo URLROOT; ?>/users/setting" method="post">
<h3>Update password</h3>
  <div class="form-group">
    <label for="exampleInputEmail1">Current password:</label>
    <input type="password" name="current_password" class="form-control <?php echo (!empty($data['current_password_error'])) ? 'is-invalid' : ''; ?>" id="exampleInputEmail1" placeholder="Current password">
    <span class="invalid-feedback"><?php echo $data['current_password_error']; ?></span>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">New password:</label>
    <input type="password" name="new_password" class="form-control <?php echo (!empty($data['new_password_error'])) ? 'is-invalid' : ''; ?>" id="exampleInputEmail1" placeholder="New password">
    <span class="invalid-feedback"><?php echo $data['new_password_error']; ?></span>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Confirm new password:</label>
    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($data['confirm_password_error'])) ? 'is-invalid' : ''; ?>" id="exampleInputEmail1" placeholder="confirm password">
    <span class="invalid-feedback"><?php echo $data['confirm_password_error']; ?></span>
  </div>
  <button type="submit" name="update_password" class="btn btn-success" style="width:100%">Update</button>
  </form>
</div>
</div>
<hr>
<div class="card card-body bg-light mt-2 p-15">
<form action="">
<h3>Email notification</h3>
<div class="input-group mb-3 mt-3">
  <div class="input-group-prepend">
    <label class="input-group-text" for="inputGroupSelect01">Recieve email notification on comments?</label>
  </div>
  <select class="custom-select" id="inputGroupSelect01">
    <option selected><?php echo ($_SESSION['email_notif'] > 0) ? 'Yes i would like to' : 'No i dont thank you';?></option>
    <option value="1">No i dont thank you</option>
  </select>
</div>
<button type="submit" class="btn btn-success" style="width:100%">Update</button>
</form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>