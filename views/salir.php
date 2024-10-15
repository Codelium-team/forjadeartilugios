<?php

if ($_GET['sal']=='si') {
    session_start();
	session_destroy();
	header("Location:formulario.php");
}	

?>

