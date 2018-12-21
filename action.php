<?php
session_start();
$con = mysqli_connect('localhost','root','','chatnode');

$result = array();

if(!$con):
	$result['result'] = 'failed';	
endif;

if($_POST['action']):
	$action = $_POST['action'];
elseif($_GET['action']):
	$action = $_GET['action'];
endif;

if(isset($action) && $action != ''):

	if($action == 'loginaction'):

		$query = 'select id,name from users where email = "'.$_POST['username'].'" AND password ="'.$_POST['password'].'"';

		$sql=mysqli_query($con,$query);
		
		if(mysqli_num_rows($sql) == 1):

			$user = mysqli_fetch_assoc($sql);
			
			$_SESSION['login_id'] = $user['id'];

			$_SESSION['login_user'] = $user['name'];

			$_SESSION['login_status'] = '1';

			$result['result'] = 'success';

		else:
			$result['result'] = 'failed';
		endif;

	elseif($action == 'signout'):

		session_destroy();

		echo '<script type="text/javascript">window.location="index.php";</script>';	
		exit();

	else:
		$result['result'] = 'failed';
	endif;

else:
	$result['result'] = 'failed';
endif;

print_r(json_encode($result));