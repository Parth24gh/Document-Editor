<?php
	error_reporting(0);
	session_start();
	include 'config.php';

	if(!$_SESSION['login']){
		exit("<script>location.href = './index.php';</script>");
	}

	if(isset($_SESSION['instant']))
    {
		if(isset($_POST['idx'], $_POST['contents'])){
			$idx = (int)$_POST['idx'];
			$contents = addslashes($_POST['contents']);
			$table = $_SESSION['instant'];
			$chk_query = "SELECT * FROM `$table` WHERE idx='$idx'";
			$date = date("Y-m-d h:i:s A");

			if($row = mysqli_fetch_assoc(mysqli_query($conn, $chk_query))){ // edit
				$fdate = $row['fdate'];
				$query = "UPDATE `$table` SET ldate='$date', contents='$contents' WHERE idx='$idx'";
			}
			else { // new file
				$fdate = $date;
				$query = "INSERT INTO `$table` VALUES ('$idx', '$date', '$date', '$contents')";
			}

			mysqli_query($conn, $query) or die('save error');
			echo $fdate."<br>".$date;
			exit("<script>location.href = './instant.php'</script>");
			}
    }
	else{
		if(isset($_POST['idx'], $_POST['contents'])){
			$idx = (int)$_POST['idx'];
			$contents = addslashes($_POST['contents']);
			$table = $_SESSION['username'];
			$chk_query = "SELECT * FROM `$table` WHERE idx='$idx'";
			$date = date("Y-m-d h:i:s A");

			if($row = mysqli_fetch_assoc(mysqli_query($conn, $chk_query))){
				$fdate = $row['fdate'];
				$query = "UPDATE `$table` SET ldate='$date', contents='$contents' WHERE idx='$idx'";
			}
			else {
				$fdate = $date;
				$query = "INSERT INTO `$table` VALUES ('$idx', '$date', '$date', '$contents')";
			}

			mysqli_query($conn, $query) or die('save error');
			echo $fdate."<br>".$date;
		}
}

?>