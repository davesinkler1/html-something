<!DOCTYPE html>
<?php
session_start();
?>
<html>
<head>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
	<title>penn and paper</title>
	<link rel="stylesheet" type="text/css" href="/css/new.css">
</head>
<body>
	<div id="nav">
		<a href="lobby.php" >Lobby </a>
		<a href="news.html">News </a>
		<a href="transition.php">Chat </a>
	</div>
	<h1 class="title"><b>PENN AND PAPER</b></h1>

	<div class ="box">
	    <h2>WHAT THE FLIP IS THIS</h2>
		<p font = "Times New Roman" id="wtf">This is pretty much a website about playing board games in general.</p>
		<h2>BACKGROUND</h2>
		<p font = "Times New Roman" id="background">Why did i make this? because i was board.</p>
		<h2 id="sign_title">SIGNING UP</h2>
		<p font = "Times New Roman" id="sign_in"> Since you're gonna play with different people you need to make an account, you could sign up below or if you're too lazy to set up a nickname you could just be a gues
	</div>
<div id = "form">
<?php
echo '<form action="lobby.php";action="transition.php" method="post" id="form2">
Username:<br>
<input type="text" name="username" required>';
echo'
<br><br>
<input type="button" name="id" onclick="ID()" value="Generate ID">
<p id="output" name="output"></p>
<input type="submit" name="submit" value="Submit">
</form>';
echo '<br><br>';

/* echo '<form action="transition.php" method="post" >
Username(for chat):<br>
<input type="text" name="username">
<br><br>
<input type="submit" name="submit" value="Submit">
<input type="submit" name="Guest" value="Guest">

</form>'; */
?>
</body>
<script>
var ID = function() {
	 var x = '_' + Math.random().toString(36).substr(2, 9);
	 document.getElementById("output").innerHTML = x;
	 localStorage.setItem("x", x)
	 var y = localStorage.getItem("x")
	 console.log(y)
}
</script>
</html>