<?php
try{  
(function(){
session_start();
})();
}
catch(Exception $ex){
    // http_response_code(500);
    // header('Content-Type: application/json');
    echo '{"message":"error '.__LINE__.'"}';
}
?>
<?php
  session_start();
  $sInjectPageTitle = 'Twitter';
  // $bInjectShowLogoutButton = 0;
  $hideLogoutButton = 'hidden';
  $sInjectBodyClass = 'feed-body';

  require_once('top.php'); 
?>
    
    <div class="">
            <form id="formTweet" onsubmit="postTweet(); return false">
                <input name="tweetMessage" type="text" placeholder="Tweet Message" value="Message" required minlength="3" maxlength="140">
                <button type="submit">Tweet</button>
            </form>
      </div>

      <div id="tweets"></div>
    
    <script src="app.js"></script>
</body>
</html>
