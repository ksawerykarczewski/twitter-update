<?php

try{
  session_start();

  if( ! isset($_POST['tweetMessage']) ){
    http_response_code(400);
    header('Content-Type: application/json');
    echo '{"error":"missing title"}';
    exit();
  }
  if( strlen($_POST['tweetMessage']) < 2 ){
    http_response_code(400);
    header('Content-Type: application/json');
    echo '{"error":"title must be at least 2 characters"}';
    exit();
  }
  if( strlen($_POST['tweetMessage']) > 100 ){
    http_response_code(400);
    header('Content-Type: application/json');
    echo '{"error":"title cannot be longet than 100 characters"}';
    exit();
  }

  // open the db
  $sTweets = file_get_contents('private/users.txt');
  // convert the data to an object []
  $aTweets = json_decode($sTweets);
  // access tweets

  foreach ($aTweets as &$aTweet) {
    if ($_SESSION["userId"] == $aTweet->id) {
        //$sTweetId = uniqid();
        $sTweetId = $aTweet->tweetcount;
        $aTweet->tweetcount = $aTweet->tweetcount + 1;
      
        $jTweet          = new stdClass(); // {}
        $jTweet->id      = $sTweetId; // user id and tweet id must match
        $jTweet->message  = $_POST['tweetMessage'];
    
        //$aTweet->tweets = $jTweet;
        //$aTweet->tweets = $jTweet;
        array_push($aTweet->tweets, $jTweet);
        //print_r($aTweet->tweets);
        print_r($aTweet);
        // convert the object back to text
        $sTweets = json_encode($aTweets);
        file_put_contents('private/users.txt', $sTweets);
        break;
    }
};

  header('Content-Type: application/json');
  //echo '{ "id":"'.$sTweetId.'"}';
  //echo $sTweetId;
}
catch(Exception $ex){
  http_response_code(500);
  header('Content-Type: application/json');
  echo '{"message":"error '.__LINE__.'"}';
}