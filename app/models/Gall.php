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
                                    images.image_url as image_url,
                                    images.creation_date as `date`
                                    
             FROM users INNER JOIN images ON users.id =  images.user_id ORDER BY images.creation_date DESC');

            // excute and return resault with fetchAll
            if($row = $this->db->resultSet())
                return $row;
            else
                return false;
        }


        // get all the comments once
        public function loadComments(){
            $this->db->query('SELECT * FROM comments ORDER BY comment_date');

            // excute and return resault with fetchAll
            if($row = $this->db->resultSet())
                return $row;
            else
                return false;
        }

        public function setComment($data){
            $this->db->query('INSERT INTO comments (image_id, user_id, comment) VALUES (:image_id, :user_id, :comment)');

            // bind values
            $this->db->bind(':image_id', $data['image_id']);
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':comment', $data['comment']);

            if ($this->db->execute())
                return true;
            else
                return false;

        }

        public function getUsername($id)
        {
            $this->db->query('SELECT * FROM users WHERE id = :id');

            $this->db->bind(':id', $id);

            if ($row = $this->db->single())
                return $row->username;
        }

    }