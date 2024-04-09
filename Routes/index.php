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
          }

        public static function SELECT_ROUTE($object)
        {
            $URI = $_SERVER['REQUEST_URI'];
            $URI_BASE = $_ENV['URL'];
            $URI_PARSE = str_replace("/".$URI_BASE,"", $URI);
            foreach ($object as  $value) {
               for ($i=0; $i < count($value) ; $i++) { 
                if ($value[$i]['method'] == $_SERVER['REQUEST_METHOD'] && $value[$i]['path'] == $URI_PARSE){
                    $controller = $value[$i]['controller'];
                    $function = $value[$i]['function'];
                    if (file_exists("./src/controller/$controller".".php"))
                    {   
                        echo 'ok';
                        return;
                    }else{
                        $error = 'La méthod appeler dans le controller ne correspond pas.';
                        require_once('./src/view/404.php');
                        return;
                    }
                }else{
                    $error = "La route demander n'existe pas";
                   require_once('./src/view/404.php');
                   return;
                }
             }
            }
        }
    }