<?php

session_start(); 

if(isset($_POST['login'])){

    unset($_SESSION['login']);
}

echo 'OK';

?>