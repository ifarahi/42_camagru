<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-3">
<div class="container">
  <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
  <button id="click" onclick="displaymenu()" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item ">
        <a class="nav-link" href="<?php echo URLROOT; ?>">Gallery </a>
      </li>
      <?php if(isset($_SESSION['user_id'])) :?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT;?>/camera">Camera</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT;?>/users/setting">Setting</a>
      </li>
      <?php endif; ?>
    </ul>
    <ul class="navbar-nav ml-auto">
    <?php if(isset($_SESSION['user_id'])) :?>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT;?>/users/logout">Logout</a>
    </li>
    <li class="nav-item">
        <a class="nav-link profile-img" href="<?php echo URLROOT;?>/profile">
        <img id="nav-profile-img" src="<?php echo URLROOT .'/'.$_SESSION['profile_img']; ?>">
        </a>
    </li>
    <?php else : ?>
      <li class="nav-item ">
        <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">Register </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT;?>/users/login">Login</a>
      </li>
    <?php endif; ?>
    </ul>
  </div>
  </div>
</nav>



