<?php 
namespace Routes;
use Routes\index;
// require_once __DIR__ . '/../vendor/autoload.php';
$invok = new index();
$invok->Route('/home','HomeController@view', 'GET');
$invok->Route('/home/{id}','HomeController@getuser', 'GET');

index::SELECT_ROUTE($invok);