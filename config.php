<?php

define('SIMPLESAML_PATH',  './simplesamlphp-1.11.0/');
define('SIMPLEOAUTH_PATH',  './');

// Update this section
define('OAUTH_CONSUMER_KEY',   'qyprdIMRUTBqtg5qCKDgmhvhMKGy2T');
define('OAUTH_SHARED_SECRET',  'mvY3QUsa3MjPqPOcMmr2NeZHa654PItqmE6LGPpW');
define('SAML_IDENTITY_PROVIDER_ID',  'test1.71592.cc.dev-intuit.ipp.prod');
define('SAML_X509_CERT_PATH',        './keys/testapp1.crt');
define('SAML_X509_PRIVATE_KEY_PATH', './keys/testapp1.key');
// end update section

define('SAML_NAME_ID',               'user01');  // Up to you; just "keep track" of what you use

define('OAUTH_SAML_URL', 'https://oauth.intuit.com/oauth/v1/get_access_token_by_saml');
define('FINANCIAL_FEED_HOST', 'financialdatafeed.platform.intuit.com');
define('FINANCIAL_FEED_URL', 'https://'.FINANCIAL_FEED_HOST.'/');

require_once(SIMPLESAML_PATH . "/lib/xmlseclibs.php");
require_once(SIMPLESAML_PATH . "/lib/SimpleSAML/Utilities.php");
require_once(SIMPLEOAUTH_PATH . "/OAuthSimple.php");