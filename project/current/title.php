<?php
   ob_start();  // Turn on output buffering
   session_start();
?>

<!DOCTYPE html>
<html>  
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="style.css">
    
    <style>
        h1 {
            text-align: center;
            font-family: Brush Script MT, Brush Script Std, cursive;
        }
    </style>
</head>

<body>
    <nav>
        <ul>
            <li><a class="active" href="title.php">Home</a></li>
            <li><a href="tutorial.php">Tutorial</a></li>
            <li><a href="game.php">Play</a></li>
            <li><a href="bio.php">Bio</a></li>
        </ul>
    </nav>
    
    <article id="greeting">
        <h1>Hello</h1>
        <p>
        asdfasfasf
        </p>
    </article>
    
    <div class="footer">
        Author: Scott McCoy, 2018
    </div>
    
</body>
    
</html>
