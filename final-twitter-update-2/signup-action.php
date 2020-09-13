<?php
try{
    //if no post redirect no singup page
    if( ! $_POST ){ header('Location: signup'); }
    //if not a valid email redirect to singup page
    if( ! filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL  ) ){ 
        header('Location: signup-view.php');
        echo 'bad email';
        exit();
    }
    // if name too short redirect to singup page
    if( strlen($_POST['username']) < 2 ){
        header('Location: signup-view.php');
        echo 'too short username min 2';
        exit();
    }
    // if name too long redirect to singup page
    if( strlen($_POST['username']) > 20 ){
        header('Location: signup-view.php');
        echo 'too long username max 20';
        exit();
    }
    // if password too short redirect to singup page
    if( strlen($_POST['password']) < 2 ){
        echo 'password is too short';
        exit();
    }

    $password = $_POST['password'];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    //echo password_hash($password, PASSWORD_DEFAULT);

    $sUsers = file_get_contents('private/users.txt');
    $aUsers = json_decode($sUsers);

    $jUser = new stdClass(); // {}
    $jUser->id = uniqid();
    $jUser->name = $_POST['username'];
    $jUser->email = $_POST['email'];
    $jUser->password = $passwordHash;
    $jUser->tweetcount = 0;
    $jUser->tweets = [];

     // Check for duplicated emails
     foreach( $aUsers as $aUser ){
        if( $_POST['email'] == $aUser->email ){
            header('Location: signup-view.php');
            exit();
        }
    };
    // write the tweet to the object
    array_push($aUsers, $jUser);
    // convert the object back to text
    $sUsers = json_encode($aUsers);
    // save the text into the file
    file_put_contents('private/users.txt', $sUsers);
  
    header('Content-Type: application/json');
    echo '{"message":"tweet created"}';
    header('Location: login-view.php');
}
  catch(Exception $ex){
    // http_response_code(500);
    // header('Content-Type: application/json');
    echo '{"message":"error '.__LINE__.'"}';
  }