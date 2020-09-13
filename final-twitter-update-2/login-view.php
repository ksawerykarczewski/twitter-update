<?php
  session_start();
  $sInjectPageTitle = 'Login';
  // $bInjectShowLogoutButton = 0;
  $hideLogoutButton = 'hidden';
  $sInjectBodyClass = 'login-body';

  require_once('top.php'); 
?>
<h3>Login</h3>
<form action="login-action.php" method="POST">
    <input class="input-login" name="email" type="text" placeholder="Email" required minlength="3" maxlength="30">
    <input class="input-login" name="password" type="text" placeholder="Password" required minlength="4" maxlength="30">
    <button class="button button-login" type="submit">Login</button>
</form>
    
</body>
</html>
