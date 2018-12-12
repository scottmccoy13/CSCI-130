<?php
    // Initialize the session
    session_start();
    // If session variable is not set it will redirect to login page
    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
      header("location: login_mysql.php");
      exit;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        #choose-size {
            position:fixed;
            top:30px;
            padding-top: 20px;
            padding-left: 175px;
        }

        .button {
            font: bold 45px;
            text-decoration: none;
            background-color: #333;
            color: white;
            padding: 2px 6px 2px 6px;
            border-top: 1px solid #CCCCCC;
            border-right: 1px solid #333333;
            border-bottom: 1px solid #333333;
            border-left: 1px solid #CCCCCC;
        }
    </style>
</head>

<body>
    
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
    
    <div id="choose-size">
        <h4>Choose the level size<h4>
        <a href="smalltable.php" class="button">7x7</a>
        <a href="#" class="button">13x13</a>
    </div>

    <footer>
        <div class="footer">
            Author: Scott McCoy, 2018
        </div>
    </footer>
    
</body>
</html>