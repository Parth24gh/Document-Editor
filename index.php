<?php
error_reporting(0);
session_start();
include 'config.php';

if(isset($_SESSION['login'])){
  exit("<script>location.href='./home.php'</script>");
}
/*
else if(isset($_SESSION['instant'])) {
    exit("<script>location.href='./instant.php'</script>");
}

else {
    unset($_POST['instant']);
    unset($_SESSION['instant']);
    mysqli_query($conn, "TRUNCATE TABLE instant");
}
*/

if(isset($_POST['password'], $_POST['username'])){
  $_SESSION['username'] = $_POST['username'];
  $user = $_POST['username'];
  $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `users` WHERE `username` = '$user' "));

  if(hash('sha256', $_POST['password']) === $result['password']){
    $_SESSION['login'] = 'login_ok';
    exit("<script>location.href = './home.php'</script>");
  }
  else {
    echo "Credential Wrong.";
    $fp = fopen('access_log.txt', 'a+');
    $log = date("Y-m-d H:i:s").' ('.$_SERVER['REMOTE_ADDR'].'), access_password : '.$_POST['password']."\r\n";
    fwrite($fp, $log);
    fclose($fp);
  }
}

if(isset($_POST['instant'])) {
    $_SESSION['instant'] = 'instant';
    exit("<script>location.href='./instant.php'</script>");
}

?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="online notepad">
    <meta property="og:description" content="online notepad">
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <link href="./style.css" rel="stylesheet" type="text/css">
    <link href="./assets/bootstrap.css" rel="stylesheet" type="text/css">
    <title>login</title>
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
                                <input id="instant" type="submit" name="instant" value="Instant Note">
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

            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                        <div id="create-acc">
                            <p style="font-size:17px; color:white;">Be A User:</p>
                            <button onclick="change()"> Create an Account </button>
                        </div><br>
                        <div id="create-acc-form">
                        <form role="form" method="post" action="create.php">
                            <div class="form-group">
                                <div class="input-group input-group-lg">
                                    <input type="text" class="create-control" placeholder="USERNAME" 
                                        name="createuser" required>
                                    <input id="pass1" type="password" class="create-control" placeholder="PASSWORD"
                                        name="createpass" oninput="passcheck()" required>
                                    <input id="pass2" type="password" class="create-control" placeholder="CONFIRM PASSWORD"
                                        name="confirmpass" oninput="passcheck()" required>
                                    <br><br>
                                    <div id="create-btn"><input id="create-submit" type="submit" value="Create" disabled="true"></div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function passcheck()
        {
            var pass1 = document.querySelector("input[name='createpass']").value;
            var pass2 = document.querySelector("input[name='confirmpass']").value;

            if(pass1 == null || pass2 == null || pass1 == " " || pass2 == " ")
            {
                document.getElementById("create-submit").disabled = true;
            }

            else
            {
                if(pass1 === pass2)
                {
                    document.getElementById("create-submit").disabled = false;
                }
                else 
                {
                    document.getElementById("create-submit").disabled = true;
                }
            }

        }


        function change()
        {
            document.getElementById("create-acc-form").style="display:block;";
        }
    </script>

</body>

</html>