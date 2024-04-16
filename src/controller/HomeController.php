<?php 
namespace Controller;
use Form\userform;


class HomeController{

    public function view()
    {
        require_once('src/view/Home.php');

    }
    public function post()
    {
    $form = new userform();
    $form->collect();   
    }
}