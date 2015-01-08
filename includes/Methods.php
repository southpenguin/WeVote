<?php
    require_once 'MySQLdb.php';
    
    class Methods{
        
        public function showPublicPolls($amt){
            global $db;
                        
            $sql = "select a.poll_id,a.name,a.create_date,b.store_path,sum(b.points), c.firstname
                    from poll a, poll_item b, user c, user_create_poll d
                    where a.poll_id = b.poll_id AND privacy = 'Public' AND d.poll_id = a.poll_id AND d.user_id = c.user_id
                    group by a.poll_id
                    order by create_date desc";
            if($stmt = $db->prepare($sql)){
                $stmt->execute();
                $stmt->bind_result($pid,$name,$create_date,$store_path,$num,$uname);
                
                while($stmt->fetch()){                  
                    
                ?>
                    <li class='group'>
                        <div class="box">
                            <div class="pics"width=200px height=200px>
                                <a href= "">
                                    <img src="<?php 
                                    if($store_path == null){
                                        echo "https://s3.amazonaws.com/wevoteproject/default/default_poll.png";
                                    }else{
                                        echo $store_path;                                    
                                    }
                                    ?>" width=200px height=150px >
                                </a>
                            </div>
                            <div class="links">
                                <a href= "<?php echo "pollView.php?id=".$pid;?>" >
                                    <div class="discription">
                                        <h4><?php echo $name?></h4>
                                        <em class="time"><?php echo $create_date;?></em>
                                    </div>
                                </a>
                            </div>
                            <ul class="box-bottom">
                                <img src="https://s3.amazonaws.com/wevoteproject/default/default_icon.png"width=20px height="20px">
                                <li><?php echo $uname;?></li>
                            </ul>
                        </div>
                    </li>
            <?php
                }
            }   
        }
        
        public function showMine($uid){
            global $db;
                        
            $sql = "select a.poll_id,a.name,a.create_date,b.store_path,sum(b.points), d.firstname
                    from poll a, poll_item b,user_create_poll c, user d
                    where a.poll_id = b.poll_id and a.poll_id = c.poll_id and c.user_id = ? AND c.poll_id = a.poll_id AND d.user_id = c.user_id
                    group by a.poll_id
                    order by create_date";
            if($stmt = $db->prepare($sql)){
                $stmt->bind_param('i',$uid);
                $stmt->execute();
                $stmt->bind_result($pid,$name,$create_date,$store_path,$num, $uname);
                
                while($stmt->fetch()){                  
                    
                ?>
                    <li class='group'>
                        <div class="box">
                            <div class="pics"width=200px height=200px>
                                <a href= "">
                                    <img src="<?php 
                                    if($store_path == null){
                                        echo "https://s3.amazonaws.com/wevoteproject/default/default_poll.png";
                                    }else{
                                        echo $store_path;                                    
                                    }
                                    ?>" width=200px height=150px >
                                </a>
                            </div>
                            <div class="links">
                                <a href= "<?php echo "pollView.php?id=".$pid;?>" >
                                    <div class="discription">
                                        <h4><?php echo $name?></h4>
                                        <em class="time"><?php echo $create_date;?></em>
                                    </div>
                                </a>
                            </div>
                            <ul class="box-bottom">
                                <img src="https://s3.amazonaws.com/wevoteproject/default/default_icon.png"width=20px height="20px">
                                <li><?php 
                                    echo $uname;
                                    ?></li>
                            </ul>
                        </div>
                    </li>
            <?php
                }
            }   
        }
        
        
        public function showPrivatePolls($uid){
            global $db;
                        
            $sql = "select poll.poll_id, poll.name, poll.create_date, poll_item.store_path, SUM(poll_item.points), user.firstname
                    from user_create_poll, poll, user_friends, poll_item, user
                    where user_create_poll.poll_id = poll.poll_id 
                    AND poll.poll_id = poll_item.poll_id
                    AND user.user_id = user_friends.user_id
                    AND poll.privacy = 'Private'
                    AND user_friends.user_id = user_create_poll.user_id 
                    AND user_friends.friend_id = ?
                    GROUP BY poll_item.poll_id";
            if($stmt = $db->prepare($sql)){
                $stmt->bind_param("i",$uid);
                $stmt->execute();
                $stmt->bind_result($pid,$name,$create_date,$store_path,$num,$uname);
                
                while($stmt->fetch()){                  
                    
                ?>
                    <li class='group'>
                        <div class="box">
                            <div class="pics"width=200px height=200px>
                                <a href= "">
                                    <img src="<?php 
                                    if($store_path == null){
                                        echo "https://s3.amazonaws.com/wevoteproject/default/default_poll.png";
                                    }else{
                                        echo $store_path;                                    
                                    }
                                    ?>" width=200px height=150px >
                                </a>
                            </div>
                            <div class="links">
                                <a href= "<?php echo "pollView.php?id=".$pid;?>" >
                                    <div class="discription">
                                        <h4><?php echo $name?></h4>
                                        <em class="time"><?php echo $create_date;?></em>
                                    </div>
                                </a>
                            </div>
                            <ul class="box-bottom">
                                <img src="https://s3.amazonaws.com/wevoteproject/default/default_icon.png"width=20px height="20px">
                                <li><?php echo $uname;?></li>
                            </ul>
                        </div>
                    </li>
            <?php
                }
            }   
        }
        
        public function ShowItems($poll_id){
            global $db;
            
            $sql = "select name,link,store_path,description from poll_item where poll_id = ?";
            $i = 1;
            if($stmt = $db->prepare($sql)){
                $stmt->bind_param("i",$poll_id);
                $stmt->execute();
                $stmt->bind_result($name,$link,$store_path,$description);
                while($stmt->fetch()){
                    ?>
                    <h2>
                        <?php echo "ITEM"." ".$i ?>
                    </h2>
                    <h3>
                        <?php echo $name;?>
                    </h3>
                    <img src="<?php echo $store_path;?>" width="200px"height="200px"><br>
                    URL:<a href="<?php echo $link;?>"><?php echo $link;?></a><br>
                    <p><?php echo $description;?></p>
                    <?php
                    $i++;
                }
            }            
        }
        
        public function UserInfo($uid){
            global $db;
            
            $user = array();
            
            $sql = "select * from user where user_id = ?";
            if($stmt = $db->prepare($sql)){
                $stmt->bind_param("i", $uid);
                $stmt->execute();
                $stmt->bind_result($id,$fid,$email,$pw,$firstname,$lastname,$gender,$birthday,$date, $point);
                $stmt->fetch();
                $user = array('email'=>$email,'firstname'=>$firstname,'lastname'=>$lastname,'gender'=>$gender,'birthday'=>$birthday,'date'=>$date, 'point'=>$point);
                $stmt->close();
            }
            return $user;
            
        }
        
        public function Voted($uid, $pid){
            
            global $db;
            
            $sql0 = "select * from user_join_poll where user_id = ? AND poll_id = ?";
            if($stmt0 = $db->prepare($sql0)){
                $stmt0->bind_param("ii",$uid, $pid);
                $stmt0->execute();
                $stmt0->store_result();
                $irows = $stmt0->num_rows;
                if($irows != 1){
                    return false;
                }else{
                    return true;
                }
            }
        }
        
        public function PrivatePoll($pollid){
            global $db;
            
            $sql0 = "select privacy from poll where poll_id = ?";
             if($stmt0 = $db->prepare($sql0)){
                $stmt0->bind_param("i", $pollid);
                $stmt0->execute();
                $stmt0->bind_result($p);
                $stmt0->fetch();
                if($p == 'Private'){
                    return true;
                }else{
                    return false;
                }
            }       
        }
        
        public function Mine($pollid,$uid){
            global $db;
            
            $sql0 = "select * from user_create_poll where poll_id = ? and user_id = ?";
            if($stmt0 = $db->prepare($sql0)){
                $stmt0->bind_param("ii",$pollid,$uid);
                $stmt0->execute();
                $stmt0->store_result();
                $num = $stmt0->num_rows;
                if($num < 1){
                    return false;
                }else{
                    return true;
                }
                
            }
        }
        
        public function PollClosed($pollid){
            global $db;
            
            $sql0 = "select closed from poll where poll_id = ?";
            if($stmt0 = $db->prepare($sql0)){
                $stmt0->bind_param("i", $pollid);
                $stmt0->execute();
                $stmt0->bind_result($c);
                $stmt0->fetch();
                
                if($c == 1){
                    return true;
                }else{
                    return false;
                }
            }  
        }
        
        public function Category(){
            global $db;
            
            $sql0 = "select * from category";
            if($stmt0 = $db->prepare($sql0)){
                $stmt0->execute();
                $stmt0->bind_result($id,$name);
                while($stmt0->fetch()){?>
                    <option value="<?php echo $id;?>"><?php echo $name;?></option>
                <?php }
        
            }
        }
        
        public function Points($itemid){
            global $db;
            
            $sql0 = "SELECT SUM(points), AVG(points)
                FROM user_join_item, user
                WHERE user.user_id = user_join_item.user_id
                AND item_id = ?;";
            if($stmt0 = $db->prepare($sql0)){
                $stmt0->bind_param("i", $itemid);
                $stmt0->execute();
                $stmt0->bind_result($sumpoints, $avgpoints);
                $stmt0->fetch();
                $pointss = array();
                $pointss[] = $sumpoints;
                $pointss[] = $avgpoints;
        
            }
            return $pointss;
        }
        
        
        
    }
    
    $method = new Methods();
?>
