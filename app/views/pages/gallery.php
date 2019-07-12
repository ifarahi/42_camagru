<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <?php //foreach($data as $img) : ?>
        <?php //$creation_date = date( 'd M H:i', strtotime($img->creation_date)); ?>
        <?php foreach($data[0] as $user){
                echo 'username : ' .$user->username. ' || user_id :' .$user->user_id. ' || image_id : ' .$user->image_id. ' || image_url : ' .$user->image_url.' <br >';
        }; ?>
        <div class="col-md-8 mx-auto">
            <div class="card mb-5 border-gray">
                <div class="card-header">
                    <i class="fas fa-user"></i><?php //echo $img->username;?><span style="float: right;"><i class="fas fa-clock"></i><?php //echo $creation_date;?></span>
                </div>
                    <img class="w-100" src="<?php //echo $img->image_url; ?>">
                    <div class="card-body mb-4">
                        <form action="include/like.inc.php" class="form-group" method="post">
                            <button type="submit" class="mb-2 btn btn-success btn-sm" name="like" disabled=""><i class="far fa-thumbs-up"></i> Like <span class="badge badge-light ml-2">0</span></button>
                            <input type="hidden" name="pictureid" value="2">
                        </form>
                        <form action="#" class="form-group" method="post">
                            <div class="media d-flex align-items-center">
                                <div class="media-body ">
                                    <input type="text" id="inputcom" class="form-control form-control-sm card-text" name="comment" >
                                    <input type="hidden" name="pictureid" value="2">
                                </div>
                                <div class="media-right">
                                    <button type="submit" class="btn btn-dark ml-4" disabled="">Envoyer</button>
                                </div>
                            </div>
                            <div class="mt-4">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex align-items-center">
                                    <span class="badge badge-info badge-pill mr-3">iouzzine</span>
                                    qssqsqsqs 
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
        <?php //endforeach;?>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>