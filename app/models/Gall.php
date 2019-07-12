<?php
    class Gall {
        private $db;
        public function __construct()
        {
            $this->db = new Database;
        }

        // get all the images once
        public function loadImages(){
            $this->db->query('SELECT users.id as user_id,
                                    images.id as image_id,
                                    users.username as username,
                                    images.image_url as image_url
                                    
             FROM users INNER JOIN images ON users.id =  images.user_id ORDER BY images.creation_date DESC');

            // excute and return resault with fetchAll
            if($row = $this->db->resultSet())
                return $row;
            else
                return false;
        }


        // get all the comments once
        public function loadComments(){
            $this->db->query('SELECT * FROM comments');

            // excute and return resault with fetchAll
            if($row = $this->db->resultSet())
                return $row;
            else
                return false;
        }

    }