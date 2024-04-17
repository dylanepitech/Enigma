<?php 
namespace Enigma;
require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
class MakeController {
    protected $argument;
    protected $view_name;

    public function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../');
        $dotenv->load();
        echo "\033[32m"; 
        $this->argument = readline("Choisir un nom pour le controller: ");
        echo "\033[0m"; 
        self::GET_VIEW_NAME();
    }

    protected function GET_VIEW_NAME()
    {
        $this->view_name = strtolower(str_replace("Controller","",$this->argument));
        self::CREATE_DIR();
    }
    protected function CREATE_DIR()
    {
        @system("mkdir src/view/$this->view_name");
        self::CREATE_INDEX();
    }
    protected function CREATE_INDEX()
    {
        @system("touch src/view/$this->view_name/index.php");
        self::MAKE_CONTROLLER();
 
    }

    protected function MAKE_CONTROLLER()
    {
        $file = fopen("./src/controller/$this->argument".".php", 'w+');
        fwrite($file,"<?php\n namespace Controller;\n\n\t class $this->argument{\n\t\t");
        fwrite($file,"public function view(){\n\t\t");
        fwrite($file,"require_once 'src/view/$this->view_name/index.php';\n\t");
        fwrite($file,"}\n");
        if ($_ENV['ROUTER_AUTO'] == 'true')
        {
            fwrite($file,"\n\t\tpublic function post(){\n\t\t");
                fwrite($file,"\n\t");
                fwrite($file,"}\n");
        }
        fwrite($file,"}");
        echo "Controller et view créé";
        sleep(2);
        @system("clear");
    }

}

$test = new MakeController();