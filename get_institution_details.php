 <?php
 
/*
* Step 2
* This example pulls in the detailed information for 
* a specific institution. 
* Edit the instituationID variable with an account from Step 1
*/

// institution id to get details from
// edit this if you want to see details for other institutions
$instituationID = '300002';

 
set_time_limit ( 5000 );
require_once('config.php');
require_once("class.aggcatauth.php");

IntuitAggCatHelpers::GetOAuthTokens($oauth_token, $oauth_token_secret);


$signatures = array( 'consumer_key'     => OAUTH_CONSUMER_KEY,
                     'shared_secret'    => OAUTH_SHARED_SECRET,
                     'oauth_token'      => $oauth_token,
                     'oauth_secret'     => $oauth_token_secret);


$oauthObject = new OAuthSimple();
$oauthObject->reset();
$result = $oauthObject->sign(array(
    'path'      => FINANCIAL_FEED_URL .'v1/institutions/'.$instituationID,
    'parameters'=> array('oauth_signature_method' => 'HMAC-SHA1', 
    'Host'=> FINANCIAL_FEED_HOST),
    'signatures'=> $signatures));

$options = array();
$options[CURLOPT_VERBOSE] = 1;
$options[CURLOPT_RETURNTRANSFER] = 1;

$ch = curl_init();
curl_setopt_array($ch, $options);
curl_setopt($ch, CURLOPT_URL, $result['signed_url']);
$r = curl_exec($ch);
curl_close($ch);
parse_str($r, $returned_items);  	   

//
// Load Response Body into a SimpleXML object
//		
$ResponseXML = substr($r, strpos($r, "<" . "?xml"));
$xmlObj = simplexml_load_string($ResponseXML);

//
// Simple output to visually confirm that everything went well...
//
var_dump($ResponseXML);
var_dump($xmlObj);

?>
