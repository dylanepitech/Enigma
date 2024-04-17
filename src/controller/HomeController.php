<?php 
namespace Controller;
use Form\user_tableform;


class HomeController{

    public function view()
    {
        require_once('src/view/Home.php');

    }
    public function post()
    {
        $user = new user_tableform();
        $user->collect();
    }
}