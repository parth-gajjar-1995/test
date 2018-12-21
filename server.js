const PORT = 5681
const express = require("express")
const app = express()
const http = require("http")
var server = http.createServer(app)
const path = require("path")
const io = require("socket.io")(server)
var mysql = require('mysql')
var Pusher = require('pusher');

const pusher = new Pusher({
  appId: '671438',
  key: '430a0aaf7dc21270a075',
  secret: '3e010a4dfbec61824c2f',
  cluster: 'ap2'
});

/*const socket = new Pusher('430a0aaf7dc21270a075', {
  cluster: 'ap2',
  authEndpoint: 'http://localhost/auth',
  forceTLS: true
});
*/
server.listen(PORT, function() {
	  console.log("server listening on port " + PORT)
})


var con = mysql.createConnection({
	host: "localhost",
	user: "root",
	password: "",
	database: "chatnode"
})

io.on('connection', function (socket) {

	socket.on('message',function(msg){
		con.query('SELECT users.name, messages.message FROM `users` join messages ON messages.user_id = users.id ORDER BY messages.id ASC',function(err,rows){
			
			if(err) throw err;    
				
			socket.emit('messageResponse', rows)
		
		}) 
	})

	socket.on('getMessage',function(msg){
		con.query('SELECT users.name, messages.message FROM `users` join messages ON messages.user_id = users.id ORDER BY messages.id ASC',function(err,rows){
		
			if(err) throw err;    
		
			socket.emit('getMessageResponse', rows)
		
		}) 
	})

	socket.on('sendMessage',function(messageData){
		var currentdate = new Date(); 
		var datetime = currentdate.getFullYear() + "-"
                + (currentdate.getMonth()+1)  + "-"
                + currentdate.getDate() + " "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();
		con.query('INSERT INTO `messages` ( `message`, `user_id`, `created_at`) VALUES ("' + messageData.message + '"," ' + messageData.from + '", "' + datetime + '")',function(err,result){
			
			if(err) throw console.log(err);
			pusher.trigger('chat', 'getUnreadMessage', {  from : messageData.from , message: messageData.message });
			
			socket.emit('sendMessageResponse')
		
		}) 
	})

	socket.on('updateMessageStatus',function (userid) {
		con.query('UPDATE messages SET readStatus = "0" where user_id = "'+ userid.from +'"',function(err,rows){
		
			if(err) throw console.log(err);    

		})
	})

	socket.on('unreadMessage',function (userid) {
		con.query('SELECT users.name, messages.message FROM `users` join messages ON messages.user_id = users.id where messages.user_id != "'+ userid.from +'" AND messages.readStatus = "0"',function(err,rows){
		
			if(err) throw err;    

			socket.emit('unreadMessageResponse',rows)
		})
	})
})