<?php

    require_once 'includes/Methods.php';
    
    session_start();
    
    if(!isset($_SESSION["UID"])){
        header("Location:index.php");
    }

    $poll_id = $_SESSION['PID'];
    
    $user = $method->UserInfo($_SESSION["UID"]);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create Vote</title>
        <link rel ="stylesheet" href="css/style.css">
        <script src="http://connect.facebook.net/en_US/all.js"></script>
        <script>
        FB.init({
        appId:'743420882374189',
        cookie:true,
        status:true,
        xfbml:true
        });

        function FacebookInviteFriends()
        {
        FB.ui({
        method: 'apprequests',
        message: 'Your Message diaolog'
        },function(response) {
            console.log(response);
        });
        }
        </script>
        
</head>
    <body>
        <div id ="navigation">
            <div id="topcontent">
                <div id="logo">
                    <a href="index.php"><font color="#F0F0F0">WeVote</font></a>
                </div>
                
                <div id="hometop">
                    <ul>
                    <li><a href="home.php?id=1">Home</a></li>
                    <li><a href="pollCreate1.php">Create</a></li>       
                    <li><a href ="profileView.php">Profile</a></li>
                    <li><a href ="index.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        
        <div id="content">
            <div class="create-center">
                <div class="actual-content">
                    <h2>Add Item</h2>
                    <form method="post" action="includes/AddItems.php" id = "voteForm" enctype="multipart/form-data">
                        <input class="item" type ="text" name ="Name" placeholder="Name">
                        <input class="item" type ="text" name ="Link" placeholder="Link">
                        <span id="fileChooseText">Please choose a image file for your item.</span>
                        <input id="fileChoose" type ="file" name ="file"> 

                        <textarea name="Description" form = "voteForm" class="textarea" placeholder="Add some description to this item"></textarea>

                        <input class="submit buttonleft" type ="submit" name ="Add_Item" value ="Add Item"><br>
                        <input class="submit buttonright" type ="submit" name ="Finish_Adding" value ="Finish"><br>
                    </form>
                    
                    <?php if($method->PrivatePoll($poll_id)){ ?>
                        <div id="fb-root"></div>
                        <a href='#' onclick="FacebookInviteFriends();"> 
                        Facebook Invite Friends Link
                        </a>
                     <?php }?>
                    
                    <h4>Items In This Vote Activity</h4>
                    <?php
                        $method->ShowItems($poll_id);
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
