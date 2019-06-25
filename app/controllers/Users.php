<?php
  class Users extends Controller {
    public function __construct(){
      $this->userModel = $this->model('User');
    }

    public function index(){
      $data =[
        'email' => '',
        'password' => '',
        'email_error' => '',
        'password_error' => '',     
      ];
      $this->view('users/login', $data);
    }

    public function register(){
    // if already logged in cannot acces
      if (!empty($_SESSION['user_id']))
      redirects('pages/index');
      // Check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process form
  
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data =[
          'name' => trim($_POST['name']),
          'username' => trim($_POST['username']),
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm_password']),
          'validation_hash' => '',
          'email_verification' => '',
          'name_error' => '',
          'username_error' => '',
          'email_error' => '',
          'password_error' => '',
          'confirm_password_error' => '',
          'message' => '',
          'title' => '',
        ];

        // Validate Email
        if(empty($data['email'])){
          $data['email_error'] = 'Pleae enter email';
        } else {
            // check if valid email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $data['email_error'] = "Please enter a valid email"; 
            }

            // Check email if exists
            if($this->userModel->findUserByEmail($data['email'])){
            $data['email_error'] = 'Email is already taken';
            }
        }
        //valid username
        if (preg_match('/\s/',$data['username']) || !ctype_alnum($data['username'])){
            $data['username_error'] = 'Please enter a valid username';
        } else {
            // check the lenght of the username
            if (strlen($data['username']) < 6)
                $data['username_error'] = 'Username should be at least 6 characters';

            // check if the username is already taken
            if ($this->userModel->findUserByUsername($data['username']))
                    $data['username_error'] = 'Username is already taken';
        }

        // Validate Name
        if(empty($data['name'])){
          $data['name_error'] = 'Pleae enter name';
        }

        // Validate Password
        if(empty($data['password'])){
          $data['password_error'] = 'Pleae enter password';
        } else {
          // Validate password strength
          $uppercase = preg_match('@[A-Z]@', $data['password']);
          $lowercase = preg_match('@[a-z]@', $data['password']);
          $number    = preg_match('@[0-9]@', $data['password']);
          if(!$uppercase || !$lowercase || !$number || strlen($data['password']) < 8)
              $data['password_error'] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number.';
        }
        // validate confirm_password
        if ($data['password'] != $data['confirm_password'])
          $data['confirm_password_error'] = 'Password does not match!';

        // Make sure errors are empty
        if(empty($data['email_error']) && empty($data['username_error']) && empty($data['name_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])){
          // Validated

          // generate confirmation key
        $hash = md5( rand(0,1000) );
        $data['validation_hash'] = $hash;
          // hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        if($this->userModel->register($data))
        {
            $link = $link = URLROOT . '/users/emailVerification/' . $data['validation_hash'];
            $data['message'] = 'Please click on the link to validate you registration : ' . $link;
            $data['title'] = 'Camagru: Complete your registration';
            $this->sendEmailnotification($data);
            $data['email_verification'] = 'alert-info';
            $data['email'] = '';
            $data['password'] = '';
            $this->view('users/login', $data);
        }
        else
        {
            die('somthing went wrong');
        }
        } else {
          // // Load view with errors
          $this->view('users/register', $data);
        }

      } else {
        // Init data
        $data =[
          'name' => '',
          'email' => '',
          'username' => '',
          'password' => '',
          'name_error' => '',
          'username_error' => '', 
          'email_error' => '',
          'password_error' => ''
        ];

        // // Load view
        $this->view('users/register', $data);
      }
    }

    public function login(){
      // if already logged in cannot acces
      if (!empty($_SESSION['user_id']))
        redirects('pages/index');
      // Check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process form
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        // Init data
        $data =[
          'username' => trim($_POST['username']),
          'password' => trim($_POST['password']),
          'username_error' => '',
          'password_error' => '' 
        ];

        //valid username
        if (preg_match('/\s/',$data['username']) || !ctype_alnum($data['username']))
            $data['username_error'] = 'Please enter a valid username';

        // Validate Password
        if(empty($data['password'])){
          $data['password_error'] = 'Please enter password';
        }

        // Make sure errors are empty
        if(empty($data['username_error']) && empty($data['password_error'])){
        // Check if username and password correct and exists
            $loggedInUser = $this->userModel->login($data['username'], $data['password']);
            if ($loggedInUser){
              // check if the account is verified
              if ($this->userModel->isVerified($loggedInUser->email))
              {
                $this->createUserSession($loggedInUser);
              }
              else {
                $data['email_verification'] = 'alert alert-danger';
                $this->view('users/login', $data);
              }
            } else {
                $data['email_verification'] = 'class="alert alert-danger';
                $this->view('users/login', $data);
            }
        } else {
          // Load view with errors
          $this->view('users/login', $data);
        }


      } else {
        // Init data
        $data =[    
          'username' => '',
          'password' => '',
          'username_error' => '',
          'password_error' => ''  
        ];

        // Load view
        $this->view('users/login', $data);
      }
    }


    public function createUserSession($user){
      $_SESSION['user_id'] = $user->id;
      $_SESSION['name'] = $user->name;
      $_SESSION['email'] = $user->email;
      $_SESSION['username'] = $user->username;
      $_SESSION['email_notif'] = $user->email_notification;
      redirects('users/setting');
    }

    public function logout(){
      unset($_SESSION['user_id']);
      unset($_SESSION['user_name']);
      unset($_SESSION['user_email']);
      redirects('pages/index');
    }

    public function sendEmailnotification($data){
      mail($data['email'], $data['title'], $data['message']);
    }

    public function emailVerification($token){
      // check if the token code is match
      if ($this->userModel->checkToken($token)){
          $data = ['email_verification' => 'alert-success',
                  'email' => '',
                  'password' => '',
                  'email_error' => '',
                  'password_error' => '',
                  ];
          $this->view('users/login', $data);
      } else {
        $data = ['email_verification' => 'alert-danger',
                  'email' => '',
                  'password' => '',
                  'email_error' => '',
                  'password_error' => '',
                ];
          $this->view('users/login', $data);
      }
    }

    public function setting(){
      // only users can access this page
      if (!isset($_SESSION['user_id']))
        redirects('users/login');

      //check if the post method is set
      if($_SERVER['REQUEST_METHOD'] == 'POST') {

      // Sanitize POST data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // edit only personal information
      if ($_POST['update_personal']){
      // Init data
      $data =[
        'name' => trim($_POST['name']),
        'username' => trim($_POST['username']),
        'email' => trim($_POST['email']),
        'name_error' => '',
        'username_error' => '',
        'email_error' => ''
        ];
      }

      }
      $this->view('users/setting');
    }

    public function forgetPassword(){
      // init data
      $data = [ 'email' => '',
                'password' => '',
                'email_error' => '',
                'password_error' => ''
              ];
      // if already logged in cannot acces
      if (!empty($_SESSION['user_id']))
        redirects('pages/index');
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        // init data
        $data =[
          'email' => trim($_POST['email']),
          'forget_password_hash' => '',
          'email_hash' => '',
          'email_notif' => '',
          'password' => '',
          'message' => '',
          'title' => ''
        ];
         
        // check if its a valid email
        if(empty($data['email'])){
          $data['email_error'] = 'Pleae enter email';
        } else {
          if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $data['email_error'] = "Please enter a valid email"; 
          }
        }

        // if there is no email error then verify it
        if (empty($data['email_error']))
        {
          if ($this->userModel->findUserByEmail($data['email'])){
          // generate a string of pseudo-random 32 bytes
          $data['forget_password_hash'] = bin2hex(openssl_random_pseudo_bytes(32));
          $this->userModel->storeForgetPasswordHash($data);
          $link = URLROOT . '/users/newpassword/' . $data['forget_password_hash'];
          $data['message'] = 'Please click on the link to set new password: ' . $link;
          $data['title'] = 'Camagru: account recovery';
          $this->sendEmailnotification($data);
          $data['email_verification'] = 'alert alert-success';
          $data['email'] = '';
          $this->view('users/login', $data);
          
        } else {
          $data['email_notif'] = 'alert-danger';
        }
      }
      }
      if (empty($data['email_verification']))
        $this->view('users/forgetpassword', $data);
    }

    public function newpassword($token){
      if(!$email = $this->userModel->TokenIsMatch($token))
        redirects('users/login');
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        // sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        // Init data
        $data =[
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm_password']),
          'email' => $email,
          'token' => $token,
          'password_error' => '',
          'password_m_error' => '',
          'notification' => ''
        ];

        if(empty($data['password'])){
          $data['password_error'] = 'Pleae enter password';
        } else {
          // Validate password strength
          $uppercase = preg_match('@[A-Z]@', $data['password']);
          $lowercase = preg_match('@[a-z]@', $data['password']);
          $number    = preg_match('@[0-9]@', $data['password']);
          if(!$uppercase || !$lowercase || !$number || strlen($data['password']) < 8)
              $data['password_error'] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number.';
        }
        if ($data['password'] != $data['confirm_password']){
          $data['password_m_error'] = 'Password does not match';
        }
        if (empty($data['password_error'])){
          if($this->userModel->updatePassword($data)){
              unset($data['password']);
              $data['notification'] = 'Your password has been updated you can login';
              $this->view('users/login', $data);
          }
        } else {
          //load the view with errors
          $this->view('users/newpassword', $data);
        }
        } else {
          // init data 
          $data = [
            'password' => '',
            'comfirm_password' => '',
            'token' => $token,
            'password_error' => '',
            'password_m_error' => '',
          ];
          // load the view 
          $this->view('users/newpassword', $data);
        }
    }
  }