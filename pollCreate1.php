<?php   
    require_once 'includes/Methods.php';
    session_start();
    
    if(!isset($_SESSION["UID"])){
        header("Location:index.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Create Vote</title>
        <link rel ="stylesheet" href="css/style.css">
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
        <h2>Create Your Poll!</h2>
        <form action ="includes/CreatePoll.php" method="post" id="voteForm">
            <input id="activityName" type="text" name="Name" placeholder="Create a name for your poll">
            <br/><span>Close Your Poll at:</span>
            <div class="select">
                
            <select name="Year" id="year" value = "year">
                    <option value="0" selected="1">Year</option>
                    <option value="2014">2014</option>                    
            </select>    
                
                
            <select name="Month" id="month" value ="month">
                    
                    <option value="0" selected="1" class="selection">Month</option>
                    <option value="1">Jan</option>
                    <option value="2">Feb</option>
                    <option value="3">Mar</option>
                    <option value="4">Apr</option>
                    <option value="5">May</option>
                    <option value="6">Jun</option>
                    <option value="7">Jul</option>
                    <option value="8">Aug</option>
                    <option value="9">Sep</option>
                    <option value="10">Oct</option>
                    <option value="11">Nov</option>
                    <option value="12">Dec</option>
                </select>
                
                <select name="Day" id="day" value ="day">
                    <option value="0" selected="1">Day</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                </select>
            
                <select name="Hour" id="hour" value = "hour">
                    <option value="0" selected="1">Hour</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="0">0</option>
                </select>
            
                
            </div>
            <div class="select">
                <select name="Category" id="category" value = "category">
                    <option value="1" selected="1">Category</option>
                    <?php $method->Category();?>
                </select>
                
            </div>
            
            <div id="privacy">
            <input id="public" type="radio" name="Privacy" value="Public">Public
            <input id="private" type="radio" name="Privacy" value="Private">Private
            </div>
            
            <textarea name="Description" form = "voteForm" class="textarea" placeholder="Add some discription to your vote."></textarea>
            <input class="submit"  type="submit" name="Submit" value="Create Activity">
            <input class="submit" type ="submit" name="Cancel" value ="Cancel">
            
        </form>
            </div>
            </div>
        </div>
    </body>
</html>
