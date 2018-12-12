<?php
   ob_start();  // Turn on output buffering
   session_start();
?>

<?
   // error_reporting(E_ALL);
   // ini_set("display_errors", 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Login</title>
    <style>
        #login {
            position:fixed;
            top:30px;
            padding-top: 20px;
            padding-left: 175px;
        }
    </style>
</head>
<body>
    <div id="login-php">
        <?php
            // Include config file
            require_once 'config_mysql.php';
             
            // Define variables and initialize with empty values
            $username = $password = "";
            $username_err = $password_err = "";
             
            // Processing form data when form is submitted
            if($_SERVER["REQUEST_METHOD"] == "POST"){
             
                // Check if username is empty
                if(empty(trim($_POST["username"]))){
                    $username_err = 'Please enter username.';
                } else{
                    $username = trim($_POST["username"]);
                }
                
                // Check if password is empty
                if(empty(trim($_POST['password']))){
                    $password_err = 'Please enter your password.';
                } else{
                    $password = trim($_POST['password']);
                }
                
                // Validate credentials
                if(empty($username_err) && empty($password_err)){
                    // Prepare a select statement
                    $sql = "SELECT User, Password FROM loginform WHERE User=?";
                    if($stmt = mysqli_prepare($link, $sql)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "s", $param_username);
                        // Set parameters
                        $param_username = $username;

                        // echo $param_username;
                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                            // Store result
                            mysqli_stmt_store_result($stmt);  
                            // Check if username exists, if yes then verify password
                            if(mysqli_stmt_num_rows($stmt) == 1){                    
                                // Bind result variables
                                mysqli_stmt_bind_result($stmt, $result_username, $result_password);
                                if(mysqli_stmt_fetch($stmt)){
                                    //echo $password ."<br>";
                                    //echo $hashed_password ."<br>";

                                    //be sure to encrypt and use password_verify instead
                                    //of strcmp
                                    if(password_verify($password, $result_password)){
                                        /* Password is correct, so start a new session and
                                        save the username to the session */
                                        session_start();
                                        $_SESSION['username'] = $username;      
                                        header("location: game.php");
                                    } else{
                                        // Display an error message if password is not valid
                                        $password_err = 'The password you entered was not valid.';
                                    }
                                }
                            } 
                            else {
                                // Display an error message if username doesn't exist
                                $username_err = 'No account found with that username.';
                            }
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                    }
                    // Close statement 
                    //mysqli_stmt_close($stmt);               
                    else
                    {
                        die("ERROR: Could not connect. " . mysqli_stmt_error($stmt));
                    }
                }
                // Close connection
                mysqli_close($link);
            }
        ?>
    </div>

    <div class="snav">
        <h2>Menu</h2>
        <a href="game.php">New Game</a>
        <a href="#">Hint</a>
        <a href="logout_mysql.php">Logout</a>
    </div>
    
    <nav>
        <ul>
            <li><a href="title.php">Home</a></li>
            <li><a href="tutorial.php">Tutorial</a></li>
            <li><a class="active" href="game.php">Play</a></li>
            <li><a href="bio.php">Bio</a></li>
        </ul>
    </nav>

    <div id="login">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div  <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username:<sup>*</sup></label>
                <input type="text" name="username" value="<?php echo $username; ?>">
                <span><?php echo $username_err; ?></span>
            </div>    
            <div <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password:<sup>*</sup></label>
                <input type="password" name="password">
                <span><?php echo $password_err; ?></span>
            </div>
            <div>
                <input type="submit" value="Submit">
            </div>
            <p>Don't have an account? <a href="register_mysql.php">Sign up now</a>.</p>
        </form>
    </div>    

    <footer>
        <div class="footer">
            Author: Scott McCoy, 2018
        </div>
    </footer>
</body>
</html>