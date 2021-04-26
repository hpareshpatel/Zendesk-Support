<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);


define("ZDAPIKEY", "*****lAneZFRFpPd4jvby*****************");
define("ZDUSER", " user@zendesk.com");

{
	$url = 'https://<instance-name>.zendesk.com/api/v2/tickets';
	$header[] = "Content-type: application/json";

	$ch = curl_init();
//	$url = "https://libasdelhi.zendesk.com/api/v2/tickets/recent.json";   /// get recent ticket json
	$url = "https://libasdelhi.zendesk.com/api/v2/search.json?query=13239";

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERPWD, ZDUSER."/token:".ZDAPIKEY);
	
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 600);
	$output = curl_exec($ch);
	curl_close($ch);
	$decoded = json_decode($output);
	
	var_dump($decoded);
}
