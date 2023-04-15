<?php
session_start();

if (isset($_SESSION['LoginId'])) {
    include('home1.php');
} else {
    include('home2.php');
}
?>