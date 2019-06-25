<?php
/*
**** Base Controller to loades moddels and views
*/
class Controller {
    public function model($model)
    {
        // Require model file
        require_once '../app/models/' . $model . '.php';

        // instatiate model 
        return new $model();
    }

    // load view 
    public function view($view, $data = [])
    {
        // Check for the view file 
        if (file_exists('../app/views/' . $view . '.php'))
        {
            require_once '../app/views/' . $view . '.php';
        }
        else
        {
            // view does not exists
            die('view does not exist');
        }
    }
}