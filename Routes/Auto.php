<?php 
namespace Routes;

/**
 * 1.Get current URI @param $URI.
 * 2. Get URI base @param $URI_BASE.
 * 3.Parse URI @param  $URI_PARSE and put lower @param $URI_LOWER.
 * 4. Navigate in th controller folder @param $fichier.
 * 5. Put all of name in lower and parse it.
 * 6. compare it with the URL parse.
 * 7. If both is same, put first letter in capitalize @param $controller.
 * 8. Concat @param $controller with "Controller.php".
 */

class Auto{

   public function __construct()
   {    
            $disponible = false;
             $URI = $_SERVER['REQUEST_URI'];
            $URI_BASE = $_ENV['URL'];
            $URI_PARSE = str_replace("/".$URI_BASE."/","", $URI);
            $URI_LOWER = strtolower($URI_PARSE);
            if ($URI_LOWER == "")
            {
                $URI_LOWER = $_ENV['DEFAULT'];
            }
            $path_dossier = "./src/controller";
            $fichier = scandir($path_dossier);
            foreach ($fichier as $value) {
               $str_replace = strtolower(str_replace('Controller.php',"",$value));
               if ($str_replace == $URI_LOWER)
               {
                $controller = $str_replace;
                $disponible = true;
               }
            }

            if ($disponible)
            {
                $controller = ucfirst($controller);
                $controller_name = "$controller"."Controller.php";
                $controller_name_namespace = "Controller\\"."$controller"."Controller";
                $controller_file = "src/controller/$controller_name";
                require_once $controller_file;
                $new_controller =  new $controller_name_namespace();
                if ($_SERVER['REQUEST_METHOD'] == 'GET')
                {
                    $new_controller->view();
                }else{
                    $new_controller->post();

                }
            }else{
                $error = 'La route ne corrrespond à aucune connue..';
                require_once('./src/view/404.php');
                return;
            }
           
                
   }

}
$invok = new Auto();