<?php
   ob_start();  // Turn on output buffering
   session_start();
?>

<!DOCTYPE html>s
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="style.css">
    
    <style>
        table td, th  {
            width: 80px;
            height: 60px;
        }

        .hidden {
            display:none;
        }

        .unhidden {
            display:block;
        }
    </style>
</head>

<script>
        class requestObject {
            constructor() {
                var gridColor = null;
                var cellColor = null;
                var gameSize  = null;
                var gameType  = null;
            }
        }
        var request = new requestObject();
        
        class gameObject {
            constructor() {
                var solution = null;
                var userSolution = null;
                var gridColor = null;
                var blockColor = null;
            }
        }
        var game = new gameObject();

        class levelObject {
            constructor() {
                var levelArray = null;
                var solutionArray = null;
            }
        }
        var level = new levelObject();
        //start loading of the hints
        //"y,x,str"
        level.levelArray = ["1,0,1 1", "7,0,1 1", "4,0,1", "0,4,1", "0,7,1 1", "0,1,1 1"];
        
        level.solutionArray = ["(1,1)", "(1,7)", "(4,4)", "(7,1)", "(7,7)"];

        function startTimer() {
            var time = new Date();
            time.setHours(0);
            time.setMinutes(0);
            time.setSeconds(0);
            loadLevel();

            // Update the count down every 1 second
            var x = setInterval(function() {
                time.setSeconds(time.getSeconds()+1)

                // Time calculations for days, hours, minutes and seconds
                var hours = time.getHours();
                var minutes = time.getMinutes();
                var seconds = time.getSeconds();
                // Display the result in the element with id="demo"
                document.getElementById("myTimer").innerHTML = hours + "h "
                + minutes + "m " + seconds + "s ";
            }, 1000)
        }
        
        function loadLevel() {
            var table = document.getElementById("myTable");
            //start hint loading
            for(var i = 0; i < level.levelArray.length; i++) {
                levelString = level.levelArray[i].split(',');
                table.rows[levelString[0]].cells[levelString[1]].innerHTML = levelString[2];
            }
            //end hint loading
            
            //start solution loading
            var solutionSet = new Set();
            for(var i = 0; i < level.solutionArray.length; i++) {
                solutionSet.add(level.solutionArray[i]);
            }
            game.solution = solutionSet;
            game.userSolution = new Set();
        }
        
        function changeState(element, event, selection) {   
            if(event.ctrlKey)
            {
                //for marking cells as bad
                element.style.backgroundColor='red';
            }
            else
            {
                if(game.userSolution.has(selection))
                {
                    game.userSolution.delete(selection);
                    element.style.backgroundColor='white';
                    checkVictory();
                }
                else
                {
                    element.style.backgroundColor='black';
                    game.userSolution.add(selection);
                    checkVictory();
                }
            }
        }
    
        function checkVictory() {
            if(checkSolutionEquality())
            {
                var time = document.getElementById("myTimer").innerHTML;
                alert("You WIN! Time: " + time);
            }
        }
    
        function checkSolutionEquality() {
            if(game.solution.size !== game.userSolution.size) return false;
            for(var item of game.solution) if (!game.userSolution.has(item)) return false;
            return true;
        }

        function setGridColor() {
            var redslider = document.getElementById("redRange");
            var blueslider = document.getElementById("blueRange");
            var greenslider = document.getElementById("greenRange");
            
            r = redslider.value;
            b = blueslider.value;
            g = greenslider.value;

            var output = 'rgb(' + [r,g,b].join(',') + ')';
            request.gridColor = output;
        }

        function setCellColor() {
            var redslider = document.getElementById("redRange");
            var blueslider = document.getElementById("blueRange");
            var greenslider = document.getElementById("greenRange");
            
            r = redslider.value;
            b = blueslider.value;
            g = greenslider.value;

            var output =  'rgb(' + [r,g,b].join(',') + ')';
            request.cellColor = output;
        }
 
        function setValues() {
            //hides the settings and renders the table
            var settings  = document.getElementById("settingsContainer");
            var gameTable = document.getElementById("gameContainer");

            settings.className = 'hidden';
            gameTable.className = 'unhidden';

            //This block sets the value for the grid size
            var gridSize = document.getElementsByName("size");
            for(var i = 0; i < gridSize.length; i++)
            {
                if(gridSize[i].checked)
                {
                    //alert(gridSize[i].value)
                    request.gameSize = gridSize[i].value;
                    break;
                }
            }

            //This block applies the color choices to the game
            document.getElementById("myTable").style.borderColor = game.gridColor;
            alert(game.gridColor);
            
            //This block sets the value for the game type
            var radios = document.getElementsByName("gametype");
            for(var i = 0; i < radios.length; i++) {
                if(radios[i].checked)
                {
                    //alert(radios[i].value);
                    request.gameType = radios[i].value;
                    break;
                }
            }
            
            //Build the request string 
            txt = "";
            for(var x in request) {
                txt+=request[x] + ",";
            }
            
            //Send the request string
            if(request.gameType == "test")
            {
                alert("test");
            }
            else
            {
                alert("Sending request (when implemented)");
            }
        }
</script>
    
