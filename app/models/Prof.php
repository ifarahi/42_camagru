<?php 
    class Prof {
        private $db;
        public function __construct(){
            $this->db = new Database;
        }

        // get all the images once
        public function getUserImages($user_id){
            $this->db->query('SELECT * FROM images WHERE user_id = :user_id ORDER BY creation_date DESC');
            // bind values
            $this->db->bind(':user_id', $user_id);

            // excute and return resault with fetchAll
            if($row = $this->db->resultSet())
                return $row;
            else
                return false;
        }

        public function likesNumber($image_id){
            $this->db->query('SELECT count(*) AS number            
            FROM likes WHERE image_id = :image_id');
            // bind values
            $this->db->bind(':image_id', $image_id);

            // excute and return resault with fetchAll
            if($row = $this->db->single())
                return $row;
            else
                return false;
        }

        public function commentsNumber($image_id){
            $this->db->query('SELECT count(*) AS number            
            FROM comments WHERE image_id = :image_id');
            // bind values
            $this->db->bind(':image_id', $image_id);

            // excute and return resault with fetchAll
            if($row = $this->db->single())
                return $row;
            else
                return false;
        }

        public function postsNumber($user_id){
            $this->db->query('SELECT count(*) AS number 
            FROM images WHERE user_id = :user_id');
            // bind values
            $this->db->bind(':user_id', $user_id);

            // excute and return resault with fetchAll
            if($row = $this->db->single())
                return $row;
            else
                return false;
        }

        public function insertProfileImage($data){
            $this->db->query('UPDATE users SET profile_img = :profile_img WHERE id = :user_id');
            // bind values
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':profile_img', $data['profile_img']);

            // excute
            if($this->db->execute())
                return true;
            else
                return false;
        }
    }