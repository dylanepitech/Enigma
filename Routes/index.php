<?php 
namespace Routes;
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
          
              $URI_PARTS = explode('/', $URI_PARSE);
              if (isset($URI_PARTS[2])) {
                  // Si la deuxième partie de l'URI existe
                  $second_part = '/' . $URI_PARTS[2];
                  $first_part = '/' . $URI_PARTS[1];
                  $entire_parts = $first_part . $second_part;
          
                  foreach ($object as $value) {
                      foreach ($value as $route) {
                          if ($route['method'] == $_SERVER['REQUEST_METHOD'] && str_contains($route['path'], $first_part . "/")) {
                              $controllerName = "Controller\\" . $route['controller'];
                              $action = $route['function'];
                              $controllerFile = 'src/controller/' . $route['controller'] . ".php";
                              if (file_exists($controllerFile)) {
                                  require_once $controllerFile;
                                  if (class_exists($controllerName)) {
                                      $controller = new $controllerName();
                                      $controller->$action(ltrim($second_part, "/"));
                                  } else {
                                      $error = 'La méthode appelée dans le contrôleur ne correspond pas.';
                                      require_once('./src/view/404.php');
                                      return;
                                  }
                                  return;
                              } else {
                                  $error = 'Le fichier du contrôleur n\'existe pas.';
                                  require_once('./src/view/404.php');
                                  return;
                              }
                          }
                      }
                  }
              } else {
                  // Si seule la première partie de l'URI est présente
                  foreach ($object as $value) {
                      foreach ($value as $route) {
                          if ($route['method'] == $_SERVER['REQUEST_METHOD'] && $route['path'] == $URI_PARSE) {
                              $controllerName = "Controller\\" . $route['controller'];
                              $action = $route['function'];
                              $controllerFile = 'src/controller/' . $route['controller'] . ".php";
                              if (file_exists($controllerFile)) {
                                  require_once $controllerFile;
                                  if (class_exists($controllerName)) {
                                      $controller = new $controllerName();
                                      $controller->$action();
                                  } else {
                                      $error = 'La méthode appelée dans le contrôleur ne correspond pas.';
                                      require_once('./src/view/404.php');
                                      return;
                                  }
                                  return;
                              } else {
                                  $error = 'Le fichier du contrôleur n\'existe pas.';
                                  require_once('./src/view/404.php');
                                  return;
                              }
                          }
                      }
                  }
              }
          
              $error = "La route demandée n'existe pas";
              require_once('./src/view/404.php');
          }
          
    }