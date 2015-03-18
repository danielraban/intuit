<?php 

/*
* Step 4
* This example pulls in the transactions for a specific account. 
* Edit the accountID variable with an account from Step 3
*/

set_time_limit ( 5000 );                                                                                                                                                             
require_once('config.php');                                                                                                                                                          
require_once("class.aggcatauth.php");                                                                                                                                                
                                                                                                                                                                                     
IntuitAggCatHelpers::GetOAuthTokens($oauth_token, $oauth_token_secret);                                                                                                              
                                                                                                                                                                                     
$instituationID = 100000;                                                                                                                                                            
$accountID = '400011136334';
$txnStartDate = '2012-01-01';  // YYYY-MM-DD

$path_getAccountTransactions = FINANCIAL_FEED_URL ."v1/accounts/$accountID/transactions?txnStartDate=$txnStartDate";                                                                                                                               
                                                                                                                                                                                     
$path = FINANCIAL_FEED_URL .'v1/institutions/'.$instituationID.'/logins';                                                                                                            
$host = FINANCIAL_FEED_HOST;                                                                                                                                                         
                                                                                                                                                                                                                                                                                                                                                     
                                                                                                                                                                                     
$oauth = new OAuth(OAUTH_CONSUMER_KEY,                                                                                                                                               
                   OAUTH_SHARED_SECRET,                                                                                                                                              
           OAUTH_SIG_METHOD_HMACSHA1,                                                                                                                                                
                   OAUTH_AUTH_TYPE_AUTHORIZATION);                                                                                                                                   
                                                                                                                                                                                     
$oauth->setToken($oauth_token,$oauth_token_secret);                                                                                                                                  
                                                                                                                                                                                     
echo "Account Transactions for: $accountID \n\n";                                                                                                                                          
try                                                                                                                                                                                  
{                                                                                                                                                                                    
        $ExtraHeaders = array('Host'=>'financialdatafeed.platform.intuit.com');                                                                                                      
        echo "path: $path_getAccountTransactions\n";                                                                                                                                            
        $oauth->fetch($path_getAccountTransactions,                                                                                                                                             
                      FALSE,                                                                                                                                                         
                      OAUTH_HTTP_METHOD_GET,                                                                                                                                         
                      $ExtraHeaders);                                                                                                                                                
        $ResponseXml = $oauth->getLastResponse();                                                                                                                                    
        echo $ResponseXml . "\n\n";                                                                                                                                                  
}                                                                                                                                                                                    
catch(OAuthException $E)                                                                                                                                                             
{                                                                                                                                                                                    
        echo "Exception:\n";                                                                                                                                                         
        var_dump($oauth->getLastResponseHeaders());                                                                                                                                  
}

?>
                                                