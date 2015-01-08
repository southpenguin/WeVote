<?php
 
session_start();
require_once 'MySQLdb.php';

require_once 'Facebook/Entities/AccessToken.php';
require_once 'Facebook/FacebookSession.php';
require_once 'Facebook/FacebookRedirectLoginHelper.php';
require_once 'Facebook/FacebookRequest.php';
require_once 'Facebook/FacebookResponse.php';
require_once 'Facebook/FacebookSDKException.php';
require_once 'Facebook/FacebookRequestException.php';
require_once 'Facebook/FacebookAuthorizationException.php';
require_once 'Facebook/GraphObject.php';
require_once 'Facebook/GraphUser.php';
require_once 'Facebook/GraphSessionInfo.php';
require_once 'Facebook/HttpClients/FacebookCurl.php';
require_once 'Facebook/HttpClients/FacebookHttpable.php';
require_once 'Facebook/HttpClients/FacebookCurlHttpClient.php';


use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\GraphSessionInfo;


$appId = '';
$appSecret = '';

FacebookSession::setDefaultApplication($appId, $appSecret);

$helper = new FacebookRedirectLoginHelper("http://default-environment-gbkpedbpep.elasticbeanstalk.com/home.php?id=1");

try{
    $session = $helper->getSessionFromRedirect();
    
}catch(FacebookRequestException $ex) {

}catch(Exception $ex) {
  
}

if(isset($_SESSION['token'])){
    $session = new FacebookSession($_SESSION['token']);
    
    try{
        $session->Validate($appId,$appSecret);
    }catch(\Facebook\FacebookAuthorizationException $e){
        $session = '';
    }
}

$loginUrl = $helper->getLoginUrl();

if($session){
    //logged in
    $_SESSION['token'] = $session->getToken();
    $request = new FacebookRequest($session,'GET','/me');
    $response = $request->execute();
    $graphObject = $response->getGraphObject(GraphUser::className());
    
    $_SESSION["FID"] = $graphObject->getId();
    
    $id = $graphObject->getProperty('id');
    $email = $graphObject->getProperty('email');
    $firstname = $graphObject->getProperty('first_name');
    $lastname = $graphObject->getProperty('last_name');
    $birthday = $graphObject->getProperty('birthday');
    $gender = $graphObject->getProperty('gender');
    
    $sql0 = "select user_id from user where fb_id = ?";
    $stmt0 = $db->prepare($sql0);
    $stmt0->bind_param("s",$id);
    $stmt0->execute();
    $stmt0->bind_result($user_id);
    $stmt0->store_result();
    $rows = $stmt0->num_rows;
    if ($rows == 1){
        $sql = "select user_id from user where fb_id = ?";
        if($stmt = $db->prepare($sql)){
            $stmt->bind_param("s",$id);
            $stmt->execute();
            $stmt->bind_result($user_id);
            while($stmt->fetch()){
                $_SESSION["UID"] = $user_id;
            }
            $stmt->close();
        }
    }else {
        $sql = "insert into user values(null,?,?,null,?,?,?,?,current_timestamp,0)";
        if($stmt = $db->prepare($sql)){
            $stmt->bind_param("ssssss",$id,$email,$firstname,$lastname,$gender,$birthday);
            $stmt->execute();
            $uid = mysqli_insert_id($db);
            $_SESSION["UID"] = $uid;
        }
        $stmt->close();
    }
    
}

?>





