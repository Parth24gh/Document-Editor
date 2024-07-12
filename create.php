<?php

include 'config.php';

if(isset($_POST['createuser'],$_POST['createpass']))
{
    $name = $_POST['createuser'];
    $pass = hash('sha256', $_POST['createpass']);

    $query = "SELECT * FROM `users` WHERE `username` = ?";
    
    $stmt = $conn->prepare($query);
    echo "<script>console.log('done1 " . $name . " " . $pass . " " . $query . "');</script>";
    $stmt->bind_param('s', $name); /*The letter 's' specifies that the parameter is expected to be a string*/
    $stmt->execute();
    $checkuser = $stmt->get_result();

    echo "<script>console.log('done2 " . $name . " " . $pass . " " . $checkuser->num_rows. "');</script>";
        
    /*$checkuser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `username` FROM `users` WHERE `username` = '$name' "));*/

    if ($checkuser->num_rows > 0)
        {
            echo "<script>console.log('not_done1 " . $name . " " . $pass ." ');</script>";
            echo "<script>alert('Try a different username');</script>";
            exit("<script>location.href='./index.php'</script>");
        }
    
    //just for the precaution that no usernames are as 'users', coz thats the name of the table consisting user credentials. (one more condition)
    $query1 = "SELECT * FROM ?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param('s', $name);
    $stmt1->execute();
    $checktable = $stmt1->get_result();
    echo "<script>console.log('done3 " . $name . " " . $pass . " " . $checktable->num_rows. "');</script>";
    if ($checktable->num_rows > 0)
    {
        echo "<script>console.log('not_done2 " . $name . " " . $pass ." ');</script>";
        echo "<script>alert('Try a different username');</script>";
        exit("<script>location.href='./index.php'</script>");
    }
    
    echo "<script>console.log('done4');</script>";

    if(mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `$name` (`idx` int(11) NOT NULL AUTO_INCREMENT, `fdate` varchar(50) NOT NULL, `ldate` varchar(50) NOT NULL,`contents` mediumtext NOT NULL, PRIMARY KEY (`idx`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 "))
    {
        echo "<script>console.log('done5 " . $name . " " . $pass ." ');</script>";
        if(mysqli_query($conn, "INSERT INTO `users` (`username`, `password`) VALUES ('$name', '$pass')"))
            {
                echo "<script>console.log('done6 " . $name . " " . $pass ." ');</script>";
                echo "<script>alert('Registration Successfully. Please login.');</script>";
                exit("<script>location.href='./index.php'</script>");
            }
        else
            {
                echo "<script>console.log('Insertion not possible : ". $name . " " . $pass ." ');</script>";
                mysqli_query($conn, "drop table if exists `$name`");
                echo "<script> alert('Error Creating the user. Try again.'); location.href='./index.php' </script>";
            }
    }
    else
    {
        echo "<script>console.log('drop_table_direct ". $name . " " . $pass ." ');</script>";
        mysqli_query($conn, "drop table if exists `$name`");
        echo "<script> alert('Error. Please try again.'); location.href='./index.php' </script>";
    }
}
else
{
    echo "<script> alert('Username OR Password not set'); location.href='./index.php' </script>";
}

?>