<?php 
namespace Routes;
use Routes\index;
// require_once __DIR__ . '/../vendor/autoload.php';
$invok = new index();
$invok->Route('/','HomeController@view', 'GET');

index::SELECT_ROUTE($invok);