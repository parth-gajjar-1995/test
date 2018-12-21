<?php
session_start();

if(isset($_SESSION['login_status']) || $_SESSION['login_status'] == '1'):
	echo '<script type="text/javascript">window.location="chat.php";</script>';
endif;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	
	<title>Chat App</title>

	<!-- Scripts -->
	 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

	<!-- Styles -->
	
</head>
<body>
		<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">Chat App</a>
    </div>
  </div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<form id="loginForm">
				<div class="form-group">
					<label>Username</label>
					<input type="text" name="username" class="form-control">
				</div>

				<div class="form-group">
					<label>Password</label>
					<input type="password" name="password" class="form-control">
				</div>
				<input type="hidden" name="action" value="loginaction">
				<div class="form-group">
					<input type="submit" name="submit" class="btn btn-success" value="Sign up">
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>	
<script type="text/javascript">
	$('#loginForm').submit(function (event) {
		event.preventDefault()
		$.ajax({
			url : 'action.php',
			type : 'POST',
			data : $(this).serialize(),
			success : function(response){
				var response = JSON.parse(response)
				if(response.result == 'success')
					window.location = 'chat.php'
			}
		})
	})
</script>
</body>
</html>
