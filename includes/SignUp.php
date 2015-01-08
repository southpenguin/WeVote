<?php
    session_start();
    
    require_once 'MySQLdb.php';
    
    $homePage ="Location:../home.php";         //home page
    $indexPage ="Location:../index.php";       //index page
    
    
    $firstname = $_POST["FirstName"];
    $lastname = $_POST["LastName"];
    $email = $_POST["Email"];
    $pw = $_POST["Password"];
    $re_pw = $_POST["Reenter_Password"];
    $month = $_POST["Month"];
    $day = $_POST["Day"];
    $year = $_POST["Year"];
    $gender = ""; 
    
    $birthday = $year."-".$month."-".$day;
    if(isset($_POST["Gender"]))
        $gender = $_POST["Gender"];
    
       
    
    ////error handle/////
    $errMsg = array();
    if($gender == "" || $firstname == "" || $lastname == "" || $email == "" || $pw == "" || $re_pw == "" || $month == '0' || $day == '0' || $year == '0'){
        $errMsg[] = "Please fill all the infromation!";
        exit();
    }

    if($pw != $re_pw){
        $errMsg[] = "Please enter the same password!";
        exit();
    }
    
    /////sign up/////
    $sql = "insert into user values(null, null, ?, ?, ?, ?, ?, ?, current_timestamp, 0)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ssssss", $email, $pw, $firstname, $lastname, $gender, $birthday);
    $stmt->execute();
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    