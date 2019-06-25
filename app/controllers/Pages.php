<?php 
    class Pages extends Controller {
        public function __construct()
        {
        }
        public function index()
        {
            $this->view('pages/index', ['title' => 'SharePosts',
            'description' => 'Simple social network built on'
            ]);
        }
        public function about()
        {
            $this->view('pages/about', ['title' => 'About',
            'description' => 'App to share posts with other users'
            ]);
        }
    }