<?php
/**
 * Created by PhpStorm.
 * User: tassio
 * Date: 10/01/2018
 * Time: 10:39
 */

session_start();
unset($_SESSION['user']);
unset($_SESSION['pwd']);
session_destroy();
header('location:index.php');

?>