<?php
    require_once 'MySQLdb.php';
    session_start();
    $uid = $_SESSION["UID"];
    $item_id = $_POST["itemid"];
    $poll_id = $_POST["pollid"];
    $voterpoints = $_POST["points"];
    
    $user_ids = array();
    $sql = "select user_id from user_join_item where item_id = ?";
    if($stmt = $db->prepare($sql)){
        $stmt->bind_param("i",$item_id);
        $stmt->execute();
        $stmt->bind_result($userid);
        while($stmt->fetch()){
            $user_ids[] = $userid;
        }        
    }
    
    
    foreach($user_ids as $id){
        $sql4 = "update user set points = points + 1 where user_id = ?";
        if($stmt4 = $db->prepare($sql4)){
            $stmt4->bind_param("i",$id);
            $stmt4->execute();
        }
    }
    
    $sql = "update poll set closed = 1 where poll_id = ?";
    if($stmt = $db->prepare($sql)){
        $stmt->bind_param("i",$poll_id);
        $stmt->execute();
    }
    
    
    header ("Location:../pollView.php?id=".$poll_id);