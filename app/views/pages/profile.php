<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
  <div class="col-lg-3 mb-5 mt-4 ">
        <canvas id="canvas" class="w-100" style="display: none;" width="500" height="400"></canvas>
        <img id="card-profile-image" src="<?php echo $_SESSION['profile_img']; ?>" class="card-img" alt="...">
        <input id="upload-profile-picture" type="file" class="custom-file-input" accept=".png, .jpg" id="imageloader" name="imageloader" value="upload">
    </div>
    <div class="col-lg-6 mb-5 mt-5">
            <h5 class="card-title"><?php echo ucfirst($_SESSION['username']);?></h5>
            <p class="card-text">Posts : <B><?php echo $this->postsNumber($_SESSION['user_id'])->number; ?></B>
            </p>
            <button id="uploadbutton" type="submit" class="btn btn-info"><i class="fas fa-camera"></i> Change profile picture </button>
    </div>
</div>
<hr class="mt-3 mb-3">
<div class="row">
<?php
  if ($data) {
  foreach($data as $img) :
?>
  <div class="col-lg-4 mb-5">
    <div class="card">
      <img src="<?php echo URLROOT .'/' . $img->image_url; ?>" alt="test" class="w-100">
      <div class="card-body">
        <p class="card-text">
        <i class="far fa-heart"></i> <?php echo $this->imageLikesNumber($img->id)->number; ?>
        &nbsp;&nbsp;
        <i class="far fa-comment"></i> <?php echo $this->imageCommentsNumber($img->id)->number; ?> 
        </p>
      </div>
    </div>
  </div>
<?php 
  endforeach; 
  };
?>
</div>
<script src="<?php echo URLROOT; ?>/public/js/profile.js"></script>
<?php require APPROOT . '/views/inc/footer.php'; ?>