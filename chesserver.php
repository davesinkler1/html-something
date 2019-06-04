<?php
session_start();

function userform() {
	echo '<div id = "form">
<form method= "post" >
Username:<br>
<input type="text" name="username">
<br><br>
<input type="radio" name="black" value="black piece"><br>
<input type="radio" name="white" value="white piece"><br>
<input type="submit" name="submit" value="Submit">
</form>
</div>';
}


if(isset($_SESSION['submit'])){
	
}
 if(isset($_SESSION['username'])) {
 }
 
 if (isset($_SESSION['submit'])){
	if (isset($_SESSION['username'])){
		$_SESSION['username'] = stripslashes(htmlspecialchars($_SESSION['username']));
		  $fp = fopen ( "serverlog.html", 'a' );
        fwrite ( $fp, "<div class='msgln'><i>User " . $_SESSION ['username'] . " has joined the session.</i><br></div>" );
        fclose ( $fp );
	 }
	}
?>
<html>
	<head>
	Hello, <b><?php echo ''.$_SESSION['username'];?></b>(<b id="number_id"><?php echo'<script>y=localStorage.getItem("x");document.getElementById("number_id").innerHTML = y;console.log(y);</script>'?></b>)
	   <p class="logout">
                <a id="exit" href="penn.php">Exit Chat</a>
            </p>
	     <link rel="stylesheet" href="/css/server2.css">
		 <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
		  <link rel="stylesheet" href="css/chessboard-0.3.0.min.css">
		  <script src="custombg/js/jquery/jquery.min.js"></script>
		   <script src="custombg/js/jquery/jquery-ui.min.js"></script>
		<script src="https://webrtc.github.io/adapter/adapter-4.2.2.js"></script>
		<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
		   <script src="js/chessboard.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/chess.js/0.10.2/chess.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
		<script src="js/loadwindows.js"></script>
		<link rel="stylesheet"
 href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
 integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
   crossorigin="anonymous">
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
 integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
   crossorigin="anonymous"></script>
	</head>

<body>
<br><br>
	<div class="chatsection">
	<div id="board1" style="width: 450px"></div>
	<script src="js/game.js"></script>
	<br><br><br><br>
	 <div id='turn'> It's Whites turn!</div>
	 </div>


 <script>
    
	/* var board,
		 game = new Chess();
		  statusEl = $('#status'),
		  fenEl = $('#fen'),
		  pgnEl = $('#pgn');
		  
		  //initialize the socket
var socket = io();
// piece color
var color = "white";
// number of players in the current room
var players;
// the room number between 0 and 99
var roomId;
// if the both players have joined then it will be false
var play = true;

// For some DOM manipulation later
var room = document.getElementById("room")
var roomNumber = document.getElementById("roomNumbers")
var button = document.getElementById("button")
var state = document.getElementById('state')

var connect = function(){

 // extract the value of the input field
 roomId = room.value;
 // if the room number is valid
 if (roomId !== "" && parseInt(roomId) <= 100) {
   room.remove();
   roomNumber.innerHTML = "Room Number " + roomId;
   button.remove();

   // emit the 'joined' event which we have set up a listener for on the server
   socket.emit('joined', roomId);
 }
}

socket.on('full', function (msg) {
 if(roomId == msg)
   window.location.assign(window.location.href+ 'full.html');
});

// change play to false when both players have
// joined the room, so that they can start playing
// (when play is false the players can play)
socket.on('play', function (msg) {
 if (msg == roomId) {
     play = false;
     state.innerHTML = "Game in progress"
 }
});

// when a move happens, check if it was meant for the clients room
// if yes, then make the move on the clients board
socket.on('move', function (msg) {
 if (msg.room == roomId) {
     game.move(msg.move);
     board.position(game.fen());
     console.log("moved")
 }
});
		  
 var onDragStart = function(source, piece, position, orientation) {
  if (game.game_over() === true || play ||
  
      (game.turn() === 'w' && piece.search(/^b/) !== -1)  ||
      (game.turn() === 'b' && piece.search(/^w/) !== -1)) ||
	  (game.turn() === 'w' && color === 'black') ||
      (game.turn() === 'b' && color === 'white') ) {
         return false;
  }
  console.log({play, plsyers});
};

	var onDrop = function(source, target) {
	  // see if the move is legal
	  var move = game.move({
		from: source,
		to: target,
		promotion: 'q' // NOTE: always promote to a queen for example simplicity
	  });

       if (game.game_over()) {
     state.innerHTML = 'GAME OVER';
     socket.emit('gameOver', roomId)
 }


	  // illegal move
	  if (move === null) return 'snapback';

       // if the move is allowed, emit the move event.
    else
       socket.emit('move', { move: move, board: game.fen(), room: roomId });

	  updateStatus();
	};

	// update the board position after the piece snap 
	// for castling, en passant, pawn promotion
	var onSnapEnd = function() {
	  board.position(game.fen());
	};

	var updateStatus = function() {
	  var status = '';

	  var moveColor = 'White';
	  if (game.turn() === 'b') {
		moveColor = 'Black';
	  }

	  // checkmate?
	  if (game.in_checkmate() === true) {
		status = 'Game over, ' + moveColor + ' is in checkmate.';
	  }

	  // draw?
	  else if (game.in_draw() === true) {
		status = 'Game over, drawn position';
	  }

	  // game still on
	  else {
		status = moveColor + ' to move';

		// check?
		if (game.in_check() === true) {
		  status += ', ' + moveColor + ' is in check';
		}
	  }

	  statusEl.html(status);
	  fenEl.html(game.fen());
	  pgnEl.html(game.pgn());
	  console.log(board);
	};

	 var cfg = {
			 draggable: true,
			 onDragStart: onDragStart,
			 onDrop: onDrop,
			 onSnapEnd: onSnapEnd,
			 dropOffBoard: 'snapback',
			 position: 'start'
		 };
		 
		 board = ChessBoard('board1', cfg);
		 
	updateStatus(); 
	
	socket.on('player', (msg) => {

 var plno = document.getElementById('player')

 // we're passing an object -
 // { playerId, players, color, roomId } as msg
 color = msg.color;

 // show the players number and color in the player div
 players = msg.players;
 plno.innerHTML = 'Player ' + players + " : " + color;

 // emit the play event when 2 players have joined
 if(players == 2){
   play = false;
   // relay it to the other player that is in the room
   socket.emit('play', msg.roomId);
   // change the state from 'join room' to -
   state.innerHTML = "Game in Progress"
 }
 // if only one person is in the room
 else
   state.innerHTML = "Waiting for Second player";

 */
