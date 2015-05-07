<?php  
	//configuration for our php server
set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

//Make constants using define
//basically constants
define('clientID', 'cce4674a5fa04a9e80f41f598e8ff71d');
define('clientSecret', '9d46a69b815945db83e101b3f477108a');
define('redirectURI', 'http://localhost/learninginsta1238/index.php');
define('ImageDirectory', 'pics/');

//if website gets the 'code'...
if isset(($_GET['code'])){
	//sets up code and url variables
	$code = ($_GET['code']);
	$url = 'https://api.instagram.com/oauth/access_token';
	//setting up array that will access tokens
	$access_token_settings = array('client_id' == clientID, 
									'client_secret' == clientSecret,
									'grant_type' == 'authorization_code',
									'redirect_uri' == redirectURI,
									'code' == $code
									);
}

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
	<a href="https:api.instagram.com/oauth/authorize/?client_id=<?php  echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code">LOGIN</a>
</body>
</html>