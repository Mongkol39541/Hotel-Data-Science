<?php
session_start();
$open_connect = 1;
require("connect.php");

if(
    !isset($_SESSION['id_account']) ||
    $_SESSION['role_account'] != "recep"){
        die(header("Location: index.php"));
    }elseif(isset($_GET['logout'])){
        session_destroy();
        die(header("Location: index.php"));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Recep Page</h1>
    <a href="recep.php?logout=1">Log out</a>
</body>
</html>