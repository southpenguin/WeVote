<?php
require_once 'image_check.php';
require_once 'MySQLdb.php';

session_start();
  
$thisPage = "Location:../pollCreate2.php";
$nextPage = "Location:../home.php";
  
if($_SERVER['REQUEST_METHOD'] == "POST"){
     if(isset($_POST['Finish_Adding'])){
            header($nextPage);
            exit();
        }
}

$poll_id = $_SESSION["PID"];

$name = $_POST["Name"];
$link = $_POST["Link"];
$description = $_POST["Description"];
$item_id = 1;   //this is for test
  
$msg='';


if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $sql = "insert into poll_item values(null,?,0,?,?,null,?,0)";
    if($stmt = $db->prepare($sql)){
        $stmt->bind_param("isss",$poll_id,$name,$link,$description);
        $stmt->execute();
        $item_id = mysqli_insert_id($db);
    }
    
    
$name = $_FILES['file']['name'];
$size = $_FILES['file']['size'];
$tmp = $_FILES['file']['tmp_name'];
$ext = getExtension($name);

if(strlen($name) > 0)
{

if(in_array($ext,$valid_formats))
{
 
if($size<(1024*1024))
{
include('s3_config.php');
//Rename image name. 
$actual_image_name = time().".".$ext;

$actual_image_name = $poll_id.'/'.$item_id.'/'.$actual_image_name;

if($s3->putObjectFile($tmp, $bucket , $actual_image_name, S3::ACL_PUBLIC_READ) )
{
$msg = "S3 Upload Successful.";	
$s3file='http://s3.amazonaws.com/'.$bucket.'/'.$actual_image_name;
//echo "<img src='$s3file' style='max-width:400px'/><br/>";
//echo '<b>S3 File URL:</b>'.$s3file;

}
else
$msg = "S3 Upload Fail.";


}
else
$msg = "Image size Max 1 MB";

}
else
$msg = "Invalid file, please upload image file.";

}
else
$msg = "Please select image file.";




    $sql = "update poll_item set store_path = ? where item_id = ? and poll_id = ?";
    if($stmt = $db->prepare($sql)){
        $stmt->bind_param("sii",$s3file,$item_id,$poll_id);
        $stmt->execute();
    }



header($thisPage);



}


