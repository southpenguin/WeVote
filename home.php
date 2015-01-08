<?php
    require_once 'includes/fbconfig.php';
    
    require 'includes/Methods.php';
    
    if(!isset($_SESSION["UID"])){
        header("Location:index.php");
    }
    $id = $_GET["id"];
    
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Home Page</title>
        <link rel ="stylesheet" href="css/style.css">
    </head>
    <body>
        <div id ="navigation">
            <div id="topcontent">
                <div id="logo">
                    <a href="index.php"><font color="#F0F0F0">WeVote</font></a>
                </div>
                
                <div id="hometop">
                    <nav role="navigation">
                    <ul class="topnav">
                    <li><a href="home.php?id=1">Home</a></li>
                    <li><a href="pollCreate1.php">Create</a></li>
                    <li><a href ="profileView.php">Profile</a></li>
                    <li><a href ="index.php">Logout</a></li>
                    </ul>
                    </nav>
                </div>
            </div>
        </div>
        
        <div id="content">
            <ul>
                <li><a href="home.php?id=0">Mine</a></li>
                <li><a href="home.php?id=2">Private</a></li>
                <li><a href="home.php?id=1">Public</a></li>
            </ul>
            <ol>

                
              
         <?php 
         if($id == 1){
            $method->showPublicPolls(10);
         }else if($id == 0){
             $method->showMine($_SESSION["UID"]);
         }else if ($id == 2){
             $method->showPrivatePolls($_SESSION["UID"]);
         }
         
         ?>
                
                
   

  </ol>
	</div>
        
    </body>
</html>
