<?php
define("SANITIZE_PASSWORD", "2024-2-29");
define("DATABASE_CHECK", "System/");
define("LOCAL_HOSTT", "oacms");
$database= new mysqli("localhost","root","","oacms");
if ($database->connect_error){
    die("Connection failed:  ".$database->connect_error);
}

?>