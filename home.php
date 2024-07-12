<?php
    error_reporting(0);
    session_start();
    include 'config.php';

    if(!isset($_SESSION['login'])){
        exit("<script>location.href='./index.php'</script>");
    }
    if(isset($_GET['logout'])){
        session_destroy();
        exit("<script>location.href='./index.php'</script>");
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./assets/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="./style.css" rel="stylesheet" type="text/css">
        <title>home</title>
    </head>
    <body>
        <center>
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                        	<img class="text-center" class="logo" src="./assets/Logo.png" style="width:100px; height: 100px;">
                            <p class="text-center lead">Online Notepad</p>
                            <hr>
                            <a class="btn btn-block btn-default" href="notepad.php?type=new" style="width:300px;">new contents</a>
                            <hr>
                            <a class="btn btn-block btn-default" href="password.php" style="width:300px;">change password</a>
                            <a class="btn btn-block btn-default" href="?logout" style="width:300px;">logout</a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                    <?php
                        $i = 0;
                        $table =  $_SESSION['username'];
                        $query = mysqli_query($conn, "SELECT * FROM `$table` ORDER BY idx DESC");
                        $j = mysqli_num_rows($query);

        		        while($row = mysqli_fetch_assoc($query)){
                            $i = ($i == 4) ? 0 : $i + 1;
        		        	echo "<div class='col-md-3'>
        		        	<a href='./notepad.php?type=edit&idx=".$row['idx']."'>
        		        	<img src='./assets/notepad.bmp' class='img-responsive'></a>
        		        	<p>".$j--."</p></div>";
        		        }
        		        mysqli_close($conn);
                    ?>
                    </div>
                </div>
            </div>
        </center>
    </body>
</html>