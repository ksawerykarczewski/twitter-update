<?php
  session_start();
  // open the db
  $sTweets = file_get_contents('private/users.txt');
  $aTweets = json_decode($sTweets);

  foreach ($aTweets as &$aTweet) {
    if ($_SESSION["userId"] == $aTweet->id) {
        //print_r($aTweet->tweets);
        header('Content-Type: application/json');
        echo json_encode(($aTweet->tweets));
        exit();
    }
};

echo $_GET['latestReceivedTweetId'];
?>


