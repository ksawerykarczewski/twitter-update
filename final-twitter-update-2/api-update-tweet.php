<?php

try{
    session_start();
    //validation
    if(!isset($_SESSION["userId"]) ){ header('location: login-view.php'); }

    // if(!isset($_GET['id'])) {
    //     http_response_code(400);
    //     header('Content-type: application/json');
    //     echo '{"error": "missing id"}';
    //     exit();
    // } 

    if(strlen($_POST['update-tweet-message']) < 3) {
        http_response_code(400);
        header('Content-type: application/json');
        echo '{"error": "the tweet has to be at least 3 characters"}';
        exit();
    } 
    
    // if(strlen($_POST['update-tweet-message']) > 140) {
    //     http_response_code(400);
    //     header('Content-type: application/json');
    //     echo '{"error": "the tweet has to be max 140 characters"}';
    //     exit();
    // } 

    $sUsers = file_get_contents('private/users.txt');
    $aUsers = json_decode($sUsers);

    for($i = 0; $i < count($aUsers); $i++){
        if($aUsers[$i]->id == $_SESSION["userId"]) {
            $aUserPosition = $i;
            break;
        }
    }


    for($i = 0; $i < count($aUsers[$aUserPosition]->tweets); $i++){
        if($aUsers[$aUserPosition]->tweets[$i]->id == $_POST['tweet-id']){
            if($aUsers[$aUserPosition]->tweets[$i]->message != $_POST['update-tweet-message']) {
                $aUsers[$aUserPosition]->tweets[$i]->message = $_POST['update-tweet-message'];
            }
            $sUsers = json_encode($aUsers);
            file_put_contents('private/users.txt', $sUsers); 
            header('Content-type: application/json');
            echo json_encode($aUsers[$aUserPosition]->tweets[$i]);
            exit();
        }
    }


    // if(!isset($_POST['update-tweet-title']) || !isset($_POST['update-tweet-message'])) {
    //     http_response_code(400);
    //     header('Content-type: application/json');
    //     echo '{"error": "missing tweet title or message"}';
    //     exit();
    // } 
}

catch(Exception $ex){
    http_response_code(500);
    header('Content-Type: application/json');
    echo '{"message":"error '.__LINE__.'"}';
  }
?>