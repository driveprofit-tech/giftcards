<?

if(strpos(dirname(__FILE__),'www') !== false)
{

	define("BASE_PATH", "http://localhost/giftcards/");
	define("LOCAL_PATH", "C:/wamp64/www/giftcards/");

	define("MAIN_DOMAIN", "");
	define("MAIN_IP", "");

}
else
{
	define("BASE_PATH", "https://loyaltyrewards.limo/giftcards/");
	define("LOCAL_PATH", "/home/loyaltyrewards/public_html/giftcards/");

	define("MAIN_DOMAIN", "");
	define("MAIN_IP", "");
}

define("APP_SALT", "g1ftcrd5%");

define("AUTHORIZENET_PAYMENT_URL_LIVE", "https://secure.authorize.net/gateway/transact.dll");
define("AUTHORIZENET_PAYMENT_URL_SANDBOX", "https://test.authorize.net/gateway/transact.dll");

define("AUTHORIZENET_API_LOGIN_ID_SANDBOX", "77e69XCck4y3");
define("AUTHORIZENET_TRANSACTION_KEY_SANDBOX", "58F2Tc8cxM9k4B76");
define("AUTHORIZENET_SIGNATURE_SANDBOX", "620C3B7D644DADF235625B6018F496E31DBDD388ABD7C3A0C2057A652B226CD217D659D4F66ACAC5212B085BE052B958E842B9D8F9E9273048B26E8D6CDEA2E2");

define("PAYPAL_API_USERNAME", "aurash-facilitator_api1.driveprofit.com");
define("PAYPAL_API_PASSWORD", "W525ETL5C5C6T7UN");
define("PAYPAL_API_SIGNATURE", "AFUzd6d5BFLcPs.756upyW0L6Uo6A1Ple9obtdpvLvmyxMit1Sf3-USN");

?>