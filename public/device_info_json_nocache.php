<?php

$CLIENT_ID = "dc5152559e03867e794c";
$SECRET_ID = "f2b7868fd2a52e5233484a59d5bf63f8f2b54b1c";

function get_url($url){

	$header[] = "User-Agent: Helper Process";
	$header[] = "Accept-Language: en-us,en;q=0.5";

    $ch = curl_init();
	//curl_setopt($ch,     CURLOPT_VERBOSE, 1); ########### debug
	//curl_setopt($ch,     CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11");
//	curl_setopt ($ch, CURLOPT_NOPROGRESS, true);
	//curl_setopt ($ch, CURLOPT_HEADER, true);
	curl_setopt ($ch, CURLOPT_HTTPHEADER, $header);
	//curl_setopt ($ch, CURLOPT_POST, 1);
	//curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt ($ch, CURLOPT_URL, $url);
//	curl_setopt ($ch, CURLINFO_HEADER_OUT, true);

    ob_start();
    curl_exec ($ch);

    curl_close ($ch);
    $raw_response = ob_get_contents();
    ob_end_clean();

	return trim($raw_response) ;
}

function get_cached_data($key)
{
    $memcached = new Memcached();
    $memcached->addServer("127.0.0.1", 11211);
    
    $cached_data = $memcached->get($key);
    
    if (!$cached_data) {
        $response = get_url($key);
        $memcached->set($key, $response, 5); // Cache for 5 seconds
        return $response;
    } else {
        return $cached_data;
    }
}

//https://connect-live.blacklinesafety.com/docs/1/get/authorize
function get_authorize_code($client_id)
{
    $response = get_url("https://production-connect.blacklinesafety.com/1/authorize?response_type=code&client_id=$client_id&scope=read+write");

    $json_obj = json_decode($response);
    
    return $json_obj->code;

}

function get_token($auth_code, $client_id, $client_secret)
{

    $response = get_url("https://production-connect.blacklinesafety.com/1/token?grant_type=authorization_code&code=$auth_code&client_id=$client_id&client_secret=$client_secret");

    $json_obj = json_decode($response);
    return $json_obj->access_token;
    
}

function get_device($access_token)
{

    $response = get_url("https://production-connect.blacklinesafety.com/1/device?access_token=$access_token");

    return $response;
    //$json_obj = json_decode($response);
    
    //print_r($json_obj);
    
}

$auth_code = get_authorize_code($CLIENT_ID);

$access_token = get_token($auth_code, $CLIENT_ID, $SECRET_ID);

//print_r($access_token);

$response = get_device($access_token);


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

header('Content-Type: application/json; charset=utf-8');
//header('Access-Control-Allow-Origin: *');

if (isset ($_REQUEST['debug']) )
{
    $json_obj = json_decode($response);
    $json_string = json_encode($json_obj, JSON_PRETTY_PRINT);
    echo $json_string;
}
else
{
    echo $response;
}


?>