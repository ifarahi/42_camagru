<?php
    session_start();

    // flash message helper
    // Exampel - flash('register_success', 'you are now registred', 'alert alert-danger') 
    // desplay in the view - echo flash('register-success') ;
    function flash ( $name = '', $message = '', $class = 'alert alert-success'){
        if (!empty($name)){
            if (!empty($message) && empty($_SESSION[$name])){
                if(!empty($_SESSION[$name])){
                    unset($_SESSION[$name]);
                }

                if (!empty($_SESSION[$name. '_class'])){
                    unset($_SESSION[$name. '_class']);
                }

                $_SESSION[$name] = $name;
                $_SESSION[$name . '_class'] = $class;
            } elseif (empty($message) && !empty($_SESSION[$name])){

            }
        }
    }
    function isLoggedIn(){
        if (isset($_SESSION['user_id']))
          return true;
        else
          return false;
      }
