

<?php $style = "styles/logged_out.css"; ?>
<?php $title = "Admin login"; ?>
<?php require_once('includes/header.php');  ?>

<div class="login-box">
  <img src="styles/logo.png" />
  <h2>Login</h2>
  <form method="post" action="dashboard.php" name="loginform">
    <div class="textbox">
     <i class="fas fa-user"></i>
      <input type="text" placeholder="Username" name="user_name" value="" />
    </div>

    <div class="textbox">
      <i class="fas fa-key"></i>
      <input type="password" placeholder="Password" name="user_password" value="" />
    </div>
    <p class="error-message">
      <?php
        // show potential errors / feedback (from login object)
        if (isset($login)) {
          if ($login->errors) {
            foreach ($login->errors as $error) {
              echo $error;
            }
          }
          if ($login->messages) {
            foreach ($login->messages as $message) {
              echo $message;
            }
          }
        }
      ?>
    </p>
    <input class="btn" type="submit" name="login" value="Sign in" />
  </form>
</div>
<?php require_once('includes/footer.php'); ?>
    
