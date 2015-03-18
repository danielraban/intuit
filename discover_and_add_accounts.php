<?php

/*
* Step 3
* This example has three steps, first it detects existing accounts for the user
* Then it deletes all the accounts stored on the CAD API. Then it calls the 
* discoverAndAddAccounts method to pull in new accounts. It does this due to the
* limit on number of accounts a test app can connect to. 
*/

set_time_limit ( 5000 );
require_once('config.php');
require_once("class.aggcatauth.php");

IntuitAggCatHelpers::GetOAuthTokens($oauth_token, $oauth_token_secret);

$instituationID = 100000;

$path_getaccounts = FINANCIAL_FEED_URL .'v1/accounts';

$path = FINANCIAL_FEED_URL .'v1/institutions/'.$instituationID.'/logins';
$host = FINANCIAL_FEED_HOST;

// XML body to discover new accounts. 
$post = '<InstitutionLogin xmlns="http://schema.intuit.com/platform/fdatafeed/institutionlogin/v1">
    <credentials>
        <credential>
            <name>Banking Userid</name>
            <value>demo</value>
        </credential>
        <credential>
            <name>Banking Password</name>
            <value>go</value>
        </credential>
    </credentials>
</InstitutionLogin>';

$oauth = new OAuth(OAUTH_CONSUMER_KEY,
                   OAUTH_SHARED_SECRET,
       OAUTH_SIG_METHOD_HMACSHA1,
		   OAUTH_AUTH_TYPE_AUTHORIZATION);

$oauth->setToken($oauth_token,$oauth_token_secret);
$AccountsToDelete = array();

////// Demo 1: Enumerate
echo "Example 1: Demo of enumerating accounts that user configured previously:\n";
try 
{
	$ExtraHeaders = array('Host'=>'financialdatafeed.platform.intuit.com');
        $oauth->fetch($path_getaccounts,
                      FALSE,
                      OAUTH_HTTP_METHOD_GET,
                      $ExtraHeaders);
	$ResponseXml = $oauth->getLastResponse();

	// Enumerate accounts - quick and dirty (improve w/ correct namespace + xpath use)
	CleanseXmlOfNamespaces($ResponseXml);	
	$xmlObj = simplexml_load_string($ResponseXml);
	foreach($xmlObj as $accountObj)
	{	
		$accountId = (string)$accountObj->accountId;
		$AccountsToDelete[] = $accountId;
		echo " * Found account: ". $accountId ."\n";
	}

}
catch(OAuthException $e)
{
        echo "Exception: " . $e->getMessage();;
}

////// Demo 2: Delete
echo "\nExample 2: Demo of deleting accounts: " . implode(", ", $AccountsToDelete) . "\n";
if (count($AccountsToDelete)>0)
{
	$ExtraHeaders = array("Content-Type" => "application/xml", 'Host'=>'financialdatafeed.platform.intuit.com');
	foreach($AccountsToDelete as $OneAccount)
	{

		echo " * Delete account: $OneAccount\n";
		$path_delete = FINANCIAL_FEED_URL .'v1/accounts/'.$OneAccount;
		 
		try 
		{
			$oauth->fetch($path_delete,
				      FALSE,
				      OAUTH_HTTP_METHOD_DELETE,
			              $ExtraHeaders);

		}
		catch(OAuthException $E)
		{
	       		 echo "Exception:\n";
        		var_dump($oauth->getLastResponseHeaders());
		}
	}
}

////// Demo 3: Discover
echo "\nExample 3: Discover on a new account via end user bank creds\n\n";
try
{
	$ExtraHeaders = array("Content-Type" => "application/xml", 'Host'=>'financialdatafeed.platform.intuit.com');
	$oauth->fetch($path,
	              $post,
	              OAUTH_HTTP_METHOD_POST,
	              $ExtraHeaders);

	$ResponseXml = $oauth->getLastResponse();

	$ResponseHeadersRaw = $oauth->getLastResponseHeaders();

	echo $ResponseXml;
 }
 catch(OAuthException $E)
 {
 	echo "Exception:\n";
	var_dump($oauth->getLastResponseHeaders());
 }


function CleanseXmlOfNamespaces(&$ResponseXml)
{
        for($i=1;$i<10;$i++)
                $ResponseXml = str_replace("ns{$i}:","",$ResponseXml);	
}

?> 