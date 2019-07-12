<?php

class Core {
protected $currentController = 'Gallery';
protected $currentMethod = 'index';
protected $params = [];

public function __construct(){
    $url = $this->getUrl();
    // look in controllers for the firt value
    if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php'))
    {
        //if exists set as current controller
        $this->currentController = ucwords($url[0]);
        // Unset 0 Index
        unset($url[0]);
    }
    // require the controller 
    require_once '../app/controllers/' . $this->currentController . '.php';
    // instantiate controller class
    $this->currentController = new $this->currentController;

    // Check if methos exits in controller
    if (isset($url[1]))
    {
        if (method_exists($this->currentController, $url[1]))
        {
            $this->currentMethod = $url[1];
            // unset 1 index
            unset($url[1]);
        }
    }
    // get params

    $this->params = $url ? array_values($url) : [];
    
    // call a callback with array of params
    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    //$this->currentController->$this->currentMethod($this->params);
} 

public function getUrl(){
    if (isset($_GET['url']))
    {
        $url = rtrim($_GET['url'], '/');
        // the filter_var() with the FILTER_SANITIZE_URL remove all illegal url characters from string
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/' ,$url);
        return $url;
    }
    
}
}