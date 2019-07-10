<?php
    class Cam {
        private $db;
        public function __construct()
        {
            $this->db = new Database;
        }

        public function insertImage($data){
            $this->db->query('INSERT INTO images (user_id, image_url) VALUES (:user_id, :image_url)');
            // bind values
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':image_url', $data['image_url']);

            // excute
            if($this->db->execute())
                return true;
            else
                return false;
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

        // get only one image
        public function getUserImage($image_url){
            $this->db->query('SELECT * FROM images WHERE image_url = :image_url');
            // bind values
            $this->db->bind(':image_url', $image_url);

            // excute and return the image row
            if($row = $this->db->single())
                return $row;
            else
                return false;
        }

        public function deleteImage($id){
            $this->db->query('DELETE FROM images WHERE id = :id');

            // bind the id
            $this->db->bind(':id', $id);

            if ($this->db->execute())
                return true;
            else
                return false;
        }

    }