<?php 
    class Gallery extends Controller {
        public function __construct()
        {
            $this->galleryModel = $this->model('Gall');
        }
        public function index(){
            $users = $this->galleryModel->loadImages();
            $comments = $this->galleryModel->loadComments();
            $data = array($users,$comments);
            $this->view('pages/gallery', $data);
        }

        public function about(){
            $this->view('pages/about', ['title' => 'About',
            'description' => 'App to share posts with other users'
            ]);
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
                            'error' => ''
                        ];
                        $value = trim($data['comment']);
                        if (strlen($value) > 0) {
                            if ($this->galleryModel->setComment($data)){
                                $title = '[Camagru] You have new comment';
                                $message = 'Hello, we want to informe you that ' . $this->getUsername($data['user_id']) . ' has been commented on your picture ';
                                $info = [
                                    'email' => $_SESSION['email'],
                                    'title' => $title,
                                    'message' => $message
                                ];
                                $this->sendEmailnotification($info);
                                echo '{'.$value.'}';
                            } else {
                                echo 'error';
                            }
                        } else {
                            echo '<script>alert("Not 9ewed")</script>';
                        }

                    }
                }
            }
        }

        public function getUsername($id){
            return $this->galleryModel->getUsername($id);
        }
    }