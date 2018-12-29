<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="new.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>penn and paper</title>
	<body background=>
	<div id="nav">
		<a href="lobby.php" >Lobby </a>
		<a href="news.html">News </a>
		<a href="transition.php">Chat </a>
	</div>
	<h1 class="title"><b>PENN AND PAPER</b></h1>

	<div class ="box">
		<p font = "Times New Roman">This is pretty much a website about playing tabletop RPG, like a pen and paper one where you have a GM and you fills out character sheets yeah, that one i have NEVER played any type of tabletop RPG since the necessary guide books and dices is rare in my country so, i want people to play tabletop RPG freely here.</p>
		<h3>EXPERIENCE</h2>
		<p font = "Times New Roman">I have little experience with tabletop RPG i do collect w40k miniatures but i have never played them.</p>
		<h3>SIGNING UP</h3>
		<p font = "Times New Roman"> Since you're gonna play with different people you need to make an account, you could sign up below or if you're too lazy to set up a nickname you could just be a guest</p>
		</div>
<div id = "form">
<?php
echo '<form action="lobby.php" method="post" >
Username:<br>
<input type="text" name="username">
<br><br>
<input type="submit" name="submit" value="Submit">
<input type="submit" name="Guest" value="Guest">

</form>';
echo '<br><br>';
echo '<form action="transition.php" method="post" >
Username(for chat):<br>
<input type="text" name="username">
<br><br>
<input type="submit" name="submit" value="Submit">
<input type="submit" name="Guest" value="Guest">

</form>';
?>
</body>
</html>