</script>
		

	
	<div id="options-window" class="fg-creamy bg-lightgrey"></div>
	<div class="whitepage">
		<?php
			if (file_exists ( "serverlog.html" ) && filesize ( "serverlog.html" ) > 0) {
				$handle = fopen ( "serverlog.html", "r" );
				$contents = fread ( $handle, filesize ( "serverlog.html" ) );
				fclose ( $handle );
				echo $contents;
			}
		?>
		<!--<div id="photoform">-->
		<form action="upload2.php" method="post" enctype="multipart/form-data" id="myform">
		<div id="buttons">
		    <input type="button" id="emote" name="emote" value="Faces" onclick="loadOptionsWindow('/html/face_windows.html')">
			<input type="button" value="Change Background" onclick="loadOptionsWindow('custombg/options-window.html')">
		</div>
			<!--<div class='preview'>
				 <img src="" id="img" width="100" height="100">
			</div>-->
				
			<?php
				/*if (file_exists ( "serverlog.html" ) && filesize ( "serverlog.html" ) > 0) {
					$handle = fopen ( "serverlog.html", "r" );
					$contents = fread ( $handle, filesize ( "serverlog.html" ) );
					fclose ( $handle );
					echo $contents;
				}*/
			?>
		</form>
		<script type="text/javascript" src="custombg/js/custombg-loader.js"></script>
	</div>
	<div id="imgmessage">
		<form name="message" action="">
			<input id="userform" name="userform" type="text" size="63">
			<input id="submitmsg" name="submitmsg" type="button" value="submit">
		</form>		
	</div>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
	<script type="text/javascript">	
	
	/*$(document).ready(function(){

    $("#but_upload").click(function(){

        var fd = new FormData();
        var files = $('#file')[0].files[0];
        fd.append('file',files);

        $.ajax({
            url: 'upload3.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    $("#img").attr("src",response); 
                    $(".preview img").show(); // Display image element
                }else{
                    alert('file not uploaded');
                }
            },
        });
    });
});
	
	
	if (!file.type.match('image.*')) {
  window.alert("unsupported file type")
};*/

 /*var fd = new FormData();
    fd.append("file", file);

    xhr.open("POST", "http://localhost/upload2.php");
    xhr.onloadend = function(e) {
        xhr.responseText;
        if(callback) {
        callback();
    }
}*/
		$(document).ready(function(){
		});
		$("#submitmsg").click(function(){
				var clientmsg = $("#userform").val();
				$.post("postserver.php", {text: clientmsg});
				$("#userform").attr("value", "");
				loadLog;
			return false;
		})
		function loadLog(){
			var oldscrollHeight = $("#chatform").attr("scrollHeight") - 20; //Scroll height before the request
			$.ajax({
				url: "serverlog.html",
				cache: false,
				success: function(html){
					$("#chatform").html(html); //Insert chat log into the #chatbox div
					//Auto-scroll
					var newscrollHeight = $("#chatform").attr("scrollHeight") - 20; //Scroll height after the request
					if(newscrollHeight > oldscrollHeight){
						$("#chatform").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
					}
				},
			});
		}
		setInterval (loadLog, 1000);
		
		/*function loadPhoto () {
			$.ajax({
				url: "serverlog.html",
				cache: false,
				success: function(html){
					$("#photoform").html(html); //Insert chat log into the #chatbox div
					//Auto-scroll
					var newscrollHeight = $("#photoform").attr("scrollHeight") - 20; //Scroll height after the request
					if(newscrollHeight > oldscrollHeight){
						$("#photoform").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
					}
				},
			});
		}*/

	
	</script>
	<script type="text/javascript" src="custombg/js/custombg-loader.js"></script>
</body>
</html>