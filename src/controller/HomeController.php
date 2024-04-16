<?php 
namespace Controller;


class HomeController{

    public function view()
    {
        require_once('src/view/Home.php');
    }
    public function post()
    {
        var_dump($_POST);
    }
}