<?php 
namespace Controller;
use Entity\user;


class HomeController{

    public function view()
    {
        require_once('src/view/Home.php');
    }
}