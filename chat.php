<?php
session_start();

if(!isset($_SESSION['login_status']) || $_SESSION['login_status'] != '1'):
	echo '<script type="text/javascript">window.location="index.php";</script>';
endif;
?>
<html>
	<head>
		<title>Chat App With Socket</title>

	 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
		<style>
  .chat {
	list-style: none;
	margin: 0;
	padding: 0;
  }

  .chat li {
	margin-bottom: 10px;
	padding-bottom: 5px;
	border-bottom: 1px dotted #B3A9A9;
  }

  .chat li .chat-body p {
	margin: 0;
	color: #777777;
  }

  .panel-body {
	overflow-y: scroll;
	height: 350px;
  }

  ::-webkit-scrollbar-track {
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
  }

  ::-webkit-scrollbar {
	width: 12px;
	background-color: #F5F5F5;
  }

  ::-webkit-scrollbar-thumb {
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
	background-color: #555;
  }
</style>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>

	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<span><?php if(isset($_SESSION['login_user']) && $_SESSION['login_user'] != '' ): echo $_SESSION['login_user']; endif; ?></span>
							<a style="float: right;" href="action.php?action=signout">Logout</a>
						</div>

						<div class="panel-body">
							
						</div>
						<div class="panel-footer">
							<form id="sendMEssage" name="sendMEssage" method="POST">
								 <div class="input-group">
									<input id="btn-input" type="text" name="message" class="form-control input-sm" placeholder="Type your message here...">
									<input type="hidden" name="from" value="<?php if(isset($_SESSION['login_id']) && $_SESSION['login_id'] != '' ): echo $_SESSION['login_id']; endif; ?>">
									<span class="input-group-btn">
										<button  type="submit" class="btn btn-primary btn-sm" id="btn-chat">
											Send
										</button>
									</span>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="https://js.pusher.com/4.2/pusher.min.js"></script>
		<script type="text/javascript">
			var socket = io('http://localhost:5681')

			function getMessages(messages) {
				var html = ''	
				var userid = '<?php if(isset($_SESSION['login_user']) && $_SESSION['login_user'] != '' ): echo $_SESSION['login_user']; else: echo ''; endif; ?>';
				for(x in messages){
					if(userid != ''){
						if(userid == messages[x].name){
							html += '<ul class="chat">';
							html += '	<li class="left clearfix">';
							html += '		<div class="chat-body clearfix">';
							html += '			<div class="header" style="float:right;">';
							html += '				<strong class="primary-font">'+ messages[x].name + '</strong>';
							html += '				<p>' + messages[x].message + '</p>';
							html += '			</div>';
							html += '		</div>';
							html += '	</li>';
							html += '</ul>';
						}else{
							html += '<ul class="chat">';
							html += '	<li class="left clearfix">';
							html += '		<div class="chat-body clearfix">';
							html += '			<div class="header">';
							html += '				<strong class="primary-font">'+ messages[x].name + '</strong>';
							html += '				<p>' + messages[x].message + '</p>';
							html += '			</div>';
							html += '		</div>';
							html += '	</li>';
							html += '</ul>';	
						}
					}
					
				}
				$('.panel-body').html('')
				$('.panel-body').html(html)
				if(messages.length == 0)
				{
					$('.panel-body').html('<center>No Messages</center>')	
				}
			}

			function notifyMe(title,options,user_data) {
				Notification.requestPermission().then(function (permission) {
					if (permission === "granted") {

						var n = new Notification(title, options)
						n.onclick = function(x) { 
							window.focus();
							window.reload(); 
							this.close(); 
						};
						setTimeout(n.close.bind(n), 4000);
					}
				})
			}


			$(document).ready(function(){
				var user_data = {
					from : $('input[name="from"]').val(),
				}

				window.onblur = (function () {

					socket.emit('unreadMessage',user_data)
					socket.on('unreadMessageResponse',function (data) {
						if(data.length > 0){
							for(x in data){
								notifyMe(data[x].name,{ 'body' : data[x].message },user_data)	
							}							
						}else{
							return false;
						}
					})	
				});	
				
				
									

				

				socket.emit('updateMessageStatus',user_data)	

				socket.emit('message')
					socket.on('messageResponse',function (messages) {
					getMessages(messages)
				})  
				setInterval(function(){ 
					socket.emit('message')
					socket.on('messageResponse',function (messages) {
						getMessages(messages)
					}) 
				}, 2000)

				$('#sendMEssage').submit(function (event) {
					event.preventDefault()

					var user_data = {
						from : $('input[name="from"]').val(),
						message : $('input[name="message"]').val()
					}

					socket.emit('sendMessage',user_data)
					socket.on('sendMessageResponse')
					socket.emit('getMessage')
					socket.on('getMessageResponse',function (messages) {
						getMessages(messages)
					})
					$('input[name="message"]').val('')
				})
	
				
			});	


		</script>
	</body>
</html>