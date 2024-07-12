<?php

error_reporting(0);
session_start();
include 'config.php';

if(isset($_SESSION['instant']))
{
    $table = $_SESSION['instant'];

    if(isset($_GET['idx'])){
        $query = "DELETE FROM `$table` WHERE idx='".(int)$_GET['idx']."'";
    	mysqli_query($conn, $query) or die('delete error');
    	exit("<script>alert('delete ok');location.href='./instant.php'</script>");
    }
    exit("<script>location.href = './instant.php'</script>");
}

if(!isset($_SESSION['login'])){
    exit("<script>location.href = './index.php'</script>");
}

$table = $_POST['username'];

if(isset($_GET['idx'])){
    $query = "DELETE FROM `$table` WHERE idx='".(int)$_GET['idx']."'";
	mysqli_query($conn, $query) or die('delete error');
	exit("<script>alert('delete ok'); location.href = './home.php'</script>");
}
exit("<script>location.href = './home.php'</script>");

?>