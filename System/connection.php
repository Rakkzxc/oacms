<?php
define("SANITIZE_PASSWORD", "2024-5-29");
define("DATABASE_CHECK", "System/");
define("LOCAL_HOSTT", "oacms");
$database= new mysqli("localhost","root","@Nkn2mw56a8nju","oacms");
if ($database->connect_error){
    die("Connection failed:  ".$database->connect_error);
}

?>