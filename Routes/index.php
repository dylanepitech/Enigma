<?php 
namespace Routes;
require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

    class index{

        public $array_route = [];

        public function __construct()
        {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
            $dotenv->load();
        }
        public function Route(string $path,string $controller, string $method)
          {
              $CONTROLLER =  str_replace("@", " ", $controller);
              $CONTROLLER_NAME = explode(" ",$CONTROLLER);
              array_push($this->array_route, ['path'=>$path, 'controller'=>$CONTROLLER_NAME[0], 'function'=>$CONTROLLER_NAME[1], 'method'=>$method]);
              $this->GET_METHOD();
          }

        public function GET_METHOD()
        {
            $URI = $_SERVER['REQUEST_URI'];
            $URI_BASE = $_ENV['URL'];
            $URI_PARSE = str_replace("/".$URI_BASE,"", $URI);
            var_dump($URI_PARSE).PHP_EOL;
            var_dump($this->array_route);
        }
    }