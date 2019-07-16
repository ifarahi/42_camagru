<?php
    class Profile extends Controller {
        public function __construct()
        {
            $this->profileModel = $this->model('Prof');
        }

        public function index(){
            if (!isset($_SESSION['user_id']))
                redirects('users/login');
            else {        

                $images =  $this->profileModel->getUserImages($_SESSION['user_id']);
                $this->view('pages/profile', $images);
            }
        }

        public function postsNumber($user_id){
            return $this->profileModel->postsNumber($user_id);
        }

        public function imageLikesNumber($image_id){
            return $this->profileModel->likesNumber($image_id);
        }

        public function imageCommentsNumber($image_id){
            return $this->profileModel->commentsNumber($image_id);
        }

        public function uploadProfilePicture(){
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_FILES['file']) && isset($_POST['imageSrc'])){                  
                    $errors = '';
                    $path = 'img/';
                    $file = $_FILES['file'];
                    $imageSrc = $_POST['imageSrc'];
                    $extensions = ['jpg', 'jpeg', 'png'];
                    $file_name = $file['name'];
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
                        'profile_img' => $path . $name
                        ];
                    
                    if ($file_type != 'image')
                        $error = 'file not allowed ! Only images';

                    if (!in_array($file_ext, $extensions))
                        $error = 'Extension not allowed !';
    
                    if ($file_size > 4000000)
                        $error = 'File size is too big ! max is 4MB';

                    if (!($dst = @imagecreatefrompng($imageSrc)))
                        $error = 'Not a valid image!';

                    if (!empty($error)){
                        $info = [
                            'status' => 'KO',
                            'error' => $error
                        ];
                        echo json_encode($info);
                    } else {

                        imagejpeg($dst, $path . $name, 100);

                        if (file_exists($path . $name))
                            $imageSrc = base64_encode(file_get_contents($path . $name));

                        if ($this->profileModel->insertProfileImage($data)){
                            $_SESSION['profile_img'] = $data['profile_img'];
                            $info = ['image_src' => $imageSrc,
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
        }
    }