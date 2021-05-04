<?php

class Home extends Controller
{
    public function __construct() {
        $this->userModel = $this->model('User');
    }

    function index() {
        //$users = $this->userModel->getUsersDB();

        //$data = ['users' => $users];
        $data = ['message' => "Hello"];

        $this->view('pages/index', $data);
    }

    public function about() {
        $this->view('pages/about');
    }
}

?>