<?php

require_once "../connection.php";



$id = $_POST['id'];

$sqlDelete = "DELETE from tbl_events WHERE id=".$id;



mysqli_query($database, $sqlDelete);

echo mysqli_affected_rows($database);



mysqli_close($database);

?><?php

require_once "db.php";



$id = $_POST['id'];

$sqlDelete = "DELETE from tbl_events WHERE id=".$id;



mysqli_query($database, $sqlDelete);

echo mysqli_affected_rows($database);



mysqli_close($database);

?>