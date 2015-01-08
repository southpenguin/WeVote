<?php 
    
    require_once 'includes/fbconfig.php';
    require_once 'includes/Methods.php';
    if(!isset($_SESSION["UID"])){
        header("Location:index.php");
    }
    
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <?php 
    session_start();
    $pollid = $_GET['id'];
    $sql = "SELECT name FROM poll WHERE poll_id = ?;";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $pollid);
    $stmt->execute();
    $stmt->bind_result($poll_name);
    $stmt->fetch();
    $stmt->close();
    
    
    $sql = "SELECT item_id, points, name, link, store_path, description, num FROM poll_item WHERE poll_id = ?;";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $pollid);
    $stmt->execute();
    $stmt->bind_result($item_id, $points, $name, $link, $store_path, $description, $num);
    $stmt->store_result();
    $itemnumbers = $stmt->num_rows;
?>
        <title>View Vote Activity</title>
        <link id="pagestyle" rel ="stylesheet" type ="text/css" href="css/style1.css">
        <link href="css/buddycloud.css" rel="stylesheet">
        <link href="css/paperfold.css" rel="stylesheet">
        <script type="text/javascript" src="js/modernizr.custom.71147.js"></script>
        <script type="text/javascript" src="js/prefixfree.min.js"></script>

        <script type="text/javascript">
        var columnNumber = <?php echo $itemnumbers;?>;   //change this number to the column numbers, return from php
        if (columnNumber == 2 || columnNumber == 4){
            document.getElementById("pagestyle").setAttribute("href", "css/style2.css");
        }
        </script>
    </head>
    
    <body>
       <div id ="navigation">
            <div id="topcontent">
                <div id="logo">
                    <a href="home.php">WeVote</a>
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
            
            <ul>
                <div class="votetitle">
                <li><?php echo $poll_name;?></li>
                </div>
            </ul>
            
            <ol>
                <?php
                while ($stmt->fetch()) { ?>
                <li class="items">
                    <div class="itembox">
                        <div class="itempics">
                            <?php if(substr($link, 0, 4) != "http") $link = "http://".$link;?>
                            <a href= "<?php echo $link;?>">
                                <img class="imgs" src="<?php echo $store_path;?>" />
                            </a>
                        </div>
                        
                        <?php if($method->PollClosed($pollid) == false){?>    
                            <?php if($method->Mine($pollid,$_SESSION["UID"]) == false){?>   
                            <form action="includes/Vote.php" method="post">                        

                                <input type="hidden" name="points" value="<?php echo $points;?>">
                                <input type="hidden" name="itemid" value="<?php echo $item_id;?>">
                                <input type="hidden" name="pollid" value="<?php echo $pollid;?>">
                                
                                <?php if($method->Voted($_SESSION["UID"], $pollid) == false){?>
                                <input class="button selectitem" id="vote" type="submit" name="selectitem" value="Vote">
                                <?php }else{?>
                                <input class="button selectitem" id="vote" type="button" name="selectitem" value="Voted">

                                <?php }?>
                            </form>                 
                            <?php }else{?>
                            <form action="includes/GivePoints.php" method="post">
                                <input type="hidden" name="points" value="<?php echo $points;?>">
                                <input type="hidden" name="itemid" value="<?php echo $item_id;?>">
                                <input type="hidden" name="pollid" value="<?php echo $pollid;?>">
                                
                                <input class="button selectitem" id="vote" type="submit" name="givepoints" value="Give Points">
                                
                            </form>
   
                            <?php }
                        }else{?>
                            <input class="button selectitem" id="vote" type="button" name="" value="Points Are Already Given!">
                                
                        <?php }?>
                             

                        <div class="comments">
                            <?php include "fold.php";?>
                        </div>
                        <ul class="stats">
                            <img src="pics/d1.png">
                            <li> <?php echo $comment_numbers;?>  |  <?php echo $num; if ($num == 1){echo " Vote";}else{echo " Votes";}?></li>
                            <li> <?php $pointsss = $method->Points($item_id);
                            if($pointsss[0] == null){
                                echo "Total: "."0";
                            }else {
                                echo "Total: ".$pointsss[0];
                            }
                            if ($pointsss[1] == null){
                                echo " | AVG: "."0.00";
                            }else{
                                echo " | AVG: ".number_format($pointsss[1],2,'.','');
                            }
                            ?>
                            </li>
                        </ul>
                        
                        <div class="commentarea">
                            <form action="includes/Comment.php" method="post">
                                <input type="hidden" name="itemid" value="<?php echo $item_id;?>">
                                <input type="hidden" name="pollid" value="<?php echo $pollid;?>">
                                <textarea class="newcomment" name="newcomment"  class="textarea" placeholder="Enter your comment"></textarea>
                                <input class="button commentitem" type="submit" name="selectitem" value="Comment">
                            </form>
                        </div>
                       
                    </div>
                </li>
                
                <?php }?>
                
                
            </ol>
	</div>
        

    </body>

</html>
