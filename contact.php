<?php require_once('includes/header.php');  ?>

<main>
    <h2>CONTACT US!</h2>
    <div class="result-box">
        <form method="post" action="results.php" name="resultsform">
            <div class="textbox">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Name" name="contact_name" value="" />
            </div>

            <div class="textbox">
                <i class="fas fa-envelope"></i>
                <input type="email" placeholder="Email" name="contact_email" value="" />
            </div>

            <div class="textbox">
                <i class="fas fa-sticky-note"></i>
                <textarea placeholder="Message.." name="sample_number" value=""></textarea>
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
    <input class="btn" type="submit" name="get_results" value="Send Email" />
  </form>
    </div>
</main>

<?php require_once('includes/footer.php');  ?>