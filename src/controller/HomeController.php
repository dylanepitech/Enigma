<?php 
namespace Controller;


class HomeController{

    public function view()
    {
        require_once('src/view/Home.php');

    }
    public function getuser($id)
    {
        echo $id;

    }
}