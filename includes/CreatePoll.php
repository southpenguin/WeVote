<?php
    require_once 'MySQLdb.php';

    session_start();
    
    $_SESSION['PID'] = 0;
    
    $nextPage = "Location:../pollCreate2.php";
    $thisPage = "Location:../pollCreate1.php";
    $homePage ="Location:../home.php";
    
    if(isset($_SESSION["UID"])){
        $user_id = $_SESSION["UID"];
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
       if(isset($_POST['Cancel'])){
            header($homePage);
            exit();
        }
    }
    
    $name = $_POST['Name'];
    $desc = $_POST['Description'];
    $category = $_POST['Category'];
    
    
    $year = $_POST['Year'];
    $month = $_POST['Month'];
    $day = $_POST['Day'];
    $hour = $_POST['Hour'];

    
    if(isset($_POST['Privacy'])){
        $privacy = $_POST['Privacy'];
    }else{
        $privacy = 'private';                //default is public;    
    }
    
    $end_date = $year.'-'.$month.'-'.$day.'-'.$hour.':00:00';
    
    ///////error handle///////
    $error = false;
    
    if($name == ""){
        $error = true;
    }
    
    
    if($error){
        header($thisPage);
        exit();
    }

    $poll_id ="";
    
    $sql = "insert into poll values(null,?,?,current_timestamp,?,?,?,0)";
    if($stmt = $db->prepare($sql)){
        $stmt->bind_param("sssss",$category,$name,$end_date,$desc,$privacy);
        $stmt->execute();
        $poll_id = mysqli_insert_id($db);
        
    }else{
        
        exit();
    }
   
    $_SESSION["PID"] = $poll_id;
    
    $sql = "insert into user_create_poll values(?,?)";
    if($stmt = $db->prepare($sql)){
        $stmt->bind_param("ii",$user_id,$poll_id);
        $stmt->execute();
        
    }else{
        
        exit();
    }     

    
    header($nextPage);
    