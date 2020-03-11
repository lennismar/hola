<?php
session_start();
if (isset($_SESSION['type_user'])) {
   unset($_SESSION['type_user']);
   unset($_SESSION['eid']);
}
header('Location: index.php');
exit;
?> 
