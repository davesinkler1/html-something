<?php
 if(isset($_POST['username'])) {
	 $username = $_POST['username'];
 }
?>
<!DOCTYPE HTML>
<html>
  <head>Hello, <?php echo ''.$username;?> </head>
	<link rel="stylesheet" href="lobby2.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<body>
		<h1 class="home"> <a href="penn.html"> Penn and paper</a> </h1>
		<h1> Lobby </h1>
		<h2>Welcome to the lobby</h2>

		<table>
		<tr>
			<th>
				<div><button type="button"><a href="server.html" class="underline">create a server</a></button></div>Server
			</th>
			<th> Players</th>	
			<th> Ping </th>
		</tr>
		<tr>
			<td> <a href= >Server 1</td>
			<td>Player: 0/7</td>
			<td>Ping: 900ms</td>
		</tr>
		</table>
	</body>
</html>
