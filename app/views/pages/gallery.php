<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <?php foreach($data[0] as $img) : 
        $creation_date = date( 'd M H:i', strtotime($img->date));    
        ?>
        <div class="col-md-8 mx-auto">
            <div class="card mb-5 border-gray">
                <div class="card-header">
                    <i class="fas fa-heart"></i><?php echo $img->username;?><span style="float: right;"><i class="fas fa-clock"></i><?php echo $creation_date;?></span>
                </div>
                    <img class="w-100" src="<?php echo URLROOT .'/' . $img->image_url; ?>">
                    <div class="card-body mb-4">
                        <form action="include/like.inc.php" class="form-group" method="post">
                            <button type="submit" class="mb-2 btn btn-success btn-sm" name="like" disabled=""><i class="far fa-thumbs-up"></i> Like <span class="badge badge-light ml-2">0</span></button>
                            <input type="hidden" name="image_id" value="<?php echo $img->image_id?>">
                        </form>
                        <form action="<?php echo URLROOT.'/gallery/comment'?>" class="form-group" method="post">
                            <div class="media d-flex align-items-center">
                                <div class="media-body " <?php if(!isLoggedIn()){echo 'style="display: none;"';}?>>
                                    <input type="text" id="inputcom" class="form-control form-control-sm card-text" name="comment" >
                                    <input type="hidden" name="image_id" value="<?php echo $img->image_id?>">
                                </div>
                                <div class="media-right" <?php if(!isLoggedIn()){echo 'style="display: none;"';}?>>
                                    <button id="comment" type="submit" class="btn btn-dark ml-4">Comment</button>
                                </div>
                            </div>
                            <div class="mt-4">
                                <ul class="list-group">
                                    <?php 
                                        foreach($data[1] as $comment){
                                            if ($img->image_id == $comment->image_id)
                                                echo '
                                                <li class="list-group-item d-flex align-items-center">
                                                <span class="badge badge-info badge-pill mr-3">'.$this->getUsername($comment->user_id).'</span>
                                                '. $comment->comment .' 
                                                </li>
                                                
                                                ';
                                        };
                                    ?>
                                </ul>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>