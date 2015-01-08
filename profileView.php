<?php 

    require_once 'includes/Methods.php';
    session_start();
    
    if(!isset($_SESSION["UID"])){
        header("Location:index.php");
    }
    $user = $method->UserInfo($_SESSION["UID"]);
    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Profile</title>
        <link rel ="stylesheet" href="css/style.css">
        <link rel ="stylesheet" href="css/profile.css">
    </head>
    <body>
        <div id ="navigation">
            <div id="topcontent">
                <div id="logo">
                    <a href="index.php"><font color="#F0F0F0">WeVote</font></a>
                </div>
                
                <div id="hometop">
                    <ul class="topnav">
                    <li><a href="home.php?id=1">Home</a></li>
                    <li><a href="pollCreate1.php">Create</a></li>
                    <li><a href ="profileView.php">Profile</a></li>
                    <li><a href ="index.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div id="content">
            <div class="center">
            <div id="potrait">
                <img src="<?php echo "http://graph.facebook.com/".$_SESSION["FID"]."/picture"."?type=large" ?>" width="200" height="200">
            </div>
            <div id="profile">
                
                <div id="bio">
                    <ul>
                        <h3>
                            Welcome to WeVote!
                        </h3>
                        <li id="name">
                            Name: <?php echo $user["firstname"].' '.$user["lastname"];?>
                        </li>
                        <li>
                            Gender: <?php echo $user["gender"];?>
                        </li>
                        <li>
                            Birthday: <?php echo $user["birthday"]?>
                        </li>
                        <li>
                            Account Created At: <?php echo $user["date"]?>
                        </li>
                    </ul>
                </div>
            </div>
            </div>
        </div>
        
    </body>
</html>
