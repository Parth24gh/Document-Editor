<?php
error_reporting(0);

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "parthadmin");
define("DB_NAME", "notepad");

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>
