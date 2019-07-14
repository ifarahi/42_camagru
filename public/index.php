<?php 
include_once('../app/bootstrap.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    foreach($_POST as &$p){
        $p = htmlspecialchars($p, ENT_QUOTES);
    }
 }
$instance = new Core;