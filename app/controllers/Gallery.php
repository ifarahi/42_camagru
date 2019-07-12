<?php 
    class Gallery extends Controller {
        public function __construct()
        {
            $this->galleryModel = $this->model('Gall');
        }
        public function index()
        {
            $users = $this->galleryModel->loadImages();
            $comments = $this->galleryModel->loadComments();
            $data = array($users,$comments);
            $this->view('pages/gallery', $data);
        }
        public function about()
        {
            $this->view('pages/about', ['title' => 'About',
            'description' => 'App to share posts with other users'
            ]);
        }
    }