<body>
    
    <div class="snav">
        <h2>Menu</h2>
        <a href="game.php">New Game</a>
        <a href="#">Hint</a>
    </div>
    
    <nav>
        <ul>
            <li><a href="title.php">Home</a></li>
            <li><a href="tutorial.php">Tutorial</a></li>
            <li><a class="active" href="game.php">Play</a></li>
            <li><a href="bio.php">Bio</a></li>
        </ul>
    </nav>

    <div class="settingsContainer" id="settingsContainer">
        <h3>The following elements will be present in the setup sequence</h3>
        <h5>Set the grid color</h5>
        <input type="range" min="0" max="255" value="0" class="slider" id="redRange">
        <input type="range" min="0" max="255" value="0" class="slider" id="blueRange">
        <input type="range" min="0" max="255" value="0" class="slider" id="greenRange">
        <button onclick="setGridColor()">Set Grid Color</button>

        <h5>Set the cell color</h5>
        <input type="range" min="0" max="255" value="0" class="slider" id="redRange">
        <input type="range" min="0" max="255" value="0" class="slider" id="blueRange">
        <input type="range" min="0" max="255" value="0" class="slider" id="greenRange">
        <button onclick="setCellColor()">Set Grid Color</button>
        <br>

        <h5>Select the game mode</h5>
        <input type="radio" name="gametype" value="arcade">Arcade<br>
        <input type="radio" name="gametype" value="timeattack">Time Attack<br>
        <!-- for playing user generated levels -->
        <input type="radio" name="gametype" value="custom">Custom<br>
        <!-- test -->
        <input type="radio" name="gametype" value="test">Test<br>
           
        <button onclick="setValues()">Set Values</button>
    </div>
    
    <div class="hidden" id="gameContainer" style="position:absolute; right: 400px; top:65px;">
        <!-- clicking this button loads the level and starts the game -->
        <div id="myTimer">
            00:00:00
            <button onclick="startTimer()">Start time</button>
        </div>

        <table id="myTable" border="1" style="cursor:pointer;">
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <td></td>
                <td onclick="changeState(this,event,'(1,1)')"></td> 
                <td onclick="changeState(this,event,'(2,1)')"></td>
                <td onclick="changeState(this,event,'(3,1)')"></td>
                <td onclick="changeState(this,event,'(4,1)')"></td>
                <td onclick="changeState(this,event,'(5,1)')"></td>
                <td onclick="changeState(this,event,'(6,1)')"></td>
                <td onclick="changeState(this,event,'(7,1)')"></td>
            </tr>
            <tr>
                <td></td>
                <td onclick="changeState(this,event,'(1,2)')"></td> 
                <td onclick="changeState(this,event,'(2,2)')"></td>
                <td onclick="changeState(this,event,'(3,2)')"></td>
                <td onclick="changeState(this,event,'(4,2)')"></td>
                <td onclick="changeState(this,event,'(5,2)')"></td>
                <td onclick="changeState(this,event,'(6,2)')"></td>
                <td onclick="changeState(this,event,'(7,2)')"></td>
            </tr>
            <tr>
                <td></td>
                <td onclick="changeState(this,event,'(1,3)')"></td> 
                <td onclick="changeState(this,event,'(2,3)')"></td>
                <td onclick="changeState(this,event,'(3,3)')"></td>
                <td onclick="changeState(this,event,'(4,3)')"></td>
                <td onclick="changeState(this,event,'(5,3)')"></td>
                <td onclick="changeState(this,event,'(6,3)')"></td>
                <td onclick="changeState(this,event,'(7,3)')"></td>
            </tr>
            <tr>
                <td></td>
                <td onclick="changeState(this,event,'(1,4)')"></td> 
                <td onclick="changeState(this,event,'(2,4)')"></td>
                <td onclick="changeState(this,event,'(3,4)')"></td>
                <td onclick="changeState(this,event,'(4,4)')"></td>
                <td onclick="changeState(this,event,'(5,4)')"></td>
                <td onclick="changeState(this,event,'(6,4)')"></td>
                <td onclick="changeState(this,event,'(7,4)')"></td>
            </tr>
            <tr>
                <td></td>
                <td onclick="changeState(this,event,'(1,5)')"></td> 
                <td onclick="changeState(this,event,'(2,5)')"></td>
                <td onclick="changeState(this,event,'(3,5)')"></td>
                <td onclick="changeState(this,event,'(4,5)')"></td>
                <td onclick="changeState(this,event,'(5,5)')"></td>
                <td onclick="changeState(this,event,'(6,5)')"></td>
                <td onclick="changeState(this,event,'(7,5)')"></td>
            </tr>
            <tr>
                <td></td>
                <td onclick="changeState(this,event,'(1,6)')"></td> 
                <td onclick="changeState(this,event,'(2,6)')"></td>
                <td onclick="changeState(this,event,'(3,6)')"></td>
                <td onclick="changeState(this,event,'(4,6)')"></td>
                <td onclick="changeState(this,event,'(5,6)')"></td>
                <td onclick="changeState(this,event,'(6,6)')"></td>
                <td onclick="changeState(this,event,'(7,6)')"></td>
            </tr>
            <tr>
                <td></td>
                <td onclick="changeState(this,event,'(1,7)')"></td> 
                <td onclick="changeState(this,event,'(2,7)')"></td>
                <td onclick="changeState(this,event,'(3,7)')"></td>
                <td onclick="changeState(this,event,'(4,7)')"></td>
                <td onclick="changeState(this,event,'(5,7)')"></td>
                <td onclick="changeState(this,event,'(6,7)')"></td>
                <td onclick="changeState(this,event,'(7,7)')"></td>
            </tr>
        </table>
        
    </div>
    

    <footer>
        <div class="footer">
            Author: Scott McCoy, 2018
        </div>
    </footer>
    
</body>

</html>