<?php
    class Camera extends Controller {
        public function __construct(){
            $this->camModel = $this->model('Cam');
        }

        public function index(){
            if (!isset($_SESSION['user_id']))
                redirects('users/login');
            else {        

                if($row =  $this->loadImages())
                    $this->view('pages/camera', $row);
                else
                    $this->view('pages/camera');
            }
        }

        
        public function capturedImages(){
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $filters = [
                    'big_smile' => 'img/filters/big_smile.png',
                    'christmas_hat' => 'img/filters/christmas_hat.png',
                    'golden_crown' => 'img/filters/golden_crown.png',
                    'thumbs_up' => 'img/filters/thumbs_up.png'
                ];
                if (array_key_exists($_POST['filter'], $filters)){
                    // toReturn keep the original base64code to return it to be used directly in the image src
                    $toReturn = $_POST['image'];
                    
                    $img = $_POST['image'];
                    $img = str_replace('data:image/png;base64,', '', $img);
                    // $img = str_replace(' ', '+', $img);
                    $pic = base64_decode($img);
                    $path = 'img/';
                    $name = time() . '.png';
                    

                    $data = [
                        'user_id' => $_SESSION['user_id'],
                        'image_url' => $path . $name
                        ];
                    
                    $src = imagecreatefrompng(PUB .'/'.$filters[$_POST['filter']]);
                    $dst = imagecreatefrompng($toReturn);

                    imagecopy($dst , $src , 30 , 15 , 0 , 0 , 137 , 137 );
                    imagejpeg($dst, $path . $name, 100);

                    if (file_exists($path . $name))
                        $toReturn = base64_encode(file_get_contents($path . $name));

                    if ($this->camModel->insertImage($data)){
                        $row = $this->camModel->getUserImage($data['image_url']);
                        $info = ['image_row' => $row,
                                'image_src' => $toReturn,
                                'status' => 'OK'
                                ];
                        echo json_encode($info);
                    }
                    else{
                        $info = ['status' => 'KO'];
                        echo json_encode($info);
                    }
                }
                else {
                    $info = ['status' => 'KO'];
                    echo json_encode($info);
                }
            }
        }

        // Get and return the all the user images 
        public function loadImages(){
            $row = $this->camModel->getUserImages($_SESSION['user_id']); 
            return $row;
        }

        // delete the image url from the database and delete if physically from the server
        public function deleteImage(){
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // if the image has successfully deleted from the data base then delete if from the server with unlink
                if ($this->camModel->deleteImage($_POST['image_id'])){
                    $url = PUB . '/' .$_POST['image_url'];
                    unlink($url);
                }
                else
                    echo "Somthing went wrong";
            }
        }

    }