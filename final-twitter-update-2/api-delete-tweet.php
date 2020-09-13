<?php

try{
    session_start();
    //validation
    if(!isset($_SESSION["userId"]) ){ header('location: login-view.php'); }
    if(!isset($_GET['id'])) {
        http_response_code(400);
        header('Content-type: application/json');
        echo '{"error": "missing id"}';
        exit();
    } 

    $sTweetId = $_GET['id'];
    $sUsers = file_get_contents('private/users.txt');
    $aUsers = json_decode($sUsers);

    for($i = 0; $i < count($aUsers); $i++){
        if($aUsers[$i]->id == $_SESSION["userId"]) {
            $aUserPosition = $i;
            break;
        }
    }

    for($i = 0; $i < count($aUsers[$aUserPosition]->tweets); $i++){
        if($aUsers[$aUserPosition]->tweets[$i]->id == $sTweetId) {
            echo 'match to delete';
            array_splice($aUsers[$aUserPosition]->tweets, $i, 1 );
            header('Content-type: application/json');
            file_put_contents("private/users.txt", json_encode($aUsers));
            exit();
        }
    }
    
}
catch(Exception $ex){
    http_response_code(500);
    header('Content-Type: application/json');
    echo '{"message":"error '.__LINE__.'"}';
  }
?>