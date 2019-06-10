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
var chatsection = document.getElementById('chatsection')

var connect = function(){
    roomId = room.value;
    if (roomId !== "" && parseInt(roomId) <= 100) {
        room.remove();
        roomNumber.innerHTML = "Room Number " + roomId;
        button.remove();
		var input = document.createElement("INPUT");
		input.setAttribute("id", "m")
		input.setAttribute("autocomplete", "off")
		var btn = document.createElement("BUTTON")
		btn.setAttribute("value", "Send")
		var ul = document.createElement("UL")
		ul.setAttribute("id", "messages")
		var frm = document.createElement("FORM")
		frm.setAttribute("action", "")
		document.chatsection.appendChild(ul)
		document.chatsection.appendChild(frm)
		document.chatsection.appendChild(input)
		document.chatsection.appendChild(btn)
		
        socket.emit('joined', roomId);
    }
}

socket.on('full', function (msg) {
    if(roomId == msg)
        window.location.assign(window.location.href+ 'full.html');
});

socket.on('play', function (msg) {
    if (msg == roomId) {
        play = false;
        state.innerHTML = "Game in progress"
    }
    // console.log(msg)
});

socket.on('move', function (msg) {
    if (msg.room == roomId) {
        game.move(msg.move);
        board.position(game.fen());
        console.log("moved")
    }
});



var board,
		 game = new Chess();
		  statusEl = $('#status'),
		  fenEl = $('#fen'),
		  pgnEl = $('#pgn');
		  
 var onDragStart = function(source, piece, position, orientation) {
    if (game.game_over() === true || play ||
        (game.turn() === 'w' && piece.search(/^b/) !== -1) ||
        (game.turn() === 'b' && piece.search(/^w/) !== -1) ||
        (game.turn() === 'w' && color === 'black') ||
        (game.turn() === 'b' && color === 'white') ) {
            return false;
    }
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
	
	socket.on('player', (msg) => {
    var plno = document.getElementById('player')
    color = msg.color;

    plno.innerHTML = 'Player ' + msg.players + " : " + color;
    players = msg.players;

    if(players == 2){
        play = false;
        socket.emit('play', msg.roomId);
        state.innerHTML = "Game in Progress"
    }
    else
        state.innerHTML = "Waiting for Second player";

	 var cfg = {
			 draggable: true,
			 onDragStart: onDragStart,
			 onDrop: onDrop,
			 onSnapEnd: onSnapEnd,
			 dropOffBoard: 'snapback',
			 position: 'start'
		 };
	setTimeout(function() {
		board = ChessBoard('board1', cfg);
		}, 0);
		 
	updateStatus()
	});