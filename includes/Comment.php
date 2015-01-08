<?php
    require_once 'MySQLdb.php';
    session_start();
    $uid = $_SESSION["UID"];
    $item_id = $_POST["itemid"];
    $poll_id = $_POST["pollid"];
    $content = $_POST["newcomment"];
    $sql1 = "INSERT INTO item_comment VALUES ('$item_id', '$uid', CURRENT_TIMESTAMP, ?);";
    $stmt1 = $db->prepare($sql1);
    $stmt1->bind_param("s", $content);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->close();
    header("Location:../pollView.php?id="."$poll_id");