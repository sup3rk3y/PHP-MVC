<?php

class App
{
    protected $controller = "Home";
    protected $method = "index";
    protected $params = [];

    public function __construct() {
        $url = $this->getURL();

        // Checks the first part of URL
        if(file_exists('..app/controllers/' . ucwords($url[0]) . '.php')) {
             $this->controller = ucwords($url[0]);
             unset($url[0]);
        }

        require_once('../app/controllers/' . $this->controller . '.php');
        $this->controller = new $this->controller;

        // Checks for second part of URL
        if(isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // Get parameters
        $this->params = $url ? array_values($url) : [];

        call_user_func_array(array($this->controller, $this->method), $this->params);
    }

    private function getURL() {
        if(isset($_GET['url'])) {
            $url = filter_var($_GET['url'], FILTER_SANITIZE_URL);
            $url =  explode('/', rtrim($url, '/'));
            return $url;
        }

        return [$this->controller];
    }

}

?>