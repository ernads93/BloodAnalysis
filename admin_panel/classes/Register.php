<?php

/**
 * Class registration
 * handles the user registration
 */
class Register
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$registration = new Registration();"
     */
    public function __construct()
    {
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
        
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    private function registerNewUser()
    {
        
        if (empty($_POST['user_name_new'])) {
            $this->errors[] = "ERROR: Username can't be empty.";
        } elseif (empty($_POST['user_password_new']) || empty($_POST['repeat_user_password'])) {
            $this->errors[] = "ERROR: Password can't be empty.";
        } elseif ($_POST['user_password_new'] !== $_POST['repeat_user_password']) {
            $this->errors[] = "ERROR: Password's don't match.";
        } elseif (strlen($_POST['user_password_new']) < 8) {
            $this->errors[] = "ERROR: Minimum password length is 8 characters";
        } elseif (strlen($_POST['user_name_new']) > 64 || strlen($_POST['user_name_new']) < 2) {
            $this->errors[] = "ERROR: Username cannot be shorter than 2 or longer than 64 characters.";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name_new'])) {
            $this->errors[] = "ERROR: Username scheme: only a-Z and numbers are allowed.";
        } elseif (!empty($_POST['user_name_new'])
            && strlen($_POST['user_name_new']) <= 64
            && strlen($_POST['user_name_new']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name_new'])
            && !empty($_POST['user_password_new'])
            && !empty($_POST['repeat_user_password'])
            && ($_POST['user_password_new'] === $_POST['repeat_user_password'])
        ) {

            // create a database connection
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }
            
            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
                // escaping, additionally removing everything that could be (html/javascript-) code
                $user_name_new = $this->db_connection->real_escape_string(strip_tags($_POST['user_name_new'], ENT_QUOTES));

                $user_password_new = $_POST['user_password_new'];

                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
                $user_password_new_hash = password_hash($user_password_new, PASSWORD_DEFAULT);

                // check if user already exists
                $sql = "SELECT * FROM users WHERE user_name = '" . $user_name_new . "';";
                $query_check_user_name = $this->db_connection->query($sql);
                
                
                if ($query_check_user_name->num_rows == 1) {
                    $sql = "UPDATE users SET user_password_hash = '" . $user_password_new_hash . "' WHERE user_name = '" . $user_name_new . "';";
                    $sql_update_user = $this->db_connection->query($sql);
                    echo "I am here";
                    if($sql_update_user) {
                        $this->messages[] = "MSG: User updated.";
                    } else {
                        $this->errors[] = "ERROR: Failed to update. Try again.";
                    } 
                } else {
                    // write new user's data into database
                    $sql = "INSERT INTO users (user_name, user_password_hash)
                            VALUES('" . $user_name_new . "', '" . $user_password_new_hash . "');";
                    $query_new_user_insert = $this->db_connection->query($sql);
                      
                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        $this->messages[] = "MSG: Account has been created successfully.";
                    } else {
                        $this->errors[] = "ERROR: Registration failed.";
                    }
                }
            } else {
                $this->errors[] = "ERROR: Sorry, no database connection.";
            }
        } else {
            $this->errors[] = "ERROR: An unknown error occurred.";
        }
    }
}