<?php
namespace index;
require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;
try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    
    $test = $_ENV['ROUTER_AUTO'];

} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage();
}

if ($test == 'false')
{
    require_once __DIR__ . '/Routes/web.php';

}else {
    require_once __DIR__. '/Routes/Auto.php';
}