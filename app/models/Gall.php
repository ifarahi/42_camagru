<?php
    class Gall {
        private $db;
        public function __construct()
        {
            $this->db = new Database;
        }

        // get all the images once
        public function loadImages($s,$e){
            $this->db->query('SELECT users.id as user_id,
                                    users.profile_img as profile_img,
                                    images.id as image_id,
                                    users.username as username,
                                    images.image_url as image_url,
                                    images.creation_date as `date`
            FROM users INNER JOIN images ON users.id =  images.user_id ORDER BY images.creation_date DESC LIMIT :s, :e');

            $this->db->bind(':s',$s);
            $this->db->bind(':e',$e);

            // excute and return resault with fetchAll
            if($row = $this->db->resultSet())
                return $row;
            else
                return false;
        }

         // get all the number of images
         public function numberOfImages(){
            $this->db->query('SELECT id FROM images');

            // excute and return number of pictures
            if($number = $this->db->resultSet())
                return $number;
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

        public function setLike($data) {
            $this->db->query('INSERT INTO likes (user_id, image_id, liked) VALUES (:user_id, :image_id, 1)');

            // bind values
            $this->db->bind(':image_id', $data['image_id']);
            $this->db->bind(':user_id', $data['user_id']);

            if ($this->db->execute())
                return true;
            else
                return false;
        }
        public function likeState($data){
            $this->db->query('SELECT * FROM likes WHERE user_id = :user_id AND image_id = :image_id');

            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':image_id', $data['image_id']);

            if ($row = $this->db->single()){
                if ($row->liked > 0)
                    return 'ON';
                else
                    return 'OFF';
            } else {
                return false;
            }
        }

        public function like($data){
            $this->db->query('UPDATE likes SET liked = 1 WHERE user_id = :user_id AND image_id = :image_id');

            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':image_id', $data['image_id']);

            if ($this->db->execute())
                return true;
            else
                return false;
        }

        public function deslike($data){
            $this->db->query('UPDATE likes SET liked = 0 WHERE user_id = :user_id AND image_id = :image_id');

            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':image_id', $data['image_id']);

            if ($this->db->execute())
                return true;
            else
                return false;
        }

        public function numberOfLikes($image_id){
            $this->db->query('SELECT * FROM likes WHERE image_id = :image_id AND liked = 1');

            $this->db->bind(':image_id', $image_id);

            if ($this->db->execute())
                return $this->db->rowCount();
            else
                return false;
        }

        public function getUserEmail($id)
        {
            $this->db->query('SELECT * FROM users WHERE id = :id');

            $this->db->bind(':id', $id);

            if ($row = $this->db->single())
                return $row->email;
        }
        public function getUserId($image_id)
        {
            $this->db->query('SELECT * FROM images WHERE id = :image_id');

            $this->db->bind(':image_id', $image_id);

            if ($row = $this->db->single())
                return $row->user_id;
        }

        // Get user profile image to set the session
        public function getUserProfileImage($user_id){
            $this->db->query('SELECT * FROM users WHERE id = :user_id');
            $this->db->bind(':user_id', $user_id);

            if ($row = $this->db->single())
                return $row->profile_img;
            else
                return false;
        }
    }