<?php require_once('includes/header.php');  ?>

<?php
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("admin_panel/libraries/password_compatibility_library.php");
}

// include the configs / constants for the database connection
require_once("admin_panel/config/db.php");


// load the registration class
require_once("admin_panel/classes/GetResults.php");

// create the registration object. when this object is created, it will do all registration stuff automatically
// so this single line handles the entire registration process.
$getResults = new GetResults();
?>

<main>
    <h2>GET YOUR RESULTS HERE!</h2>
    <div class="result-box">
        <form method="post" action="results.php" name="resultsform">
            <div class="textbox">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Surname" name="patient_surname" value="" />
            </div>

            <div class="textbox">
                <i class="fas fa-calendar-day"></i>
                <input type="text" placeholder="Birthdate (yyyy-mm-dd)" name="patient_birthdate" value="" />
            </div>

            <div class="textbox">
                <i class="fas fa-sticky-note"></i>
                <input type="text" placeholder="Sample number" name="sample_number" value="" />
            </div>
            <p class="error-message">
                <?php
                // show potential errors / feedback
                if (isset($getResults)) {
                    if ($getResults->errors) {
                        foreach ($getResults->errors as $error) {
                            echo $error;
                        }
                     }
                    if ($getResults->messages) {
                        foreach ($getResults->messages as $message) {
                            echo $message;
                        }
                    }
                }
                ?>
    </p>
    <input class="btn" type="submit" name="get_results" value="Get results!" />
  </form>
    </div>
</main>

<?php require_once('includes/footer.php');  ?>