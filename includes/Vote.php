<?php
    require_once 'MySQLdb.php';
    session_start();
    $uid = $_SESSION["UID"];
    $item_id = $_POST["itemid"];
    $poll_id = $_POST["pollid"];
    $voterpoints = $_POST["points"];
    
    $sql1 = "INSERT INTO user_join_poll VALUES ($uid, $poll_id, CURRENT_TIMESTAMP);";
    $stmt1 = $db->prepare($sql1);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->close();
    
    $sql1 = "UPDATE poll_item SET points = points + $voterpoints, num = num + 1 WHERE item_id = $item_id;";
    $stmt1 = $db->prepare($sql1);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->close();
    
    $sql1 = "INSERT INTO user_join_item VALUES ($item_id, $uid, CURRENT_TIMESTAMP);";
    $stmt1 = $db->prepare($sql1);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->close();
    
    header("Location:../pollView.php?id="."$poll_id");