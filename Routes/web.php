<?php 
namespace Routes;
use Routes\index;
$invok = new index();
$invok->Route('/home','HomeController@view', 'GET');
$invok->Route('/home/{id}','HomeController@getuser', 'GET');

index::SELECT_ROUTE($invok);