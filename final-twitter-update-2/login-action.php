<?php
try{  
(function(){
session_start();
// check if email is set \\ check if password is set
if( ! $_POST['email']){ header('Location: login-view.php'); }
if( ! $_POST['password']){ header('Location: login-view.php'); }

$sUsers = file_get_contents('private/users.txt');
$aUsers = json_decode($sUsers);

//check for match is database
foreach($aUsers as $aUser){
    if( password_verify($_POST['password'], $aUser->password) && $_POST['email'] == $aUser->email){
      $_SESSION["userId"] = $aUser->id;
      $_SESSION["userName"] = $aUser->name;
      print_r($_SESSION);
      header('Location: twitter.php');
      exit();
    }else{
        echo 'no match';
    }
}
})();
}
catch(Exception $ex){
    http_response_code(500);
    header('Content-Type: application/json');
    echo '{"message":"error '.__LINE__.'"}';
}
