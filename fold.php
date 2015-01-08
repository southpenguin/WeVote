<?php
    $uid = $_SESSION["UID"];
    include 'includes/MySQLdb.php';
    $sql2 = "SELECT comment_person_id, comment_date, comment_content, firstname, lastname, points,fb_id FROM item_comment, user WHERE item_comment.comment_person_id = user.user_id AND item_id = ? ORDER BY comment_date;";
    $stmt2 = $db->prepare($sql2);
    $stmt2->bind_param("i", $item_id);
    $stmt2->execute();
    $stmt2->bind_result($comment_person_id, $comment_date, $comment_content, $firstname, $lastname, $userpoints, $fb_id);
    $stmt2->store_result();
    $comment_numbers = $stmt2->num_rows;
?>
<div class="buddycloud">  
    <div class="stream">
        <?php 
        
        while ($stmt2->fetch()){
 
            ?>
        <article class="topic">
          <section class="opener">
              <div class="avatar"><img src="<?php echo "http://graph.facebook.com/".$fb_id."/picture"; ?>" width="50px" height="50px"></div>
            <div class="postmeta">
              <span class="time" title="5:06pm 06.06.2011"><?php
                $date1 = new DateTime($comment_date);
                $date2 = new DateTime("now");
                $interval = $date1->diff($date2);
                $days = $interval->d;
                if ($days == 0) {echo "today";} else {echo $days." days";}
              ?></span>
            </div>
            <span class="name"><?php echo $firstname." | ".$userpoints." points";?></span>
            <p>
                <?php echo $comment_content;?>
            </p>
          </section>
        </article><?php }?>
    </div>
</div>


<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/html5slider.js"></script>
<script type="text/javascript" src="js/paperfold.js"></script>
<script type="text/javascript" src="js/ui.js"></script>
