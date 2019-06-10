const express = require('express');
const http = require('http');
const socket = require('socket.io');

// use 8080 as the default port number, process.env.PORT is
//useful if you deploy to Heroku
const port = process.env.PORT || 8080

var app = express();

// start the server
const server = http.createServer(app)

// initialize a new instance of socket.io by passing the HTTP server object
const io = socket(server)

// keep track of how many players in a game (0, 1, 2)
var players;

var joined = true;

app.use(express.static(__dirname + "/"));

// create an array of 100 games and initialize them
var games = Array(100);
for (let i = 0; i < 100; i++) {
   games[i] = {players: 0 , pid: [0 , 0]};
}

app.get('/', (req, res) => {
   res.sendFile(__dirname + '/chesstest.html');
});

io.on('connection', function (socket) {

 // just assign a random number to every player that has connected
 // the numbers have no significance so it
 // doesn't matter if 2 people get the same number
 var color; // black or white
 var x = '_' + Math.random().toString(36).substr(2, 9);
 console.log(x + ' connected');

 // if a user disconnects just print their playerID
 socket.on('disconnect', function () {
   console.log(x + ' disconnected');
 });

// 'joined' is emitted when the player enters a room number and clicks
// the connect button the room ID that the player entered gets passed as a message

socket.on('joined', function (roomId) {
 // if the room is not full then add the player to that room
 if (games[roomId].players < 2) {
     games[roomId].players++;
     games[roomId].pid[games[roomId].players - 1] = x;
 } // else emit the full event
 else{
     socket.emit('full', roomId)
     return;
 }
  console.log(games[roomId]);
 players = games[roomId].players
  // the first player to join the room gets white
 if (players % 2 == 0) color = 'black';
 else color = 'white';

 // this is an important event because, once this is emitted the game
 // will be set up in the client side, and it'll display the chess board
 socket.emit('player', { x, players, color, roomId })

});

// The client side emits a 'move' event when a valid move has been made.
socket.on('move', function (msg) {
 // pass on the move event to the other clients
 socket.broadcast.emit('move', msg);
});

// 'play' is emitted when both players have joined and the game can start
socket.on('play', function (msg) {
 socket.broadcast.emit('play', msg);
 console.log("ready " + msg);
});

// when the user disconnects from the server, remove him from the game room
socket.on('disconnect', function () {
 for (let i = 0; i < 100; i++) {
     if (games[i].pid[0] == x || games[i].pid[1] == x)
         games[i].players--;
 }
 console.log(x + ' disconnected');

});

socket.on('chat message', function(msg){
    console.log('message: ' + msg);
  });
  
   socket.on('new_message', (data) => {
        io.sockets.emit('new_message', {message : data.message, username : socket.username});
    })
});

});

server.listen(port);
console.log('Connected');