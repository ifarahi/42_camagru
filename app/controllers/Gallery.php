<?php 
    class Gallery extends Controller {
        public function __construct()
        {
            $this->galleryModel = $this->model('Gall');
        }
        public function index($page = 1){

            // this only to see if the images table is empty because count return one (count the false also as an elemnt)
            $tabret = $this->galleryModel->numberOfImages();

            $imagesNumber = count($this->galleryModel->numberOfImages());
            $numberOfPages = ceil($imagesNumber/5);

            if (!is_numeric($page))
                $page = 1;
            if ($page > $numberOfPages || $page < 1)
                $page = 1;
            
            $startingLImit = ($page - 1) * 5;
            
            $users = $this->galleryModel->loadImages($startingLImit,5);
            $comments = $this->galleryModel->loadComments();
            $data = array($users,$comments,$imagesNumber,$numberOfPages,$tabret);

            $this->view('pages/gallery', $data);
        }

        public function sendEmailnotification($data){
            mail($data['email'], $data['title'], $data['message']);
        }

        public function comment(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                if (isLoggedIn()){
                    if (isset($_POST['image_id']) && isset($_POST['comment'])){
                        $data = [
                            'image_id' => $_POST['image_id'],
                            'comment' => $_POST['comment'],
                            'user_id' => $_SESSION['user_id'],
                            'profile_img' => $this->getProfileImage($_SESSION['user_id']),
                            'error' => '',
                            'status' => '',
                            'username' => ''
                        ];
                        $value = trim($data['comment']);
                        if (strlen($data['comment']) > 400)
                            $data['error'] = 'you have passed the max lenght of the comment';
                        if (!strlen($value)) 
                            $data['error'] = 'this is not a valid comment';

                        if (empty($data['error'])){
                            if ($this->galleryModel->setComment($data)){
                                $title = '[Camagru] You have a new comment';
                                $message = 'Hello, we want to informe you that ' . $this->getUsername($data['user_id']) . ' has been commented on your picture ';
                                $image_user_id = $this->galleryModel->getUserId($data['image_id']);
                                $get_user_email = $this->galleryModel->getUserEmail($image_user_id);
                                $info = [
                                    'email' => $get_user_email,
                                    'title' => $title,
                                    'message' => $message
                                ];
                                if ($_SESSION['email_notif'] > 0)
                                    $this->sendEmailnotification($info);
                                $data['comment'] = htmlspecialchars_decode($data['comment'], ENT_QUOTES);
                                $data['status'] = 'OK';
                                $data['username'] = $_SESSION['username'];
                                echo json_encode($data);

                            } else {
                                $data['status'] = 'KO';
                                $data['error'] = 'the comment has been not set!';
                                echo json_encode($data);
                            }
                        } else {
                            $data['status'] = 'KO';
                            echo json_encode($data);
                        }

                    }
                }
            }
        }

        public function like(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                if (isLoggedIn()){
                    if(isset($_POST['image_id'])){
                        $data = [
                            'image_id' => $_POST['image_id'],
                            'user_id' => $_SESSION['user_id'],
                            'likeState' => '',
                            'status' => ''
                        ];
                        $data['likeState'] = $this->galleryModel->likeState($data);

                        if ($data['likeState'] == 'ON'){
                            if ($this->galleryModel->deslike($data)){
                                $title = '[Camagru] '. $this->getUsername($data['user_id']) .' Unliked your picture';
                                $message = 'Hello, we want to informe you that ' . $this->getUsername($data['user_id']) . ' Unliked your picture ';
                                $image_user_id = $this->galleryModel->getUserId($data['image_id']);
                                $get_user_email = $this->galleryModel->getUserEmail($image_user_id);
                                $info = [
                                    'email' => $get_user_email,
                                    'title' => $title,
                                    'message' => $message
                                ];
                                if ($_SESSION['email_notif'] > 0)
                                    $this->sendEmailnotification($info);
                                $data['status'] = 'OFF';
                                echo json_encode($data);
                            }
                        } 
                        if ($data['likeState'] == 'OFF'){
                            if ($this->galleryModel->like($data)){
                                $title = '[Camagru] You have a new like';
                                $message = 'Hello, we want to informe you that ' . $this->getUsername($data['user_id']) . ' has been liked your picture ';
                                $image_user_id = $this->galleryModel->getUserId($data['image_id']);
                                $get_user_email = $this->galleryModel->getUserEmail($image_user_id);
                                $info = [
                                    'email' => $get_user_email,
                                    'title' => $title,
                                    'message' => $message
                                ];
                                if ($_SESSION['email_notif'] > 0)
                                    $this->sendEmailnotification($info);
                                $data['status'] = 'ON';
                                echo json_encode($data);
                            }
                        }

                        if ($data['likeState'] == false){
                            if ($this->galleryModel->setlike($data)){
                                $title = '[Camagru] You have a new like';
                                $message = 'Hello, we want to informe you that ' . $this->getUsername($data['user_id']) . ' has been liked your picture ';
                                $image_user_id = $this->galleryModel->getUserId($data['image_id']);
                                $get_user_email = $this->galleryModel->getUserEmail($image_user_id);
                                $info = [
                                    'email' => $get_user_email,
                                    'title' => $title,
                                    'message' => $message
                                ];
                                if ($_SESSION['email_notif'] > 0)
                                    $this->sendEmailnotification($info);
                                $data['status'] = 'ON';
                                echo json_encode($data);
                            }
                        }
                    }
                }

            }

        }

        public function showLikeState($data){
            return $this->galleryModel->likeState($data);
        }

        public function showNumberOFLikes($image_id)
        {
            return $this->galleryModel->numberOfLikes($image_id);
        }

        public function getUsername($id){
            return $this->galleryModel->getUsername($id);
        }
        
        public function getProfileImage($user_id){
            return $this->galleryModel->getUserProfileImage($user_id);
        }
    }