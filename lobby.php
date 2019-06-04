<?php
session_start();
$_SESSION['username'] = $_POST['username']; 
$_SESSION['submit'] = $_POST['submit'];
 if(isset($_POST['username'])) {
	 $username = $_POST['username'];
 }
?>
<!DOCTYPE HTML>
<html>
  <head>Hello,<b><?php echo $_SESSION['username']; ?></b>
				(<b id="number_id"><?php echo'<script>y=localStorage.getItem("x");document.getElementById("number_id").innerHTML = y;console.log(y);</script>'?></b>)
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>
	<link rel="stylesheet" href="lobby2.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<body>
	<div id="player"></div>
       <div id="roomNumbers">Enter a room number between 0 and 99</div>
       <form>
         <div class="row">
           <div class="col">
             <input type="number" id="room" min="0" max="99"
             class="form-control form-control-md number">
           </div>
           <div class="col">

           <!-- A button that connects the user to the given valid room number -->
             <button id="button" class="btn btn-success" onclick="connect()">Connect</button>
           </div>
         </div>
       </form>
    
     <!-- Displays weather the game is in progress, or over -->
       <div id="state">Join Game</div>
   </div>
  
 </div>

<script src="js/game.js"></script>

	</body>
</html>