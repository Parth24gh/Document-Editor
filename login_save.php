<?php
error_reporting(0);
session_start();
include 'config.php';

if(isset($_SESSION['login'])){
  exit("<script>location.href='./home.php'</script>");
}

if(isset($_POST['password'], $_POST['username'])){
  $_SESSION['username'] = $_POST['username'];
  $user = $_POST['username'];
  $table = $_POST['instant'];
  $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `users` WHERE `username` = '$user' "));

  if(hash('sha256', $_POST['password']) === $result['password']){
    $_SESSION['login'] = 'login_ok';
    if(mysqli_query($conn, "INSERT INTO `$user` (fdate, ldate, contents) SELECT fdate, ldate, content FROM `$table`"))
    {
        mysqli_query($conn, "TRUNCATE TABLE instant");
        unset($_POST['instant']);
        unset($_SESSION['instant']);
        echo "<script>alert('Notes Transferred Successfully.');</script>";
        exit("<script>location.href = './home.php'</script>");
    }
  }
  else {
    echo "Credential Wrong.";
    $fp = fopen('access_log.txt', 'a+');
    $log = date("Y-m-d H:i:s").' ('.$_SERVER['REMOTE_ADDR'].'), access_password : '.$_POST['password']."\r\n";
    fwrite($fp, $log);
    fclose($fp);
   }
}
?>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Instant Note</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="">

    <link href="./style.css" rel="stylesheet" type="text/css">
    <link href="./assets/bootstrap.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="section">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Notepad</h1>
                <hr>
            </div>
        </div>
            
        
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <form role="form" method="post">
                    <div class="form-group">
                        <div class="">
                            <br><br>
                            <input type="text" class="create-control" placeholder="USERNAME" name="username">
                            <input type="password" class="create-control" placeholder="PASSWORD" name="password">
                            <br><br>
                            <div id="create-btn"><input type="submit" value="Login" class="btn btn-success"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    </div>

    <script src="" async defer></script>
</body>

</html>