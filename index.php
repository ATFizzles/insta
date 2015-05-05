<?php  
	//configuration for our php server
set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

//Make constants using define
//basically constants
define('client_ID', 'cce4674a5fa04a9e80f41f598e8ff71d');
define('client_Secret', '9d46a69b815945db83e101b3f477108a');
define('redirectURI', 'http://localhostlearninginsta1238/index.php');
define('ImageDirectory', 'pics/');
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<!-- Creating a login for people to go and give approval for our web app to access their Instagram Account
		After getting approval we are now going to have the info so that we can play with it
	 -->
	<a href="https:api.instagram/oauth/authorize/?client_id=<?php  echo client_ID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code">LOGIN</a>
</body>
</html>