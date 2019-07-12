<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container mt-4">
        <div class="row">
            <div class="col-md-7">
                <div class="text-center">
                    <div id="webcam-filter">
                        <video id="video" class="w-100"></video>
                        <div class="strike mt-4 mb-4" id="strike">
                            <span>OR</span>
                        </div>
                        <div class="input-group" id="inputg">
                            <div class="custom-file" id="customfile">
                                <input id="upload-file" type="file" class="custom-file-input" accept=".png, .jpg" id="imageloader" name="imageloader">
                                <label class="custom-file-label" for="" id="labelcfile">Choose file</label>
                            </div>
                        </div>
                        <img id="imageshow"  class="w-100">
                        <img id="filterimg" style="display: none;" src="">
                    </div>
                    <form id="submitf" action="#" method="post" class="form-group">
                        <label for=""><input type="hidden" id="picurl" name="picurl">
                            <input type="hidden" id="emox" name="emox">
                            <input type="hidden" id="emoy" name="emoy">
                        </label>
                        <div class="form-group">
                            <label for="photo-filter">
                                <select name="selectf" id="photo-filter" class="form-control">
                                    <option value="none" selected="">NONE</option>
                                    <option value="big_smile">BIG SMILE</option>
                                    <option value="christmas_hat">CHRISTMAS HAT</option>
                                    <option value="golden_crown">GOLDEN CROWN</option>
                                    <option value="thumbs_up">THUMBS UP</option>
                                </select>
                            </label>
                        </div>
                    </form>
                    <div class="form-group">
                        <button disabled class="btn btn-primary btn-block" id="startbutton">Take picture</button>
                        <button style="display:none;" disabled class="btn btn-primary btn-block" id="uploadbutton">Upload picture</button>                    </div>
                </div>
            </div>
                <div id="image-holder" class="col-md-5 overflow-y ">  
                    <?php
                    if (!empty($data)){
                        foreach ($data as $image){
                            $imageData = base64_encode(file_get_contents(PUB . '/' .$image->image_url));
                            $src = 'data: image/png;base64,'.$imageData;
                            echo '
                                <img class="w-100 mb-2"  src="' . $src . '">
                                </form>
                                <form action="#" method="post">
                                <input type="hidden" name="'.$image->id.'" value="'.$image->image_url.'">
                                <button class="btn btn-danger btn-block mb-2 delete-image">Delete this picture</button>
                                </form>
                            '; 
                        }
                    }
                    ?>
                <canvas id="canvas" class="w-100" style="display: none;" width="500" height="400"></canvas>
            </div>
        </div>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/camera.js"></script>
  <?php require APPROOT . '/views/inc/footer.php'; ?>