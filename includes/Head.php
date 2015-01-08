<?php
    require_once 'fbconfig.php';
    require_once 'Methods.php';
    if(!isset($_SESSION["UID"])){
        header("Location:./index.php");
    }
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">