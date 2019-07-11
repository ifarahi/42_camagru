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
                    $imageSrc = $_POST['image'];
                    $path = 'img/';
                    $name = time() . '.png';
                    $data = [
                        'user_id' => $_SESSION['user_id'],
                        'image_url' => $path . $name
                        ];
                    
                    $src = imagecreatefrompng(PUB .'/'.$filters[$_POST['filter']]);
                    $dst = imagecreatefrompng($imageSrc);

                    imagecopy($dst , $src , 30 , 15 , 0 , 0 , 137 , 137 );
                    imagejpeg($dst, $path . $name, 100);

                    if (file_exists($path . $name))
                        $imageSrc = base64_encode(file_get_contents($path . $name));

                    if ($this->camModel->insertImage($data)){
                        $row = $this->camModel->getUserImage($data['image_url']);
                        $info = ['image_row' => $row,
                                'image_src' => $imageSrc,
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
                    $info = ['status' => 'KO',
                            'error' => 'incorrect filter name or image'
                            ];
                    echo json_encode($info);
                }
            }
        }

        public function uploadedImages(){
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $filters = [
                    'big_smile' => 'img/filters/big_smile.png',
                    'christmas_hat' => 'img/filters/christmas_hat.png',
                    'golden_crown' => 'img/filters/golden_crown.png',
                    'thumbs_up' => 'img/filters/thumbs_up.png'
                ];
                if (array_key_exists($_POST['filter'], $filters) && isset($_FILES['file']) && isset($_POST['imageSrc'])){                    
                    $errors = '';
                    $path = 'img/';
                    $imageSrc = $_POST['imageSrc'];
                    $extensions = ['jpg', 'jpeg', 'png'];
                    $file_name = $_FILES['file']['name'];
                    $file_t = $_FILES['file']['type'];
                    $file_ty = explode('/', $file_t);
                    $file_type = $file_ty[0];
                    $file_size = $_FILES['file']['size'];
                    $file_e = explode('.', $file_name);
                    $file_ex = end($file_e);
                    $file_ext = strtolower($file_ex);
                    $name = time() . '.png';
                    $data = [
                        'user_id' => $_SESSION['user_id'],
                        'image_url' => $path . $name
                        ];
                    
                    if ($file_type != 'image')
                        $error = 'file not allowed ! Only images';

                    if (!in_array($file_ext, $extensions))
                        $error = 'Extension not allowed !';
    
                    if ($file_size > 4000000)
                        $error = 'File size is too big ! max is 4MB';

                    if (!$dst = @imagecreatefrompng($imageSrc))
                        $error = 'Not a valid image!';

                    if (!empty($error)){
                        $info = [
                            'status' => 'KO',
                            'error' => $error
                        ];
                        echo json_encode($info);
                    } else {

                        $src = imagecreatefrompng(PUB .'/'.$filters[$_POST['filter']]);

                        imagecopy($dst , $src , 30 , 15 , 0 , 0 , 137 , 137 );
                        imagejpeg($dst, $path . $name, 100);

                        if (file_exists($path . $name))
                            $imageSrc = base64_encode(file_get_contents($path . $name));

                        if ($this->camModel->insertImage($data)){
                            $row = $this->camModel->getUserImage($data['image_url']);
                            $info = ['image_row' => $row,
                                    'image_src' => $imageSrc,
                                    'status' => 'OK'
                                    ];
                            echo json_encode($info);
                        }
                        else {
                            $info = ['status' => 'KO'];
                            echo json_encode($info);
                        }
                        
                    }
                }

            }
            // $info = $_FILES['file'];
            // echo "Msg arrived";
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