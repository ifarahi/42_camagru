<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <?php
        if ($data[4] != false) {
        foreach($data[0] as $img) : 
        $creation_date = date( 'd M H:i', strtotime($img->date));
        ?>
        <div class="col-md-8 mx-auto">
            <div class="card mb-5 border-gray">
                <div class="card-header">
                    <img class="gall-profile" src="<?php echo URLROOT .'/'.$img->profile_img; ?>">
                    <B><?php echo $img->username;?></B><span style="float: right;"><?php echo $creation_date.' ';?><i class="fas fa-clock"></i></span>
                </div>
                    <img class="w-100" src="<?php echo URLROOT .'/' . $img->image_url; ?>">
                    <div class="card-body mb-4">
                        <form id="likes" action="#" class="form-group" method="post">
                        <div class="button-container">
                            <?php
                            if (isLoggedIn()) {
                                $info = ['user_id' => $_SESSION['user_id'], 'image_id' => $img->image_id];
                                if ($this->showLikeState($info) == 'ON')
                                echo '<button id="btn-'.$img->image_id.'" type="submit" class="mb-2 btn btn-danger btn-sm" name="like"><i class="far fa-thumbs-down"></i>  ';
                                else if ($this->showLikeState($info) == 'OFF' || $this->showLikeState($info) == false)
                                    echo '<button id="btn-'.$img->image_id.'" type="submit" class="mb-2 btn btn-success btn-sm" name="like"><i class="far fa-thumbs-up"></i> ';
                            }
                            ?>
                        
                            <span id="like-number-<?php echo $img->image_id;?>" class="badge badge-light ml-2">
                                <?php if(!isLoggedIn()){echo '<i class="fas fa-heart"></i>';}?>
                                <?php echo $this->showNumberOFLikes($img->image_id); ?>
                            </span>
                            </div>
                            </button>
                            <input type="hidden" name="image_id" value="<?php echo $img->image_id?>">
                        </form>
                        <form id="comment" action="#" class="form-group" method="post">
                            <div class="media d-flex align-items-center">
                                <div class="media-body " <?php if(!isLoggedIn()){echo 'style="display: none;"';}?>>
                                    <input type="text" id="inputcom" class="form-control form-control-sm card-text" name="comment" >
                                    <input type="hidden" name="image_id" value="<?php echo $img->image_id?>">
                                </div>
                                <div class="media-right" <?php if(!isLoggedIn()){echo 'style="display: none;"';}?>>
                                    <button type="submit" class="btn btn-dark ml-4">Comment</button>
                                </div>
                            </div>
                            <div class="mt-4">
                                <ul id="commentList-<?php echo $img->image_id ?>" class="list-group">
                                    <?php
                                        if ($data[1]){
                                        foreach($data[1] as $comment){
                                            if ($img->image_id == $comment->image_id){
                                                $url = URLROOT .'/'.$this->getProfileImage($comment->user_id);
                                                echo '
                                                <li class="list-group-item d-flex align-items-center">
                                                <img class="gall-profile" src="'. $url .'">&nbsp;&nbsp;
                                                <span class="badge badge-info badge-pill mr-3">'.$this->getUsername($comment->user_id).'</span>
                                                '. $comment->comment .' 
                                                </li>
                                                
                                                ';
                                            };
                                        };
                                        };
                                    ?>
                                </ul>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php 
                    $i = 1;
                    $url = URLROOT . '/gallery/index/';
                    if ($data[3] > 1)
                        while ($i <= $data[3]) {
                            echo '<li class="page-item"><a class="page-link" href="'. $url . $i .'">'.$i.'</a></li>';
                            $i++;
                        };
                ?>
            </ul>
        </nav>
        <?php }; ?>
</div>
<script src="<?php echo URLROOT; ?>/public/js/gallery.js"></script>
<?php require APPROOT . '/views/inc/footer.php'; ?>