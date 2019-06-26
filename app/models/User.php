<?php
    class User {
        private $db;
        public function __construct()
        {
            $this->db = new Database;
        }

        // Register the user
        public function register($data){
            $this->db->query('INSERT INTO users (name, username, email, password, validation_hash) VALUES (:name, :username, :email, :password, :hash)');
            // bind values
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':username', $data['username']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);
            $this->db->bind(':hash', $data['validation_hash']);

            // excute 
            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        // Login the user
        public function login($username, $password){
            $this->db->query('SELECT * FROM users WHERE username = :username');
            // bind value
            $this->db->bind(':username', $username);
            // get the the single row  where the username is matched
            if($row = $this->db->single()){
            // get the password hashed to compare with password verify
            $hashed_password = $row->password;
            if (password_verify($password, $hashed_password))
                return $row;
            else 
                return false;
            }
        }

        // verify the account 
        public function verify($email){
            $this->db->query('UPDATE users SET `activation` = :key WHERE email = :email');
            // bind values
            $this->db->bind(':key', 1);
            $this->db->bind(':email', $email);
            $this->db->execute();
        }

        // Set email verification hash
        public function setEmailVerificationHash($data){
            $this->db->query('UPDATE users SET validation_hash = :hash WHERE email = :email');
            $this->db->bind(':hash', $data['email_hash']);
            $this->db->bind(':email', $data['email']);

            if ($this->db->execute())
                return true;
            else
                return false;
        }

        // Check if the account is verfied with email
        public function isVerified($email){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            // bind values 
            $this->db->bind(':email', $email);

            if ($row = $this->db->single()){
                if ($row->activation > 0)
                    return $row->email;
                else
                    return false;
            }
        }

        // Check if the email exists
        public function findUserByEmail($email){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);

            if($row = $this->db->single()){
            // check row
            if ($this->db->rowCount() > 0)
                return true;
            else
                return false;
            }
        }

        // Check if the username exists
        public function findUserByUsername($username){
            $this->db->query('SELECT * FROM users WHERE username = :username');
            $this->db->bind(':username', $username);

            if($row = $this->db->single()){
            // check row
            if ($this->db->rowCount() > 0)
                return true;
            else
                return false;
            }
        }

        // Check if the token is correct
        public function checkToken($hash){
            $this->db->query('SELECT * FROM users WHERE validation_hash = :hash');
            $this->db->bind(':hash', $hash);

            // get the stored hash
            if ($token = $this->db->single()){
            // check is its match 
            if ($token->validation_hash == $hash){
                $this->verify($token->email);
                return true;
            }
            else
                return false;
            }
        }

        // hash and store the passed token where the email match
        public function storeForgetPasswordHash($data){
            $this->db->query('UPDATE users SET forget_pass_hash = :token WHERE email = :email');

            // hash the token before store it in the db
            $hashed = hash('sha256', $data['forget_password_hash']);
            // bind the values
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':token', $hashed);

            $this->db->execute();
        }

        // check if the tokencode i valid
        public function tokenIsMatch($token){
            $this->db->query('SELECT * FROM users WHERE forget_pass_hash = :hash');
            $hash = hash('sha256', $token);
            $this->db->bind(':hash', $hash);
            
            if ($row = $this->db->single())
                return $row->email;
            else
                return false;
        }

        // Delete the old hash
        public function deleteHash($data){
            $this->db->query('UPDATE users SET forget_pass_hash = "empty_for_now" WHERE email = :email');
            $this->db->bind(':email', $data['email']);
            
            if ($this->db->execute())
                return true;
            else
                return false;
        }

        // execute and change user password
        public function updatePassword($data){
            $this->db->query('UPDATE users SET password = :password WHERE email = :email');
            $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
            $this->db->bind(':email', $data['email']);
            
            if ($this->db->execute())
                return true;
            else
                return false;
        }

        // Update the name 
        public function updateName($data){
            $this->db->query('UPDATE users SET name = :name WHERE email = :email');
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);

            if ($this->db->execute())
                return true;
            else
                return false;
        }

        // Update the username
        public function updateUsername($data){
            $this->db->query('UPDATE users SET username = :username WHERE email = :email');
            $this->db->bind(':username', $data['username']);
            $this->db->bind(':email', $data['email']);

            if ($this->db->execute())
                return true;
            else
                return false;
        }

        // Update the email
        public function updateEmail($data){
            $this->db->query('UPDATE users SET email = :email, activation = :key, validation_hash = :hash WHERE username = :username');
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':key', NULL);
            $this->db->bind(':username', $data['username']);
            $this->db->bind(':hash', $data['email_hash']);

            if ($this->db->execute())
                return true;
            else
                return false;
        }

        // activate email notification so user can recieve email when someone comment on thier posts
        public function activateEmailNotification($email){
            $this->db->query('UPDATE users SET email_notification = 1 WHERE email = :email');
            $this->db->bind(':email', $email);

            if ($this->db->execute())
                return true;
            else
                return false;
        }

        // Desactivate email notification
        public function desactivateEmailNotification($email){
            $this->db->query('UPDATE users SET email_notification = 0 WHERE email = :email');
            $this->db->bind(':email', $email);

            if ($this->db->execute())
                return true;
            else
                return false;
        }

        // check if the email notification is active or not
        public function checkEmailNotificationStat($email){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();
            if ($row->email_notification > 0)
                return true;
            else
                return false;
        }

    }