<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="co-md-6 mx-auto p-15">
<div class="card card-body bg-light mt-5 p-15">
<form>
<h3>Personal information</h3>
  <div class="form-group">
    <label for="exampleInputEmail1">Full name:</label>
    <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $_SESSION['name'];?>">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Username:</label>
    <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $_SESSION['username'];?>">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address:</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $_SESSION['email'];?>">
  </div>
  <button type="submit" class="btn btn-success" style="width:100%">Update</button>
  </form>
</div>
</div>
<hr>
<div class="co-md-6 mx-auto p-15">
<div class="card card-body bg-light mt-2 p-15">
<form>
<h3>Update password</h3>
  <div class="form-group">
    <label for="exampleInputEmail1">Current password:</label>
    <input type="password" class="form-control" id="exampleInputEmail1" placeholder="Current password">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">New password:</label>
    <input type="password" class="form-control" id="exampleInputEmail1" placeholder="New password">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Confirm new password:</label>
    <input type="password" class="form-control" id="exampleInputEmail1" placeholder="confirm password">
  </div>
  <button type="submit" class="btn btn-success" style="width:100%">Update</button>
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