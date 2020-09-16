<?php
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}

// include the configs / constants for the database connection
require_once("config/db.php");

// load the registration class
require_once("classes/Register.php");

// create the registration object. when this object is created, it will do all registration stuff automatically
// so this single line handles the entire registration process.
$registration = new Register();
?>

<div class="login-box">
  <h2>Add/edit user</h2>
  <form method="post" action="dashboard.php?link=users" name="registerform">
    <div class="textbox">
     <i class="fas fa-user"></i>
      <input type="text" placeholder="Username" name="user_name_new" value="" />
    </div>
    <div class="textbox">
      <i class="fas fa-key"></i>
      <input type="password" placeholder="Password" name="user_password_new" value="" />
    </div>
    <div class="textbox">
      <i class="fas fa-key"></i>
      <input type="password" placeholder="Repeat password" name="repeat_user_password" value="" />
    </div>
    <p class="error-message">
      <?php
        // show potential errors / feedback (from register object)
        if (isset($registration)) {
          if ($registration->errors) {
            foreach ($registration->errors as $error) {
              echo $error;
            }
          }
          if ($registration->messages) {
            foreach ($registration->messages as $message) {
              echo $message;
            }
          }
        }
      ?>
    </p>
    <input class="btn" type="submit" name="register" value="Add / Edit" />
  </form>
</div>
    
