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


//function thats gonna connect to instagram
function connectToInstagram($url){
	$ch = curl_init();

	curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_SSL_VERIFYHOST => 2,
	));
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

//Function to get userID cause userName doesn't allow us to get pictures
function getUserID($userName){
	$url = 'https://api.instagram.com/v1/users/search?q='. $userName .'&client_id='.clientID;
	$instagramInfo = connectToInstagram($url);
	$results =json_decode($instagramInfo, true);

	return $results['data']['0']['id'];

}

//function to print out images onto screen
function printImages($userID, $accessToken){
	$url = 'https://api.instagram.com/v1/users/'. $userID .'/media/recent?access_token='.$accessToken.'&count=5';
	$instagramInfo = connectToInstagram($url);
	$results =json_decode($instagramInfo, true);
	//parse through the info one by one
	foreach ($results['data'] as $items){
		$image_url = $items['images']['low_resolution']['url']; //going to go thru results and give back url of pics bc we want to save it in php server
		echo '<img src=" '.$image_url.' "/><br/>';
		//calling function to save $image_url
		savePictures($image_url);
	}
}

//function to save image to server
function savePictures($image_url){
		echo $image_url	.'<br>'; 
		//filename is what we are storing
		//basename is the PHP built in method that we are using to store $image_url
		$filename = basename($image_url);
		echo $filename . '<br>';
		//making sure image doesnt exist in storage
		$destination = ImageDirectory . $filename;
		//grabs image file and stores it in server
		file_put_contents(	$destination, file_get_contents($image_url));	
}


//if website gets the 'code'...
if (isset($_GET['code'])){
	//sets up code and url variables
	$code = ($_GET['code']);
	$url = 'https://api.instagram.com/oauth/access_token';
	//setting up array that will access tokens
	$access_token_settings = array('client_id' => clientID, 
									'client_secret' => clientSecret,
									'grant_type' => 'authorization_code',
									'redirect_uri' => redirectURI,
									'code' => $code
									);
//cURL is what we use in php, it's a library that calls to other API's.
//setting a curl session and we put in $url bc thats where we are getting the data from.
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, true);
//aetting the POSTFIELDS to the array setup that we created. 
curl_setopt($curl, CURLOPT_POSTFIELDS, $access_token_settings);
//setting it equal to 1 bc we are getting strings back.
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//but in live work-production we want to set this to true.
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);


$result = curl_exec($curl);
curl_close($curl);

$results = json_decode($result, true);

$userName = $results['user']['username'];

$userID = getUserID($userName);

printImages($userID, $results['access_token']);
}
else{
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
	<a href="https://api.instagram.com/oauth/authorize/?client_id=<?php  echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code">LOGIN</a>
</body>
</html>
<?php
}
?>