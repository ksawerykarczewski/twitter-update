<?php
  session_start();
  $sInjectPageTitle = 'Signup';
  // $bInjectShowLogoutButton = 0;
  $hideLogoutButton = 'hidden';
  $sInjectBodyClass = 'signup-body';

  require_once('top.php'); 
?>
<h3>Join Twitter.</h3>
<form action="signup-action.php" method="post">
    <input class="input-signup" type="text" name="email" placeholder="Email" required minlength="3" maxlength="30"><br>
    <input class="input-signup" type="text" name="username" placeholder="Name" required minlength="3" maxlength="30"><br>
    <input class="input-signup" name="password" type="text" placeholder="Password" required minlength="3" maxlength="30"><br>
    <button class="button button-signup">Sign up</button>
</form>
</body>
</html>