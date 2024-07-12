<?php
    error_reporting(0);
    session_start();
    include 'config.php';

    if(!isset($_SESSION['login'])){
        exit("<script>location.href='./index.php'</script>");
    }

    if(isset($_POST['cpass'], $_POST['npass'], $_POST['rnpass'])){
        if(strlen(trim($_POST['npass'])) < 4 || strlen(trim($_POST['rnpass'])) < 4){
            exit("<script>alert('pw is too short');location.href='./password.php'</script>");
        }
        
        $cpass = hash('sha256', $_POST['cpass']);
        $npass = hash('sha256', $_POST['npass']);
        $rnpass = hash('sha256', $_POST['rnpass']);
        $password = mysqli_fetch_row(mysqli_query($conn, "SELECT password FROM `users` WHERE 1"));
        
        if($password[0] === $cpass && $npass === $rnpass){
            $query = "UPDATE `users` SET password='$npass' WHERE password='$cpass'";
            mysqli_query($conn, $query) or die('change error');
            exit("<script>alert('success');location.href='./home.php'</script>");
        }
        else {
            exit("<script>alert('wrong');location.href='./password.php'</script>");
        }
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./assets/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="./style.css" rel="stylesheet" type="text/css">
        <title>change password</title>
    </head>
    <body>
        <div class="section">
            <div class="container">
                <div class="row">
                    <center>
                    <div class="col-md-12">
                    	<img class="text-center" class="logo" src="./assets/Logo.png" style="width:100px; height: 100px;">
                        <p class="text-center lead">change password</p>
                    </div>
                    </center>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <form id="myform" method="POST">
                            <div class="form-group">
                                <label class="control-label">Enter current password</label>
                                <input class="form-control" placeholder="Enter current password" name="cpass">
                            </div>
                            <div class="form-group">
                                <label class="control-label">New password</label>
                                <input class="form-control" placeholder="New password" name="npass">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Re-enter new password</label>
                                <input class="form-control" placeholder="Re-enter new password" name="rnpass">
                            </div>
                            <button type="submit" class="btn btn-block btn-default">Submit</button>
                        </form>
                        <button style="width:50%; margin-left:25%;" class="btn btn-block btn-default" onclick="location.href='home.php'">Back</button>
                    </div>
                </div>
            </div>
        </div>
        <center>
        </center>
    </body>
</html>
