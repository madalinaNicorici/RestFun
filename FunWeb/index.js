var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var request = require('request');

var Client = require('node-rest-client').Client;
var client = new Client();
var newdata;
var scores=[];
	
var x = Math.floor((Math.random() * 160) + 1);
client.get("http://localhost/ProTw/FunWeb/questions/question/"+x, function (data, response) {
	newdata=data;
});

app.get('/', function(req, res){
  res.sendfile('index.html');
});

io.on('connection', function(socket)
{
	scores=[];
	
	//making a room
	socket.on('create room',function(msg)
	{	
		console.log(msg);
		request.post('http://localhost/ProTw/FunWeb/rooms/room/', {form:{name:msg["name"],room_password:msg["room_password"],player1:msg["player1"]}}, function(err,httpResponse,body){
			console.log(body);
			newdata=body.message; });
		//id-ul camerei
		msg.id_room=newdata;
		io.emit('show room',msg);
		io.emit('new room',newdata);
	});
	
	//joining a room
	var _room, _id, _player;
 
	socket.on( 'cjoin', function ( msg ) {
		_room= msg;
		// Join the room.
        socket.join( _room );
		//ai intrat in camera
	});
	socket.on( 'join', function ( msg ) {
		_room= msg;
        // Join the room.
        socket.join( _room );
		//ai intrat in camera
		if(data.message.player2)
		io.sockets.in( _room ).emit( 'ready' );
    });
   
   //playing the game
	socket.on('play', function(msg)
	{
		io.emit('play', newdata.message);
		var x = Math.floor((Math.random() * 160) + 1);
		client.get("http://localhost/ProTw/FunWeb/questions/question/"+x, function (data, response) 
		{
			newdata=data;
		});
		setTimeout(function(){io.emit('emit again',"");return false;
		},10000);
	});
	socket.on('return score',function(msg)
	{
		scores.push(msg);
		io.emit('getWinner',scores.toString());
	});
});

http.listen(3000, function(){
  console.log('listening on *:3000');
});

function escapeHtml(text) {
  return text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
}