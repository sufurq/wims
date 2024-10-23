<?php   
session_start();
session_destroy(); 
header("location: /wims/ventory/log_in.php"); 
exit();
?>