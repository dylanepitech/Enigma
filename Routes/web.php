<?php 
namespace Routes;
use Routes\index;
require_once('Routes/index.php');
$invok = new index();
$invok->Route('/home','controlluer@view', 'GET');