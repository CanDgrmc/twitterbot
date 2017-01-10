

<?php
session_start();
require 'twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

define("CONSUMER_KEY", "");
define("CONSUMER_SECRET", "");
define("OAUTH_CALLBACK","");
if (!isset($_SESSION['access_token'])) {
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
	echo $url;
} else {
	$access_token = $_SESSION['access_token'];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$user = $connection->get("account/verify_credentials");

	echo $user->screen_name. "<br>";
	$name=$_GET['name'];
	$tweets=$connection->get('statuses/user_timeline',['count'=> 300 ,'exclude_replies'=>true , 'include_rts'=>false , 'screen_name'=> $name]);
	$toplam[]=$tweets;
	$start=1;
	$say=count($tweets);

	foreach ($toplam as $tweet) {

		foreach ($tweet as $text) {
			
			
			
				echo $start.': '.$text->text . '<br>';
				$start+=1;
				if ($say==$start-1) {
					echo "<h3>";
					echo "Görüntülenecek Başka Tweet Bulunmamaktadır";
					echo "</h3>";
				}

			

		}
	}


}
?>
<a href="gonder.php">Geri Dön</a>
