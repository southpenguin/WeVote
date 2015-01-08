<?php
    session_start();
    
    require_once 'MySQLdb.php';
    
    $homePage ="Location:../home.php?id="."1";
    $indexPage ="Location:../index.php";
    
    
    $email = $_POST['Email'];
    $pw = $_POST['Password'];
    ///////error handle//////
    $errMsg = array();      //store the error message
    $errFlag = false;       //if it is err occur
    
    if($email == ''){
        $errMsg[] = "Email cannot be empty!";
        //$errFlag = true;
    }
    
    if($pw == ''){
        $errMsg[] = "Password cannot be empty!";
        $errFlag = true;
    }
    if(strpos($email,'@') == false){
        $errMsg[] = "Email format is wrong!";
    }
    
    if($errFlag){
        $_SESSION['ErrMsg'] = $errMsg;
        header($indexPage);
        exit();
    }
    
    /////login handle//////
    $sql = "select user_id from user where email = ? and pw = ?";
    $stmt = $db->prepare($sql);
    
    $stmt->bind_param("ss", $email, $pw);
    $stmt->execute();
    $stmt->bind_result($uid);
    $stmt->store_result();
    
    if($stmt->num_rows != 1){
        $errMsg[] = "No such user is found!";
        $_SESSION['ErrMsg'] = $errMsg;
        header($indexPage);
        exit();
    }else{
        $stmt->fetch();
        $_SESSION["UID"] = $uid;
        header($homePage);
        
        exit();
    }
    
           
    
    
    
    
