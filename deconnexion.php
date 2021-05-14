<?php
session_start();

setcookie('email','',time()-1123*1234);
setcookie('pwd','',time()-24*13*365);
$_SESSION = array(); // unset all session value
session_destroy();


header("Location:connexion.php");
 ?>