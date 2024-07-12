<?php
  error_reporting(0);
  session_start();
  include 'config.php';

  if(isset($_SESSION['login'])){
    exit("<script>location.href='./home.php'</script>");
  }

  if(isset($_GET['type'])){
    if($_GET['type'] === 'new'){ // new contents
      $fdate = $ldate = 'new file';
    }
    else if(isset($_GET['idx']) && $_GET['type'] === 'edit'){ // contents edit
      $idx = (int)$_GET['idx'];
      $table = $_SESSION['instant'];
      $query = "SELECT * FROM `$table` WHERE idx='".$idx."'";
      $row = mysqli_fetch_assoc(mysqli_query($conn, $query));

      if($row){
        $fdate = $row['fdate'];
        $ldate = $row['ldate'];
        $contents = $row['contents'];
        $delete = "./delete.php?idx=".$idx;
      }
      else {
        exit("<script>location.href='./home.php'</script>");
      }
    }
    else {
      exit("<script>location.href = './home.php'</script>");
    }
  }


?>

<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="js/jquery.min.js"></script>

    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">-->
    <link href="./assets/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="./style.css" rel="stylesheet" type="text/css">

    <title>online notepad</title>

    <script type="text/javascript" language="javascript">
        $(document).ready(function () {
            $("#send").click(function () {
                $.post("save.php", {
                    idx: <?= "\"$idx\"" ?>,
                    contents: $("#contents").val()
                },
                    function (data, status) {
                        $("#result").html(data);
                    });
            });
        });
    </script>
</head>

<body>
    <div class="section">
        <center>
            <h1>online notepad</h1>
        </center><br>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <a class="btn btn-block btn-default btn-lg" onclick="checkif()">Home</a>
                    <input type="button" id="login_send" name="login_save" value="Login and Save" onclick="location.href='login_save.php'"
                        class="btn btn-block btn-default btn-lg">
                    <input type="button" id="send" name="save_for_now" value="Save for now" 
                        class="btn btn-block btn-default btn-lg">
                    <?php if($_GET['type'] === "edit"){ ?>
                    <a class="btn btn-block btn-default btn-lg" href=<?="\" $delete\""?>>delete</a>
                    <?php } ?>
                    <br><br>
                    <div class="jumbotron">
                        <center>
                            <img src="./assets/Logo.png" class="logo" style="width:100px; height: 100px;">
                            <div id='result' style="color: black;">
                                <?php
                    echo $fdate."<br>".$ldate;
                  ?>
                            </div>
                        </center>
                    </div>
                </div>
                <div class="col-md-8">
                    <textarea placeholder="contents" id="contents" style="height:50%;"
                        class="form-control"><?=$contents?></textarea>
                </div>
            </div>
        </div>
    </div>

    <main>
        <div class="container mt-3">
            <h1 style="color: rgb(79, 76, 118);">Speech to text</h1>
            <div class="flex">
                <div class="float-right">
                    <button id="start_button">
                        <img id="start_img" src="images/mic.gif" alt="Start">
                    </button>
                </div>
                <div id="info"></div>
            </div>
            <div id="results">
                <span id="final_span" class="final"></span>
                <span id="interim_span" class="interim"></span>
                <p>
            </div>
            <div class="col-12 p-0 m-0">
                <div class="row col-12 col-md-8 col-lg-6 p-0 m-0">
                    <select id="select_language"></select>
                    <select id="select_dialect"></select>
                </div>
                <div class="col-12 col-md-4 col-lg-6 mt-3 mt-md-0 p-0 m-0">
                    <div class="float-right">
                        <button id="copy_button" class="btn btn-primary ">Copy</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="js/languages.js"></script>
    <script src="js/web-speech-api.js"></script>

    <br><br>

    <div class="middle">

    <hr>

    <h1 style="text-align:center; font-size:25px; color: rgb(79, 76, 118);">Unsaved Notes</h1>
    <br>
    <div class="row">
        <?php
                        $i = 0;
                        $table =  $_SESSION['instant'];
                        $query = mysqli_query($conn, "SELECT * FROM `$table` ORDER BY idx DESC");
                        $j = mysqli_num_rows($query);

        		        while($row = mysqli_fetch_assoc($query)){
                            $i = ($i == 4) ? 0 : $i + 1;
        		        	echo "<div class='col-md-3'>
        		        	<a href='./instant.php?type=edit&idx=".$row['idx']."'>
        		        	<img src='./assets/notepad.bmp' class='img-responsive'></a>
        		        	<p>".$j--."</p></div>";
        		        }
        		        mysqli_close($conn);
                    ?>
    </div>

    </div>

    <br><br>

    <script>
        function checkif() {
            content = document.getElementById("contents").innerHTML;
            console.log(content);
            if (content !== '') {
                if (confirm("Your content will be lost if not saved."))
                    window.location.href = './home.php';
                else
                    return;
            }
            else { window.location.href = './home.php'; }
        }
    </script>
</body>

</html>