<?php

if(strpos(dirname(__FILE__),'www') !== false)
{
	define("dbHost", "localhost");
	define("dbUser", "root");
	define("dbPass", "");
	define("dbName", "giftcards");
}
else
{
	define("dbHost", "localhost");
	define("dbUser", "loyaltyr_auras");
	define("dbPass", "auras!@#$");
	define("dbName", "loyaltyr_giftcards");
}

?>
