<?php
namespace index;
require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;
try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    
    $test = $_ENV['ROUTER_AUTO'];
    var_dump($test);

} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage();
}

if ($test == 'false')
{
    require_once __DIR__ . '/Routes/web.php';

}else {
    var_dump('Coucou');
}