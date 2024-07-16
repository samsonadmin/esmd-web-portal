<?php
date_default_timezone_set('Asia/Hong_Kong');


function class_to_words($detections)
{
	switch ($detections) {
		case "helmet_unknown":
			return "(Safety Helmet Detected, 有配戴安全帽）";
			break;				
		case "helmet_bad":
			return "PPE Alert: Improper Safety Helmet! \n個人防護裝備警報：安全帽配戴不當！";
			break;
		case "HELMET BAD":
			return "PPE Alert: Improper Safety Helmet! \n個人防護裝備警報：安全帽配戴不當！";
			break;			
		case "BAD":
			return "PPE Alert: Improper Safety Helmet! \n個人防護裝備警報：安全帽配戴不當！";
			break;			
		case "helmet_none":
			return "PPE Alert: Not wearing Safety Helmet! \n個人防護裝備警報：沒有配戴安全帽！";
			break;
		case "HELMET NONE":
			return "PPE Alert: Not wearing Safety Helmet! \n個人防護裝備警報：沒有配戴安全帽！";
			break;			
		case "helmet_ok":
			return "(Safety Helmet Detected, 有配戴安全帽）";
			break;		
		case "helmet_yes":
			return "(Proper Safety Helmet, 安全帽配戴正確）";
			break;
		case "helmet_good":
			return "(Proper Safety Helmet, 安全帽配戴正確）";
			break;			
		case "HELMET GOOD":
			return "(Proper Safety Helmet, 安全帽配戴正確）";
			break;				
		case "NONE":
			return "PPE Alert: Not wearing Safety Helmet! \n個人防護裝備警報：沒有配戴安全帽！";
			break;			
		case "vest_none":
			return "PPE Alert: Reflective Vest Absent!\n個人防護裝備警報：沒有配戴反光衣！";
			break;
		case "NO VEST":
			return "PPE Alert: Reflective Vest Absent!\n個人防護裝備警報：沒有配戴反光衣！";
			break;		
		case "VEST":
			return "(Reflective Vest Present!\n個人防護裝備：有配戴反光衣！)";
			break;	
		case "vest":
			return "(Reflective Vest Present!\n個人防護裝備：有配戴反光衣！)";
			break;				
		// case "NOT ALL HEADS WITH VEST":
		// 	return "PPE Alert: Reflective Vest Absent!\n個人防護裝備警報：沒有配戴反光衣！";
		// 	break;				
		case "no_vest":
			return "PPE Alert: Reflective Vest Absent!\n個人防護裝備警報：沒有配戴反光衣！";
			break;			
		case "SMOKE":
			return "Fire Hazard Alert! Smoke detected!\n火災警報： 檢測到煙霧！";
			break;
		case "smoke":
			return "Fire Hazard Alert! Smoke detected!\n火災警報： 檢測到煙霧！";
			break;										
		case "FIRE":
			return "Fire Hazard Alert! Fire detected!\n火災警報： 檢測到火災！";
			break;		
		case "fire":
			return "Fire Hazard Alert! Fire detected!\n火災警報： 檢測到火災！";
			break;									
		case "idle_detected":
			return "Human Condition Alert: Falling!\n人員狀況警報：静止，沒有反應！";
			break;
		case "fall_detected":
			return "Human Condition Alert: Falling!\n人員狀況警報：人員跌倒！";
			break;	
		case "intrusion":
			return "High Risk Zone Alert: Human Intrusion!\n危險區域警報：有人進入！";
			break;								
		case "floor_opening":
			return "Alert: Uncovered Floor Opening!\n警報：未蓋好的地洞！";
			break;	 
		case "periodic_recordings":
			return "Periodic recording\n定時記錄";
			break;	
		case "MASK GOOD":
			return "(Proper Face Mask\n正確戴上口罩)";
			break;			
		case "mask_good":
			return "(Proper Face Mask\n正確戴上口罩)";
			break;				
		case "mask_none":
			return "No Face Mask\n沒有戴上口罩";
			break;						
		case "MASK NONE":
			return "No Face Mask\n沒有戴上口罩";
			break;				
		case "mask_bad":
			return "Improper Face Mask\n不正確戴上口罩";
			break;									
		case "IDLE":
			return "Body condition alert: Body no movement\n身體狀況警報：身體未動";
			break;		
		case "FALL":
			return "Body condition alert: Fall Detected\n身體狀況警報：偵測到跌倒";
			break;		
		case "FALL_REPEATED":
			return "Body condition alert: Fall Detected and not recovered\n身體狀況警報：偵測到跌倒且未恢復";
			break;			
		case "unauthorized_entry":
			return "Unauthoried entry is detected according to zone\n根據區域檢測未經授權的進入";
			break;			
		default:
			
			return $detections;
			break;
	}	
}


function class_translation($detections)
{
	switch ($detections) {
		case "helmet_unknown":
			return "(Safety Helmet Detected, 有配戴安全帽）";
			break;				
		case "helmet_bad":
			return "PPE Alert: Improper Safety Helmet! \n個人防護裝備警報：安全帽配戴不當！";
			break;
		case "HELMET BAD":
			return "PPE Alert: Improper Safety Helmet! \n個人防護裝備警報：安全帽配戴不當！";
			break;			
		case "BAD":
			return "PPE Alert: Improper Safety Helmet! \n個人防護裝備警報：安全帽配戴不當！";
			break;			
		case "helmet_unknown":
			return "(Safety Helmet Detected, 有配戴安全帽）";
			break;
		case "HELMET NONE":
			return "PPE Alert: Not wearing Safety Helmet! \n個人防護裝備警報：沒有配戴安全帽！";
			break;			
		case "helmet_ok":
			return "(Safety Helmet Detected, 有配戴安全帽）";
			break;		
		case "helmet_yes":
			return "(Proper Safety Helmet, 安全帽配戴正確）";
			break;
		case "helmet_good":
			return "(Proper Safety Helmet, 安全帽配戴正確）";
			break;			
		case "HELMET GOOD":
			return "(Proper Safety Helmet, 安全帽配戴正確）";
			break;				
		case "NONE":
			return "PPE Alert: Not wearing Safety Helmet! \n個人防護裝備警報：沒有配戴安全帽！";
			break;			
		case "vest_none":
			return "PPE Alert: Reflective Vest Absent!\n個人防護裝備警報：沒有配戴反光衣！";
			break;
		case "NO VEST":
			return "PPE Alert: Reflective Vest Absent!\n個人防護裝備警報：沒有配戴反光衣！";
			break;			
		// case "NOT ALL HEADS WITH VEST":
		// 	return "PPE Alert: Reflective Vest Absent!\n個人防護裝備警報：沒有配戴反光衣！";
		// 	break;				
		case "no_vest":
			return "PPE Alert: Reflective Vest Absent!\n個人防護裝備警報：沒有配戴反光衣！";
			break;			
		case "SMOKE":
			return "Fire Hazard Alert! Smoke detected!\n火災警報： 檢測到煙霧！";
			break;
		case "smoke":
			return "Fire Hazard Alert! Smoke detected!\n火災警報： 檢測到煙霧！";
			break;										
		case "FIRE":
			return "Fire Hazard Alert! Fire detected!\n火災警報： 檢測到火災！";
			break;		
		case "fire":
			return "Fire Hazard Alert! Fire detected!\n火災警報： 檢測到火災！";
			break;									
		case "idle_detected":
			return "Human Condition Alert: Falling!\n人員狀況警報：静止，沒有反應！";
			break;
		case "fall_detected":
			return "Human Condition Alert: Falling!\n人員狀況警報：人員跌倒！";
			break;	
		case "unauthorized_entry":
			return "High Risk Zone Alert: Human Intrusion!\n危險區域警報：有人進入！";
			break;								
		case "intrusion":
			return "High Risk Zone Alert: Human Intrusion!\n危險區域警報：有人進入！";
			break;								
		case "floor_opening":
			return "Alert: Uncovered Floor Opening!\n警報：未蓋好的地洞！";
			break;	 
		case "periodic_recordings":
			return "Periodic recording\n定時記錄";
			break;	
		case "MASK GOOD":
			return "(Proper Face Mask\n正確戴上口罩)";
			break;			
		case "mask_good":
			return "(Proper Face Mask\n正確戴上口罩)";
			break;				
		case "mask_none":
			return "No Face Mask\n沒有戴上口罩";
			break;						
		case "MASK NONE":
			return "No Face Mask\n沒有戴上口罩";
			break;				
		case "mask_bad":
			return "Improper Face Mask\n不正確戴上口罩";
			break;									
		case "IDLE":
			return "Body condition alert: Body no movement\n身體狀況警報：身體未動";
			break;		
		case "FALL":
			return "Body condition alert: Fall Detected\n身體狀況警報：偵測到跌倒";
			break;		
		case "FALL_REPEATED":
			return "Body condition alert: Fall Detected and not recovered\n身體狀況警報：偵測到跌倒且未恢復";
			break;			
		default:
			return $detections;
			break;
	}	
}


function message_translations($detections)
{
	$output_array = array();

	$split_detections = explode("|", $detections);

	if ( is_array( $split_detections))
	{
		$split_detections = array_unique($split_detections);

		foreach ($split_detections as &$detection)
		{
			$detection = class_to_words($detection);			
		}

		return implode( "\n ", $split_detections);
	}
	else
	{
		return class_to_words($detections);
	}
	return class_to_words($detections);


}


function get_ip_address(){
	$ip_address_array = array();

	if ( isset($_SERVER["REMOTE_ADDR"])) {
		$ip_address_array[] = $_SERVER["REMOTE_ADDR"];
	}

	if ( isset($_SERVER["HTTP_CLIENT_IP"])) {
		$ip_address_array[] = $_SERVER["HTTP_CLIENT_IP"];
	}

	if ( isset($_SERVER["HTTP_X_FORWARDED"])) {
		$ip_address_array[] = $_SERVER["HTTP_X_FORWARDED"];
	}

	if ( isset($_SERVER["HTTP_FORWARDED_FOR"])) {
		$ip_address_array[] = $_SERVER["HTTP_FORWARDED_FOR"];
	}

	if ( isset($_SERVER["HTTP_FORWARDED"])) {
		$ip_address_array[] = $_SERVER["HTTP_FORWARDED"];
	}

	if ( isset($_SERVER["HTTP_CLIENT_IP"])) {
		$ip_address_array[] = $_SERVER["HTTP_CLIENT_IP"];
	}

	if ( isset($_SERVER["CF-Connecting-IP"])) {
		$ip_address_array[] = $_SERVER["CF-Connecting-IP"];
	}

	if ( isset($_SERVER["CF-IPCountry"])) {
		$ip_address_array[] = $_SERVER["CF-IPCountry"];
	}

	if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		if ( is_array( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
			foreach ( $_SERVER["HTTP_X_FORWARDED_FOR"] as $ip){
				$ip_address_array[] = $ip;
			}
		}else{
			$ip_address_array[] = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}

	}

	return implode ( ', ' , $ip_address_array );
}


if (!function_exists('shorten')) {
	function shorten( $str, $num = 20 ) {
		// Need to add htmlspecialchars_decode because it is added in normalDisplay()

		$counter = 0;
		$tempStr = $str;

		//Because for unrecongonizable encoding words, when browser submit, it would go in form of &#12345;
		//So we detect for such words and then count the occurance
		//After that, for each such word we add 6 character length
		while (strpos($tempStr, '&#') !== false ){
			$tempStr = substr ( $tempStr, 1, strlen($tempStr)-1);
			$counter ++;
		}
		$counter += 6;

		if ($counter != 6){
			$num = $num - $counter + ($counter * 6 );
		}

	//	echo $newStr = substr ($str, 0, $counter);

	/*
		if( strlen( $str ) > $num ) $str = substr( $str, 0, $num) . "...";
			return dhtmlspecialchars($str);
	*/


		if( mb_strlen( $str ) > $num ) $str = mb_substr( $str, 0, $num) . "...";
			return $str;

	}

}

////////////////////////////////////////////////////////
// Function:         cuttext
// Description: Cuts a string and adds ...

if (!function_exists('cuttext')) {
	function cuttext($string, $setlength)
	{
		$length = $setlength;
		if($length<mb_strlen($string)){
			while (  ($string[$length] != " ") AND ($length > 0) ) {
				$length--;
			}


			if ($length >= 1){
				if ( ($string[$length-1] == ',' ) OR ($string[$length-1] == '.' ) ) {
					$length--;
				}
			}

			if ($length == 0)
				return mb_substr($string, 0, $setlength) .'...';
			else
				return mb_substr($string, 0, $length).'...';
		}
		else return $string;
	}
}

if (!function_exists('strip_tags_content')) {
	function strip_tags_content($text, $tags = '', $invert = FALSE) {

	  preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
	  $tags = array_unique($tags[1]);

	  if(is_array($tags) AND count($tags) > 0) {
		if($invert == FALSE) {
		  return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
		}
		else {
		  return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
		}
	  }
	  elseif($invert == FALSE) {
		return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
	  }
	  return $text;
	}
}

if (!function_exists('sanitize')) {

	function sanitize($string){

		$useless_chars = array();
		$useless_chars[] = '\'';
		$useless_chars[] = ';';
		//$useless_chars[] = ',';
		$useless_chars[] = '<';
		$useless_chars[] = '>';
		$useless_chars[] = '{';
		$useless_chars[] = '}';
		$useless_chars[] = '[';
		$useless_chars[] = ']';
		//$useless_chars[] = '|';
		$useless_chars[] = '&';
		$useless_chars[] = '^';
		//$useless_chars[] = '(';
		$useless_chars[] = '*';
		//$useless_chars[] = ')';
		$useless_chars[] = '$';
		$useless_chars[] = '%';
		$useless_chars[] = '#';
		$useless_chars[] = '!';
		$useless_chars[] = '~';
		$useless_chars[] = '`';
		//$useless_chars[] = '.';
		$useless_chars[] = '+';
		//$useless_chars[] = ':';
		$useless_chars[] = '=';
		$useless_chars[] = '?';

		$useless_chars[] = '/';
		$useless_chars[] = '\\';
		$useless_chars[] = '~';
		$useless_chars[] = "\r";
		$useless_chars[] = "\n";
		$useless_chars[] = "\t";
		$useless_chars[] = '"';

		$string = trim(str_replace($useless_chars, '', $string));

		/*
		if ( !get_magic_quotes_gpc() ){
			$string = addslashes($string);
		}
		*/

		if ( strlen( $string) > 60 ){
			return substr($string, 0, 60);
		}else{
			return $string;
		}
	}
}


function send_register_email($username, $realname, $email_code, $email){

	mb_internal_encoding('UTF-8');

	include_once 'php_mailer/class.phpmailer.php';

	$subject = "香港第一車網：會員登記確認電郵 car1.hk new user account confirmation";

	$body = '您好 ' . $realname ."，<br />\r\n";


	$body .= '剩下一個步驟就可以完成 car1.hk 的註冊程序了！<br />請按下列的 URL 完成註冊程序。<br />'."<br />\r\n";


	//Please click on the following link to confirm your email

	$body .= '<a target="_blank" href="'. SITE_BASE_URL .'/register-confirm.php?hash=' .$email_code.'" />'. SITE_BASE_URL .'/register-confirm.php?hash='. $email_code. '</a><br />'."\r\n";

	$body .= '當您無法點選「啟動帳號」的連結時，您可以複製以下整段的網址到您的瀏覽器中進行帳號的啟動'."<br />\r\n";

	$body .= ''. SITE_BASE_URL .'/register-confirm.php?hash='. $email_code. "\r\n";

	$body .= '<br /><br />多謝您對 car1.hk 的支持' ."\r\n";

	
	$mail    = new PHPMailer();
	//$body    = $msg;
	$mail->IsSMTP();
	$mail->SMTPAuth   = true;
	$mail->IsHTML();
	$mail->Port = 443;                    // set the SMTP server port
	$mail->Host = "ssl://email-smtp.us-east-1.amazonaws.com"; // SMTP server
	$mail->Username   = "AKIAIEJ7F7IKLQWA37WA";     // SMTP server username
	$mail->Password   = "AufxnYrFw9zc8+JweM4cz55dhyYUlHxYHgBT2pSOvwvy";
	$mail->CharSet = 'UTF-8';
	$mail->Encoding = 'base64';
	//$mail->Encoding = 'mime';
	//$mail->Encoding = '8bit';


	$mail->SetFrom("noreply@car1.hk", "香港第一車網 car1.hk");	//The appearant email sender
	$mail->AddReplyTo("noreply@car1.hk", "香港第一車網 car1.hk");			//The real bounce back


//	$mail->AddReplyTo("apache@she.com");
	/*
	$mail->Priority = 3;
	$mail->UseMSMailHeaders = 1;
	$mail->WordWrap   = 50; // set word wrap
	*/

	//$mail->AddBCC( 'samson.li@she.com', 'handsome');
	//$mail->AddCustomHeader('Thread-Topic: '.$subject);
	//$mail->AddCustomHeader('Reply-To: noreply@car1.hk');
	//$mail->AddCustomHeader('From: `@car1.hk');
	//$mail->AddCustomHeader('Sender: noreply@car1.hk');
	//$mail->AddCustomHeader('Return-Path: noreply@car1.hk');
	//$mail->AddCustomHeader('Importance: Normal');


/*
	$mail->AddCustomHeader( 'X-Priority: 3');
	$mail->AddCustomHeader( 'X-Priority: Normal');
	$mail->AddCustomHeader( 'X-MSMail-Priority: Normal');
	$mail->AddCustomHeader( 'X-Mailer: Microsoft Outlook Express 6.00.2800.1807');
	$mail->AddCustomHeader( 'X-MimeOLE: Produced By Microsoft MimeOLE V6.00.2800.1896');
	$mail->AddCustomHeader( 'Return-Path: original-sender-samson@she.com');
	*/


	//$mail->Mailer   = "sendmail";						//Using the local sendmail

//	$mail->Host     = "mail.she.com";

/*

	$mail->Mailer   = "smtp";
	$mail->Host     = "smtpo.ctimail.com";
*/

	$mail->Subject = mb_encode_mimeheader($subject, "utf8");

	$mail->AltBody = $body; // optional, comment out and test
	$mail->IsHTML(true);
	$mail->Body = $body;


	$mail->AddAddress($email, $realname);




	if(!$mail->Send())
	 {
		echo "<script>Email Sending Failed: ".$mail->ErrorInfo ." </script>";

		$mail->Mailer   = "smtp";
		$mail->Host = "127.0.0.1";
		$mail->SMTPAuth = false;
		$mail->Port  =  25;
		$mail->Send();

		//send_email_use_gmail($realname, $email, $subject, $body);

	 }



	// Clear all addresses and attachments for next loop
	$mail->ClearAddresses();
	$mail->ClearAttachments();



}

if (!function_exists('get_url')) {
	function get_url($url){

		$header[] = "User-Agent: CarryAI ENGINE Process";
		$header[] = "Accept-Language: en-us,en;q=0.5";

		$ch = curl_init();
		//curl_setopt($ch,     CURLOPT_VERBOSE, 1); ########### debug
		//curl_setopt($ch,     CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11");
	//	curl_setopt ($ch, CURLOPT_NOPROGRESS, true);
		//curl_setopt ($ch, CURLOPT_HEADER, true);
		curl_setopt ($ch, CURLOPT_NOPROGRESS, true);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);

		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt ($ch, CURLOPT_NOSIGNAL, 1);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt ($ch, CURLOPT_MAXREDIRS, 10);

		curl_setopt ($ch, CURLOPT_HEADER, false);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt ($ch, CURLOPT_TCP_FASTOPEN, 1);
	//	curl_setopt ($ch, CURLOPT_POST, 1);
	//	curl_setopt ($ch, CURLOPT_POSTFIELDS, $login_data);

		curl_setopt ($ch, CURLOPT_URL, $url);

		$raw_response = curl_exec ($ch);
		curl_close ($ch);

		return trim($raw_response) ;
	}
}

if (!function_exists('post_data')) {
	function post_data($url,$data,$extra_header){


		foreach ($extra_header as $line)
		{
			$header[] = $line;
		}

		$ch = curl_init();
		//curl_setopt($ch,     CURLOPT_VERBOSE, 1); ########### debug
		//curl_setopt($ch,     CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11");
	//	curl_setopt ($ch, CURLOPT_NOPROGRESS, true);
		//curl_setopt ($ch, CURLOPT_HEADER, true);
		curl_setopt ($ch, CURLOPT_NOPROGRESS, true);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);

		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt ($ch, CURLOPT_NOSIGNAL, 1);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt ($ch, CURLOPT_MAXREDIRS, 10);

		curl_setopt ($ch, CURLOPT_HEADER, false);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_VERBOSE, false);
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_TCP_FASTOPEN, 1);

		//$fp = fopen(dirname(__FILE__).'/errorlog.txt', 'w');
		//curl_setopt ($ch, CURLOPT_STDERR, $fp);

		$raw_response = curl_exec ($ch);
		curl_close ($ch);

		return trim($raw_response) ;
	}
}



if (!function_exists('post_data_multipart')) {
	function post_data_multipart($url,$data,$extra_header,$filesize){


		foreach ($extra_header as $line)
		{
			$header[] = $line;
		}

		$ch = curl_init();

		curl_setopt ($ch, CURLOPT_URL, $url);
		//curl_setopt($ch,     CURLOPT_VERBOSE, 1); ########### debug
		//curl_setopt($ch,     CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11");
		curl_setopt ($ch, CURLOPT_NOPROGRESS, true);
		curl_setopt ($ch, CURLOPT_HEADER, true);
		curl_setopt ($ch, CURLOPT_NOPROGRESS, true);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt ($ch, CURLOPT_ENCODING, "");

		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt ($ch, CURLOPT_NOSIGNAL, 1);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt ($ch, CURLOPT_MAXREDIRS, 10);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 10);
		//curl_setopt ($ch, CURLOPT_INFILESIZE, $filesize);
		//curl_setopt ($ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

		//curl_setopt ($ch, CURLOPT_HEADER, false);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_VERBOSE, false);
		curl_setopt ($ch, CURLOPT_TCP_FASTOPEN, 1);
		

		//curl_setopt($ch, CURLOPT_VERBOSE, true);
		//$verbose = fopen('php://temp', 'w+');
		//curl_setopt($ch, CURLOPT_STDERR, $verbose);

	
		$raw_response = curl_exec ($ch);
		curl_close ($ch);

		//rewind($verbose);
		//$verboseLog = stream_get_contents($verbose);
		//echo "Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";

		return trim($raw_response) ;
	}
}

if (!function_exists('get_url2')) {
	function get_url2($url){

		if ( isset ( $_SERVER['HTTP_USER_AGENT'] ) )
			$header[] = "User-Agent: ". $_SERVER['HTTP_USER_AGENT'];
		else
			$header[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.10 (KHTML, like Gecko) Chrome/23.0.1262.0 Safari/537.10 AlexaToolbar/alxg-3.1";


		if ( isset ( $_SERVER['HTTP_ACCEPT'] ) )
			$header[] = "User-Accept: ". $_SERVER['HTTP_ACCEPT'];
		else
			$header[] = "User-Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";


		if ( isset ( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) )
			$header[] = "Accept-Language: ". $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		else
			$header[] = "Accept-Language: en-us,en;q=0.8";

		$ch = curl_init();
		//curl_setopt($ch,     CURLOPT_VERBOSE, 1); ########### debug
		//curl_setopt($ch,     CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11");
	//	curl_setopt ($ch, CURLOPT_NOPROGRESS, true);
		//curl_setopt ($ch, CURLOPT_HEADER, true);
		curl_setopt ($ch, CURLOPT_NOPROGRESS, true);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 40);

		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt ($ch, CURLOPT_NOSIGNAL, 1);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt ($ch, CURLOPT_MAXREDIRS, 10);

		curl_setopt ($ch, CURLOPT_HEADER, false);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, $header);
	//	curl_setopt ($ch, CURLOPT_POST, 1);
	//	curl_setopt ($ch, CURLOPT_POSTFIELDS, $login_data);
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
		curl_setopt ($ch, CURLOPT_TCP_FASTOPEN, 1);

		$raw_response = curl_exec ($ch);
		curl_close ($ch);

		return trim($raw_response) ;
	}
}


function output1px()
{
	send_no_cache_header();
	header("content-type: image/gif");
	//43byte 1x1 transparent pixel gif
	echo base64_decode('R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');
}

function send_no_cache_header() {
	header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
	header ( "Last-Modified: " . gmdate ( 'D, d M Y H:i:s' ) . " GMT" );
	header ( "Cache-Control: no-store, no-cache, must-revalidate" );
	header ( "Cache-Control: post-check=0, pre-check=0", false );
	header ( "Pragma: no-cache" );
}


function send_sms($src, $tar_mobile, $utf8_message){

	include_once 'access_you/convert_func.php';

	if ( $tar_mobile == '62288577' ) return false;
	if ( $tar_mobile == '53444693' ) return false;
	if ( $tar_mobile == '53428025' ) return false;
	if ( $tar_mobile == '66435154' ) return false;
	if ( $tar_mobile == '66431246' ) return false;
	if ( $tar_mobile == '15218489618' ) return false;
	if ( $tar_mobile == '67414728' ) return false;




	$language = 2; //for unicode

	$message = unicode_get(convert($language, $utf8_message));

	if (empty($tar_mobile) || empty($utf8_message) ){

		return 'Error: Password not correct / empty message / empty phone';
	}

	$url = "http://api.accessyou.com/sms/sendsms-senderid.php?pwd=6973&accountno=11005164&size=l&msg=" . $message. "&phone=852". $tar_mobile ."&from=" . $src;

	//echo $url;
	//die;

	$string = get_url($url);
	return $string;

}


function send_sms2($src, $tar_mobile, $message){

	$message = urlencode ( $message );

	if (empty($tar_mobile) || empty($message) ){

		return 'Error: Password not correct / empty message / empty phone';
	}

	//https://sms.hksms-pro.com/
	//https://websms1.hksmspro.com/
	$url = 'http://hktelpro.com:8080/service/smsapi1.asmx/SendMessage?Username=car1hk&Password=1a477073&Message=' . $message . '&Telephone='. $tar_mobile .'&CountryCode=852&UserDefineNo=&Sender='.$src;

	//echo $url;
	//die;

	$string = get_url($url);

/*	$string='<?xml version="1.0" encoding="utf-8"?>
<string xmlns="Able">&lt;ReturnValue&gt;
  &lt;State&gt;1&lt;/State&gt;
  &lt;Count&gt;1&lt;/Count&gt;
  &lt;ResponseID&gt;3483445&lt;/ResponseID&gt;
&lt;/ReturnValue&gt;</string>';
*/

	$string = str_replace( ' xmlns="Able"', '', $string );

	$string0 = simplexml_load_string( $string);

	$xml = simplexml_load_string( urldecode( $string0) );

	return (string) $xml->ResponseID;

}

function send_whatsapp($tar_mobile, $image_url, $image_thumb, $title, $desc=false)
{

	$success = send_whatsapp_waha_text($tar_mobile, $title . "\n".  $image_url . "\n" .  $desc, false ,4 );

	//After disscussion, jonathan perfer text based links

	//$success = send_whatsapp_waha_image($tar_mobile, $image_url, $title . "\n". $desc, 2 );

	if ($success === false )
	 	$success = send_whatsapp_waha_text($tar_mobile, $title . "\n".  $image_url . "\n" .  $desc, false ,2 );

	if ($success === false )
	 	$success = send_whatsapp_waha_text($tar_mobile, $title . "\n".  $image_url . "\n" .  $desc, false ,3 );

	if ($success === false )
	 	$success = send_whatsapp_waboxapp($tar_mobile, $image_url, $image_thumb, $title, $desc);

	return $success;

}

function send_whatsapp_waboxapp($tar_mobile, $image_url, $image_thumb, $title, $desc)
{


	//waboxapp.com
	//sending to whatsapp
	//https://www.waboxapp.com/assets/doc/waboxapp-API-v3.pdf

	$datetime = date('YmdHis') . srand( date('YmdHis') );

	$waboxapp_api_token = "1b0121f8bb9664fe6dcc2cacea811b055dadaac222533";
	$waboxapp_uid = "85268079318";
	//$waboxapp_uid = "85292157557";
	$waboxapp_to = $tar_mobile;
	$waboxapp_custom_uid = $datetime;
	$waboxapp_text = $title;
	$waboxapp_caption = date('Y-m-d H:i:s'). ': '. $title;
	$waboxapp_description = $desc;


	//Send Text
	/*
	$waboxapp_api_url = "https://www.waboxapp.com/api/send/chat";
	$send_to_waboxapp = <<<JSONMESSAGE
	{	
		"token": "{$waboxapp_api_token}", 
		"uid": "{$waboxapp_uid}",
		"to": "{$waboxapp_to}",
		"custom_uid": "{$waboxapp_custom_uid}",
		"text": "{$waboxapp_text}"
	}
	JSONMESSAGE;

	//just posting for now
	$return_data = post_data($waboxapp_api_url, $send_to_waboxapp, array("Content-Type: application/json") );
	$return_json = json_decode ($return_data );
	*/

	//generate a new uid
	$waboxapp_custom_uid = $datetime . "_" . mt_rand(10000000,99999999);

	//Send Image
	##$waboxapp_api_url = "https://www.waboxapp.com/api/send/link"; ##v2
	$waboxapp_api_url = "https://www.waboxapp.com/api/send/image"; #v3
	$send_to_waboxapp = <<<JSONMESSAGE
	{	
		"token": "{$waboxapp_api_token}", 
		"uid": "{$waboxapp_uid}",
		"to": "{$waboxapp_to}",
		"custom_uid": "{$waboxapp_custom_uid}",
		"url": "{$image_url}",
		"url_thumb": "{$image_thumb}",
		"caption" : "{$waboxapp_caption}",
		"description" : "{$waboxapp_description}"
	}
	JSONMESSAGE;
	//just posting for now
	$response = post_data($waboxapp_api_url, $send_to_waboxapp, array("Content-Type: application/json") );	
	//$return_json = json_decode ($return_data );

	//return $return_data ;


	if ( strlen( $response) > 0 )
	{
		$json_response = json_decode($response);

		if($json_response === null) 
		{
			return false;
		}

		if (isset($json_response->success ))
		{
			return true;
		}
		else
		{
			return false;
		}

		
	}
	return false;

}


function send_whatsapp_wbiztool_inline($tar_mobile, $image_url, $image_thumb, $title, $desc)
{

	$wbiztool_api = "26f5905a62ef41b6a038cf7d691c7b68f96df752";
	$wbiztool_client_id= "7294";
	$wbiztool_whatsapp_client_id = "3266"; //85268079318
	
	//$wbiztool_api_url = "https://postman-echo.com/post";
	$wbiztool_api_url = "https://wbiztool.com/api/v1/send_msg/"; #v3

	//$desc = urlencode($desc);


	$to_wbiztool = array(
		"client_id" => "{$wbiztool_client_id}", 
		"api_key" => "{$wbiztool_api}",
		"whatsapp_client" => "{$wbiztool_whatsapp_client_id}",
		"phone" => "{$tar_mobile}",
		"country_code" => "852",
		"msg" => "{$image_url}\n {$desc}",
		//"img_url" => "{$image_url}",
		"msg_type" => "0",
		
		
	);

	//print_r($to_wbiztool);
	$ch = curl_init();

	echo "<pre>";
	print_r( $to_wbiztool );
	echo "</pre>";
	

	//curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);

	curl_setopt($ch, CURLOPT_URL, $wbiztool_api_url );
	 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $to_wbiztool);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $query_str);
	
	//curl_setopt($ch, CURLOPT_VERBOSE, true);
	
	//curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, 
		CURLOPT_HTTPHEADER, 
			array(
				"Content-type:multipart/form-data"
				)
		);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TCP_FASTOPEN, 1);
	
	$response = curl_exec( $ch );
	curl_close($ch);


	// //just posting for now
	// $return_data = post_data($wbiztool_api_url, $query_str, array("Content-Type: text/html") );	
	// //$return_json = json_decode ($return_data );

	// print_r($return_data);

	return $response ;

}


function send_whatsapp_wbiztool($tar_mobile, $image_url, $image_thumb, $title, $desc)
{

	$wbiztool_api = "26f5905a62ef41b6a038cf7d691c7b68f96df752";
	$wbiztool_client_id= "7294";
	$wbiztool_whatsapp_client_id = "3266"; //85268079318
	
	//$wbiztool_api_url = "https://postman-echo.com/post";
	$wbiztool_api_url = "https://wbiztool.com/api/v1/send_msg/"; #v3

	//$desc = urlencode($desc);


	$to_wbiztool = array(
		"client_id" => "{$wbiztool_client_id}", 
		"api_key" => "{$wbiztool_api}",
		"whatsapp_client" => "{$wbiztool_whatsapp_client_id}",
		"phone" => "{$tar_mobile}",
		"country_code" => "852",
		"msg" => "{$desc}",
		"img_url" => "{$image_url}",
		"msg_type" => "1",
		
		
	);

	//print_r($to_wbiztool);
	$ch = curl_init();

	echo "<pre>";
	print_r( $to_wbiztool );
	echo "</pre>";
	

	//curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);

	curl_setopt($ch, CURLOPT_URL, $wbiztool_api_url );
	 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $to_wbiztool);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $query_str);
	
	//curl_setopt($ch, CURLOPT_VERBOSE, true);
	
	//curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, 
		CURLOPT_HTTPHEADER, 
			array(
				"Content-type:multipart/form-data"
				)
		);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TCP_FASTOPEN, 1);

	
	$response = curl_exec( $ch );
	curl_close($ch);


	// //just posting for now
	// $return_data = post_data($wbiztool_api_url, $query_str, array("Content-Type: text/html") );	
	// //$return_json = json_decode ($return_data );

	// print_r($return_data);

	return $response ;

}


function send_whatsapp_wbiztool_attach($tar_mobile, $image_url, $image_thumb, $title, $desc)
{

	$wbiztool_api = "26f5905a62ef41b6a038cf7d691c7b68f96df752";
	$wbiztool_client_id= "7294";
	$wbiztool_whatsapp_client_id = "3266"; //85268079318
	
	//$wbiztool_api_url = "https://postman-echo.com/post";
	$wbiztool_api_url = "https://wbiztool.com/api/v1/send_msg/"; #v3

	//$desc = urlencode($desc);


	$to_wbiztool = array(
		"client_id" => "{$wbiztool_client_id}", 
		"api_key" => "{$wbiztool_api}",
		"whatsapp_client" => "{$wbiztool_whatsapp_client_id}",
		"phone" => "{$tar_mobile}",
		"country_code" => "852",
		"msg" => "{$desc}",
		//"img_url" => "{$image_url}",
		"msg_type" => "1",
		
		
	);

	//print_r($to_wbiztool);
	$ch = curl_init();

	if ( is_file($image_thumb) ) 
	{
		//echo "$image_thumb is file \n\n";
		$file_path = $image_thumb;
	}
	else
	{
		return "$image_thumb is NOT FOUND! \n\n";
	}

	// if (function_exists('curl_file_create')) {
	// 	$cFile = curl_file_create('download.jpg', 'image/jpg', $file_path);
	// } else { //
	// 	$cFile = '@' . realpath($file_path);
	// }

	//$to_wbiztool['file'] = new \CurlFile($file_path);
	$to_wbiztool['file'] = new \CurlFile($file_path, 'image/jpg', 'upload.png');

	echo "<pre>";
	print_r( $to_wbiztool );
	echo "</pre>";
	

	//curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);

	curl_setopt($ch, CURLOPT_URL, $wbiztool_api_url );
	 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $to_wbiztool);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $query_str);
	
	//curl_setopt($ch, CURLOPT_VERBOSE, true);
	
	//curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, 
		CURLOPT_HTTPHEADER, 
			array(
				"Content-type:multipart/form-data"
				)
		);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TCP_FASTOPEN, 1);

	
	$response = curl_exec( $ch );
	curl_close($ch);


	// //just posting for now
	// $return_data = post_data($wbiztool_api_url, $query_str, array("Content-Type: text/html") );	
	// //$return_json = json_decode ($return_data );

	// print_r($return_data);

	return $response ;

}


function send_whatsapp_wbiztool_text($tar_mobile, $message)
{

	$wbiztool_api = "26f5905a62ef41b6a038cf7d691c7b68f96df752";
	$wbiztool_client_id= "7294";
	$wbiztool_whatsapp_client_id = "3266"; //85268079318
	
	//$wbiztool_api_url = "https://postman-echo.com/post";
	$wbiztool_api_url = "https://wbiztool.com/api/v1/send_msg/"; #v3

	//$desc = urlencode($desc);


	$to_wbiztool = array(
		"client_id" => "{$wbiztool_client_id}", 
		"api_key" => "{$wbiztool_api}",
		"whatsapp_client" => "{$wbiztool_whatsapp_client_id}",
		"phone" => "{$tar_mobile}",
		"country_code" => "852",
		"msg" => "{$message}",
		//"img_url" => "{$image_url}",
		"msg_type" => "0",
		
		
	);

	//print_r($to_wbiztool);
	$ch = curl_init();


	//curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);

	curl_setopt($ch, CURLOPT_URL, $wbiztool_api_url );
	 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $to_wbiztool);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $query_str);
	
	//curl_setopt($ch, CURLOPT_VERBOSE, true);
	
	//curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, 
		CURLOPT_HTTPHEADER, 
			array(
				"Content-type:multipart/form-data"
				)
		);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TCP_FASTOPEN, 1);

	
	$response = curl_exec( $ch );
	curl_close($ch);


	// //just posting for now
	// $return_data = post_data($wbiztool_api_url, $query_str, array("Content-Type: text/html") );	
	// //$return_json = json_decode ($return_data );

	// print_r($return_data);

	return $response ;

}




function send_whatsapp_waha_image($tar_mobile, $image_url, $title, $server=1)
{



	$waha_api_url = "https://whatsapp-api-web4.carryai.co/api/sendImage"; 

	$WAHA_API_KEY = getenv('WAHA_API_KEY');
	$WAHA_username = getenv('WAHA_username');
	$WAHA_password = getenv('WAHA_password');


	if ($server == 2)
		$waha_api_url = "https://whatsapp-api-web3.carryai.co/api/sendImage"; 


	$headers = [
		'accept: application/json',
		'X-Api-Key: '.$WAHA_API_KEY,
		'Content-Type: application/json'
	];
	

	$to_waha = array(
		"session" => "default", 
		"caption" => $title,
		"chatId" => $tar_mobile."@c.us",
		"file" =>
			array(
				"mimetype" => "image/png",
				"filename" => "logo.png",
				"url" => $image_url
		 	)
	);
		
	$ch = curl_init();

	// echo "<pre>";
	// print_r( $to_waha );
	// echo "</pre>";
	

	//curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);

	curl_setopt($ch, CURLOPT_URL, $waha_api_url );
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$WAHA_username:$WAHA_password");
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($to_waha)) ;
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
	curl_setopt($ch, CURLOPT_TCP_FASTOPEN, 1);


	$response = curl_exec( $ch );
	// Check for errors
	if(curl_errno($ch)) {
		$error_msg = curl_error($ch);
		//print_r($error_msg);
		return false;
	} else {
		$error_msg = '';
	}

	curl_close($ch);

	// print_r($return_data);

	//print_r($response);

	if ( strlen( $response) > 0 )
	{
		$json_response = json_decode($response);

		if($json_response === null) 
		{
			return false;
		}

		if (isset($json_response->key->id ))
		{
			return true;
		}
		else
		{
			return false;
		}

		
	}
	return false;

}




function send_whatsapp_waha_text($tar_mobile, $title, $url=false, $server=4)
{


	$WAHA_API_KEY = getenv('WAHA_API_KEY');
	$WAHA_username = getenv('WAHA_username');
	$WAHA_password = getenv('WAHA_password');
	
	$waha_api_url = "https://whatsapp-api-web4.carryai.co/api/sendText"; 


	if ($url != false)
		$waha_api_url = "https://whatsapp-api-web4.carryai.co/api/sendLinkPreview"; 


	if ($server == 2)
	{
		$waha_api_url = "https://whatsapp-api-web0.carryai.co/api/sendText"; 
		if ($url != false)
			$waha_api_url = "https://whatsapp-api-web0.carryai.co/api/sendLinkPreview"; 

	}

	if ($server == 3)
	{
		$waha_api_url = "https://whatsapp-api-web3.carryai.co/api/sendText"; 
		if ($url != false)
			$waha_api_url = "https://whatsapp-api-web3.carryai.co/api/sendLinkPreview"; 

	}

	$headers = [
		'accept: application/json',
		'X-Api-Key: '. $WAHA_API_KEY,
		'Content-Type: application/json'
	];
	

	$to_waha = array(
		"chatId" => $tar_mobile."@c.us",
		"text" => $title,
		"session" => "default"
	);

	if ($url != false)
	{
		$to_waha = array(
			"chatId" => $tar_mobile."@c.us",
			"url" => $url,
			"text" => $title,
			"session" => "default"
		);
	}	
		
	$ch = curl_init();

	// echo "<pre>";
	// print_r( $to_waha );
	// echo "</pre>";
	

	//curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
	curl_setopt($ch, CURLOPT_NOPROGRESS, true);

	curl_setopt($ch, CURLOPT_URL, $waha_api_url );
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$WAHA_username:$WAHA_password");
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($to_waha)) ;
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
	curl_setopt($ch, CURLOPT_TCP_FASTOPEN, 1);	
	curl_setopt($ch, CURLOPT_ENCODING, '');


	$response = curl_exec( $ch );
	// Check for errors
	if(curl_errno($ch)) {
		$error_msg = curl_error($ch);
		//print_r($error_msg);
		return false;
	} else {
		$error_msg = '';
	}

	curl_close($ch);

	//print_r($response);

	//Write a lot of text
	//safe_log( "debug.txt",  date('Y-m-d H:i:s'). " " . " WHATSAPP_RETURN: " . $response . "\n", FILE_APPEND );

	//return trim($response) ;

	if ( strlen( $response) > 0 )
	{
		$json_response = json_decode($response);

		//print_r($json_response);
		echo "********";

		if($json_response === null) 
		{

			
			return false;
		}

		if (isset($json_response->id ) || isset($json_response->key->id ))
		{
			//print ("return true");
			return true;
		}
		else
		{
			//print ("return false");
			return false;
		}

		
	}
	
	return false;

}





function send_vhsoft_cmp_datahub($data, $server="")
{


	//$url = "https://datahub.harvonet.com/kafka/v3/clusters/pwxAfJ4_SVWlv5jvE3opQA/topics/DEVSMAI/records";

	$url = "https://datahub.harvonet.com/kafka/v3/clusters/pwxAfJ4_SVWlv5jvE3opQA/topics/PRODSMAI/records";

	// if ($server == "prod")
	// {
		
	// }


	$username = "RGT";
	$password = "0FAqVN2s";

	$headers = [
		'accept: application/json',
		'Content-Type: application/json'
	];
	
		
	$ch = curl_init();

	// echo "<pre>";
	// print_r( $to_waha );
	// echo "</pre>";
	

	//curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
	curl_setopt($ch, CURLOPT_NOPROGRESS, true);

	curl_setopt($ch, CURLOPT_URL, $url );
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)) ;
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
	curl_setopt($ch, CURLOPT_TCP_FASTOPEN, 1);	
	curl_setopt($ch, CURLOPT_ENCODING, '');


	$response = curl_exec( $ch );
	// Check for errors
	if(curl_errno($ch)) {
		$error_msg = curl_error($ch);
		//print_r($error_msg);
		return false;
	} else {
		$error_msg = '';
	}

	curl_close($ch);

	if (isset($debug))
	{
		$response_array=json_decode($response);
		echo json_encode( $response_array, JSON_PRETTY_PRINT);
	}


	//Write a lot of text
	//safe_log( "debug.txt",  date('Y-m-d H:i:s'). " " . " WHATSAPP_RETURN: " . $response . "\n", FILE_APPEND );


	return trim($response) ;

}


function send_ifttt($image_url, $image_thumb, $title)
{

	/////////////////////////////////////////////////////////////////////////////////////////////
	//ifttt

	//curl -X POST -H "Content-Type: application/json" -d '{"value1":"he","value2":"12","value3":"345"}' https://maker.ifttt.com/trigger/{event}/with/key/cERWIGoBsbb5h9j_6pwOF-


	$ifttt_service_key = "_6XBtFUhjIb_yoOHCnFvd_hTi8TuqhkdgwzPZbEyurKHNkuvFiLgx6Bj1k0BY7NR";
	$ifttt_webhook = "https://maker.ifttt.com/trigger/detection/with/key/cERWIGoBsbb5h9j_6pwOF-";
	//$ifttt_webhook = "https://maker.ifttt.com/use/cERWIGoBsbb5h9j_6pwOF-";
	//$ifttt_webhook = "https://maker.ifttt.com/use/dRtSjOCOvtvDeaLPnS-Tuu";

	//shortened_link
	//thumbnailUrl

	$detected_object = isset($_POST['detected_object']) ? trim($_POST['detected_object']) : "UNKNOWN";

	$send_to_ifttt = <<<JSONMESSAGE
	{	
		"value2": "{$title}", 
		"value1": "{$image_url}",
		"value3": "{$image_thumb}"
	}
	JSONMESSAGE;

	//just not posting for now
	$return_data = post_data($ifttt_webhook, $send_to_ifttt, array("Content-Type: application/json") );

	return $return_data ;
}


function enlarge_coords(&$polygon_array)
{
	for ( $i=0 ; $i< count ($polygon_array); $i++ )
	{
		$polygon_array[$i][0] = intval( $polygon_array[$i][0] * 1920 );
		$polygon_array[$i][1] = intval( $polygon_array[$i][1] * 1080 );

	}
}

function is_point_in_polygon($polygon, $x, $y) {
	$num_vertices = count($polygon);
	$inside = false;

	for ($i = 0, $j = $num_vertices - 1; $i < $num_vertices; $j = $i++) {
		if (((($polygon[$i][1] <= $y) && ($y < $polygon[$j][1])) || 
			(($polygon[$j][1] <= $y) && ($y < $polygon[$i][1]))) && 
			($x < ($polygon[$j][0] - $polygon[$i][0]) * ($y - $polygon[$i][1]) / 
			($polygon[$j][1] - $polygon[$i][1]) + $polygon[$i][0])) {
		$inside = !$inside;
		}
	}

	return $inside;
}




function filter_bboxes_by_detections( $detection_classes, $detection_array)
{
	//print_r($detection_classes);

	$detection_classes = array_unique($detection_classes);
	
	$bboxes = $detection_array['boxes'];
	$classes = $detection_array['class'];
	$colors = $detection_array['colors'];
	$confs = $detection_array['confs'];

	
	$new_filtered_bboxes = array();

	foreach ($detection_classes as $class_name)
	{
		$found_keys = array_keys( $classes, $class_name );
		foreach ( $found_keys as $key)
		{
			$new_filtered_bboxes['boxes'][] = $bboxes[$key];
			$new_filtered_bboxes['class'][] = $classes[$key];
			$new_filtered_bboxes['colors'][] = $colors[$key];
			$new_filtered_bboxes['confs'][] = $confs[$key];
		}
	}

	return $new_filtered_bboxes;
}

//the bbox is the bounding box using in opencv
function is_bbox_in_polygon($polygon, $bboxes)
{
	$is_inside_any = false;

	foreach ($bboxes as $box)
	{
		$is_inside_top_left = is_point_in_polygon($polygon, $box[0], $box[1]);
		$is_inside_top_right = is_point_in_polygon($polygon, $box[2], $box[1]);
		$is_inside_bottom_left = is_point_in_polygon($polygon, $box[0], $box[3]);
		$is_inside_bottom_right = is_point_in_polygon($polygon, $box[2], $box[3]);

		//if any point of the 4 corners are inside the polygon, then it will return true

		$is_inside_any = $is_inside_any || $is_inside_top_left || $is_inside_top_right || $is_inside_bottom_left || $is_inside_bottom_right;
	}
	return $is_inside_any;

	
}


//the bbox is the bounding box using in opencv
function filter_detections_by_polygon($polygon, $detections)
{
	$is_inside_any = false;
	$new_filtered_detections = array();

	$bboxes = $detections['boxes'];

	for ($i=0; $i<count($bboxes); $i++)  
	{
		$box = $bboxes[$i];
		$is_inside_top_left = is_point_in_polygon($polygon, $box[0], $box[1]);
		$is_inside_top_right = is_point_in_polygon($polygon, $box[2], $box[1]);
		$is_inside_bottom_left = is_point_in_polygon($polygon, $box[0], $box[3]);
		$is_inside_bottom_right = is_point_in_polygon($polygon, $box[2], $box[3]);

		//if any point of the 4 corners are inside the polygon, then it will return true

		$is_inside_any = $is_inside_any || $is_inside_top_left || $is_inside_top_right || $is_inside_bottom_left || $is_inside_bottom_right;

		if ($is_inside_any)
		{
			$new_filtered_detections['boxes'][] = $detections['boxes'][$i];
			$new_filtered_detections['class'][] = $detections['class'][$i];
			$new_filtered_detections['colors'][] = $detections['colors'][$i];
			$new_filtered_detections['confs'][] = $detections['confs'][$i];			
		}
	}
	
	return $new_filtered_detections;
	
}

function send_rec_gt_api($image_file, $filename,$filesize)
{
	$api_url = "https://aiotrak.rec-gt.com/api/application-api/upload-image/default_application/868474041801646";

	/*
	//Doesn't work
	$api_post_data = array(
		"logo" => "@$image_file", 
		"filename" => $filename)
	;
	*/

	$api_post_data = array('logo'=> new CURLFILE($image_file) );

	$return_data = post_data_multipart(
		$api_url, 
		$api_post_data, 
		array(
			"Content-Type: multipart/form-data",
//			'application/octet-stream',
			'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJhZG1pbiIsIm5hbWUiOiJBZG1pbmlzdHJhdG9yIiwiZ3JvdXAiOjIsInBlcm1pc3Npb25zIjpbXSwibGluZSI6IkFMTCIsImlhdCI6MTYyNjc1MjkzOCwiZXhwIjoxOTM3NzkyOTM4LCJpc3MiOiJBQ0NFU1MifQ.EV9I8oWaZAhi2TaOUaR5kSSTGMsjNqNtl5k18C0PIA4',
			"Content-Type: application/json"
		),
		$filesize
	);

	//echo $return_data;

	return $return_data;
}

function check_zoning($serial_no, $detection_array)
{
	$debug_messages = array();
	$extra_messages = array();

	// Path to the zoning defination file
	$zoning_file_path = "../../zoning.json";
	if (!is_file($zoning_file_path))
		$zoning_file_path = "zoning.json";
	// Load the contents of the file into a variable
	$zoning_file_contents = file_get_contents($zoning_file_path);
	// Decode the JSON string into a PHP object
	$global_zone_data = json_decode($zoning_file_contents, true);

	$global_zone_data_serial_no = array_column($global_zone_data, 'serial_no');
	//print_r($array_serial_no);
	$found_serial_no_from_zone_json = array_search($serial_no, $global_zone_data_serial_no);


	$need_to_send_alert = false;

	// Check if the serial_no exists in the array
	if ( $found_serial_no_from_zone_json !== false) 
	{
		//$zone_arrays = array_column($global_zone_data[$found_serial_no_from_zone_json]['zones'], 'points');
		//$found_zone = array_search('points', $points);

		$zone_arrays = $global_zone_data[$found_serial_no_from_zone_json]['zones'];

		if (count($zone_arrays) == 0 )
		{
			$debug_messages[] = "NO zones for this serial number [" . $serial_no ."], just send any detections.";
			$need_to_send_alert = true;
		}

		foreach ($zone_arrays as &$this_zone)
		{

			$pattern = '/^(require_)(.*)(_helmet)(.*)|^(no_person)(.*)$/';

			// if (preg_match($pattern, $this_zone['name'], $matches, PREG_OFFSET_CAPTURE)) {
			//     echo $this_zone['name'] . ' ::  Match found!';
			//     print_r($matches);
			// } else {
			//     echo $this_zone['name'] . ' ::  No match found.';
			// }      
			
			preg_match_all($pattern, $this_zone['name'], $matches, PREG_SET_ORDER);

			//print_r($matches);

			//print_r($this_zone['points']);

			enlarge_coords($this_zone['points']);



			if ( count ($matches) == 0)
			{
				$debug_messages[] = "Checking ANY Detections";
				//Not matched, using normal criterias, etc,  "happy", "a", "b", "c"
				
				$bboxes = $detection_array['boxes'];

				$detections_is_inside_zone = is_bbox_in_polygon($this_zone['points'], $bboxes);  
				
				if ( $detections_is_inside_zone )
				{
					$debug_messages[] = "ANY Detections FOUND in this zone: " . $this_zone['name'];
					$need_to_send_alert = true;
				}
				else
				{
					$debug_messages[] = "NONE Detections NOT found in this zone: " . $this_zone['name'];
				}
				
			}else        
			{
				//Special Treatments

				
				//require_*_helmet* //not finished  
				$debug_messages[] = "Checking for require_*_helmet*";

				if ($matches[0][1] == "require_" && $matches[0][3] == "_helmet" )
				{
					$debug_messages[] = "REQUIRED HELMET Color:: [" . $matches[0][2]. "] for zone: " .$this_zone['name'] ;

					//test for helmet_none
					$filtered_detection_array = filter_bboxes_by_detections( array( "helmet_none","NONE" ) , $detection_array );                    

					if ( sizeof ($filtered_detection_array ) > 0)
					{
						$debug_messages[] = "UNHELMETED detected in zone:: [".  $this_zone['name'] ."]";
						$debug_messages[] = "Need to send alert" ;
						$debug_messages[] = "Skipping detection of helmets in zone because people with no helmet is detected" ;
						$extra_messages[] = "unauthorized_entry";

						$need_to_send_alert = true;						
					}

					//test for helmet_unknown, helmet_yes, helmet_ok,

						//print_r($detection_array);

					//Skipped checking with helmet if people without helmet is detected
					if (!$need_to_send_alert)
					{

						$filtered_detection_array = filter_bboxes_by_detections( array("helmet_unknown","helmet_yes","helmet_ok","helmet_bad","BAD", "helmet_good","GOOD" ) , $detection_array );                    

						if ( sizeof ($filtered_detection_array ) > 0)
						{

							$filter_detections = filter_detections_by_polygon($this_zone['points'],$detection_array );
							


							//print_r($filter_detections);

							//$detections_is_inside_zone = is_bbox_in_polygon($this_zone['points'], $filtered_bboxes);  
						
							//echo $this_zone['name'] . var_dump($detections_is_inside_zone) . " :: OKOK\r\n";
							if (count($filter_detections)==0)
							{
								$debug_messages[] = "No helmet found in this zone: ".  $this_zone['name'] ;
							}
							else
							{

								$non_matching_color_found = 0;


								for ($j=0; $j<count($filter_detections['colors']); $j++)
								{

									//Skip if N/A
									if ( $filter_detections['colors'][$j] == "N/A" )
										continue;
									
									//echo strtoupper($filter_detections['colors'][$j]) . ":" . strtoupper($matches[0][2]);

									if ( strtoupper($filter_detections['colors'][$j]) !== strtoupper($matches[0][2]) )
									{
										$non_matching_color_found++;
									}
								}

								if ($non_matching_color_found >0 )
								{
									$debug_messages[] = "Non [" . $matches[0][2] . "] helmet FOUND in this zone: ".  $this_zone['name'] ;
									$debug_messages[] = "Need to send alert" ;
									$extra_messages[] = "unauthorized_entry";
									$need_to_send_alert = true;
								}else
								{
									$debug_messages[] = "Non [" . $matches[0][2] . "] helmet NOT FOUND in this zone: ".  $this_zone['name'] ;
									$debug_messages[] = "No need to send alert";
								}
							}

						}

					}
				} 


				if (isset($matches[0][5]))
				{
					$debug_messages[] = "Checking for no_person";
					if ( strtolower($matches[0][5]) == "no_person")
					{
						//test for helmet_none, helmet_unknown, helmet_yes, helmet_ok, helmet_bad

						$filtered_detection_array = filter_bboxes_by_detections( array("helmet_unknown","helmet_none","helmet_yes","helmet_ok","helmet_bad","helmet_good","GOOD", "NONE","BAD") , $detection_array );

						if ( sizeof ($filtered_detection_array ) > 0)
						{

							$filtered_bboxes = $filtered_detection_array['boxes'];

							//print_r($filtered_bboxes);

							$detections_is_inside_zone = is_bbox_in_polygon($this_zone['points'], $filtered_bboxes);  
													
							if ($detections_is_inside_zone)
							{
								$debug_messages[] = "People found in this zone: ".  $this_zone['name'] ;
								$debug_messages[] = "Need to send alert" ;
								$extra_messages[] = "unauthorized_entry";
								$need_to_send_alert = true;
							}
							else
							{
								$debug_messages[] = "No People found in this zone: ".  $this_zone['name'];
								$debug_messages[] = "NO need to send alert";                            
							}
												
							//works, needs to ensure all uploaded images are 1920x1080
						}
					}
				}


			}


		}
	}
	else
	{

		$need_to_send_alert = true;
		$debug_messages[] = "No such SERIAL No :[" . $serial_no ."] found for zones"; 
	}

	return array($need_to_send_alert,  $debug_messages, $extra_messages);
}

/** 
 * Get hearder Authorization
 * */
function getAuthorizationHeader(){
	$headers = null;
	if (isset($_SERVER['Authorization'])) {
		$headers = trim($_SERVER["Authorization"]);
	}
	else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
		$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
	} elseif (function_exists('apache_request_headers')) {
		$requestHeaders = apache_request_headers();
		// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
		$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
		//print_r($requestHeaders);
		if (isset($requestHeaders['Authorization'])) {
			$headers = trim($requestHeaders['Authorization']);
		}
	}
	return $headers;
}
/**
* get access token from header
* */
function getBearerToken() {
	$headers = getAuthorizationHeader();
	// HEADER: Get the access token from the header
	if (!empty($headers)) {
		if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
			return $matches[1];
		}
	}
	return null;
}

function create_datetime_png($filename)
{
	// Create a new image
	$image = imagecreate(400, 80);

	// Set background color to white
	$bg_color = imagecolorallocate($image, 255, 255, 255);

	// Set text color to black
	$text_color = imagecolorallocate($image, 0, 0, 0);

	// Get current date and time
	$date_time = date('Y-m-d H:i:s');

	// Add text to the image
	$font_size = 18;
	$font_path = './OpenSans-Regular.ttf'; // Path to TrueType font file
	imagettftext($image, $font_size, 0, 10, 50, $text_color, $font_path, $date_time);

	// Save the image as PNG
	imagepng($image, $filename);

	// Free up memory
	imagedestroy($image);
}

function random_color_part() {
	return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
	return "#" . strtoupper( random_color_part() . random_color_part() . random_color_part() );
}


function draw_bbox($source_image, $output_image, $inference_json)
{
	global $debug;

	//If numerical number, might be wrong
	$class_def = array(
		0 => "HELMET_OK",
		1 => "HELMET_YES",
		2 => "HELMET_NONE" ,
		3 => "VEST",
		4 => "HELMET_GOOD" ,
	);

	//1 ->bad, 2->good, 3-> none (because of php sorting), 4->vest
	$inference_colors = array();
	$inference_colors['bad'] = array( 'Orange', 'tomato' );   
	$inference_colors['HELMET_OK'] = array( 'Orange', 'tomato' );
	$inference_colors[0] = array( 'Orange', 'tomato' );
	$inference_colors['good'] = array( 'SeaGreen', 'PaleGreen' );   
	$inference_colors['HELMET_YES'] = array( 'SeaGreen', 'PaleGreen' );     
	$inference_colors[1] = array( 'SeaGreen', 'PaleGreen' );     
	$inference_colors['none'] = array( 'Sienna', 'Red' );
	$inference_colors['NONE'] = array( 'Sienna', 'Red' );
	$inference_colors['helmet_none'] = array( 'Sienna', 'Red' );
	$inference_colors['HELMET_NONE'] = array( 'Sienna', 'Red' );	
	$inference_colors[2] = array( 'Sienna', 'Red' );
	$inference_colors['vest'] = array( 'Blue', 'DodgerBlue' );
	$inference_colors['VEST'] = array( 'Blue', 'DodgerBlue' );
	$inference_colors[3] = array( 'Blue', 'DodgerBlue' );
	$inference_colors['HELMET_GOOD'] = array( 'SeaGreen', 'PaleGreen' );     
	$inference_colors[1] = array( 'SeaGreen', 'PaleGreen' );  	
	$inference_colors[4] = array( 'Purple', 'Violet' );
	$inference_colors[] = array( 'Tomato', 'Gold' );
	$inference_colors[] = array( 'Orange', 'LemonChiffon' );
	   

	//decode the json into array
	if ( strlen($inference_json) > 1 )
	{
		$inference_obj = json_decode($inference_json, true);
	}
	else
	{
		$inference_obj = array(
			'class' => array(),
			'confs' => array(),
			'boxes' => array(),
			'colors' => array()
		);
	}   

	// if ( isset ( $debug ))
	// 	if ( $debug)
	// 		var_dump ($inference_obj);

	//If the class contains the words instead of the index

	if ( isset(  $inference_obj['class'][0] ) )

		//This means the index is based on number class = [1.0, 2.0]
		if ( is_float( $inference_obj['class'][0] ) )
		{

			//insert the color as well as the name into the array for easy reference
			for ($i=0; $i<count($inference_obj['class']); $i++)
			{
				//echo "%". intval( $inference_obj['class'][$i]  ) ;
				if ( isset( $class_def[ intval( $inference_obj['class'][$i] )] ) )
				{	
					if ( isset ( $debug ))
						if ( $debug)
							echo "*". $class_def[ intval( $inference_obj['class'][$i] )] ;

					$inference_obj['class'][$i] = $class_def[ intval( $inference_obj['class'][$i] ) ];
				}

				
			}
			
		}

		// echo "-------";
		// if ( isset ( $debug ))
		// 	if ( $debug)
		// 		var_dump ($inference_obj);

		$unique_class_names = array_unique($inference_obj['class']);

		// if ( isset ( $debug ))
		// 	if ( $debug)
		// 		var_dump ($unique_class_names);
				
		$inference_colors_by_name = array();

		$i=0;
		foreach ( $unique_class_names as $class_name => $val)
		{
			// if ( isset ( $debug ))
			// 	if ( $debug)
			// 		echo "class_name: ".$class_name;

			if ( isset ( $inference_colors[$val] ))
			{
				$inference_colors_by_name[$val] = $inference_colors[$val];
			}
			else
			{
				$inference_colors_by_name[$val] = array( "'".random_color()."'", "'".random_color()."'" );	
			}
			
			$i++;
		}

		// if ( isset ( $debug ))
		// 	if ( $debug)
		// 	{
		// 		echo '$unique_class_names: ';
		// 		var_dump ( $unique_class_names);			
		// 	}


		// if ( isset ( $debug ))
		// 	if ( $debug){
		// 		echo '$inference_colors_by_name: ';
		// 		var_dump ($inference_colors_by_name);
		// 	}

		//insert the color as well as the name into the array for easy reference
		for ($i=0; $i<count($inference_obj['class']); $i++)
		{

			$inference_obj['class'][$i] = array (            
				$inference_obj['class'][$i],
				$inference_colors_by_name[$inference_obj['class'][$i]][0] 
			);

			//print_r($inference_obj['class'][$i]);
		}

	





	//Generate the code to draw reoundrectangle and color
	$imagemagick_box_cmd = array();
	for ($i=0; $i<count($inference_obj['boxes']); $i++)
	{
		//print_r( $inference_obj['class'][$i] );

		$imagemagick_box_cmd[] = "-stroke ".$inference_obj['class'][$i][1]. " -draw \" roundRectangle " .$inference_obj['boxes'][$i][0] . ", " . $inference_obj['boxes'][$i][1] . ", " . $inference_obj['boxes'][$i][2] . ", " . $inference_obj['boxes'][$i][3] . ", 5, 5 \""; 
	}
	$final_imagemagick_box_cmd = implode(" \\\n \t", $imagemagick_box_cmd );


	//generate the code to draw the text and class names
	$imagemagick_text_cmd = array();
	for ($i=0; $i<count($inference_obj['boxes']); $i++)
	{
		if ($inference_obj['colors'][$i] == "N/A" || $inference_obj['colors'][$i] == "" )
			$this_color = "";
		else
			$this_color = "(" .$inference_obj['colors'][$i] . ")";
	
			//Original with % sign
			//$imagemagick_text_cmd[] = "text ". $inference_obj['boxes'][$i][0] . ", " . $inference_obj['boxes'][$i][1] . " '" . $inference_obj['class'][$i][0] . " (". $this_color . intval($inference_obj['confs'][$i]*100) . "%)'"; 

		$imagemagick_text_cmd[] = "text ". $inference_obj['boxes'][$i][0] . ", " . $inference_obj['boxes'][$i][1] . " '" . $inference_obj['class'][$i][0] . $this_color . "' " ; 
	}
	$final_imagemagick_text_cmd = implode(" \\\n \t", $imagemagick_text_cmd );


	if ($output_image == "" || $output_image == $source_image )
		$output_image = str_replace('.jpg', '.png', $source_image);

	//$output_image = "out.png";

	$imagemagick_cmd=<<<HEREDOC
	/usr/bin/gm convert "{$source_image}" \
		-stroke green \
		-strokewidth 3 \
		-fill none \
		{$final_imagemagick_box_cmd} \
		-density 90 -font Gecko -pointsize 24 \
		-stroke '#000A' -strokewidth 8  \
		-draw " \
		{$final_imagemagick_text_cmd} " \
		-stroke none -fill white  \
		-draw " \
		{$final_imagemagick_text_cmd} " \
		"{$output_image}"
	HEREDOC;

	if ( isset ( $debug ))
		if ( $debug)
			echo $imagemagick_cmd . "\n\n";

	//Needed, otherwise cannot be executed
	$imagemagick_cmd = str_replace("\r", "", $imagemagick_cmd);

	file_put_contents("to_generate_images.txt", $imagemagick_cmd . "\n\n" , FILE_APPEND | LOCK_EX);

	//echo shell_exec('whoami');

	if ( is_file($source_image))
	{
		if ( !is_file($output_image) )
		{
			$return_output = shell_exec(
				$imagemagick_cmd);
	
		}
		//return $return_output;
	}
	else{
		echo $source_image. ' : NOT FOUND ! ';
	}
	return $output_image;
}

//by chatgpt
function pointInPolygon($point, $polygon) {
	$verticesX = array_column($polygon, '0');
	$verticesY = array_column($polygon, '1');
	$pointsCount = count($verticesX);
	$i = $j = $c = 0;

	for ($i = 0, $j = $pointsCount - 1; $i < $pointsCount; $j = $i++) {
		if (((($verticesY[$i] > $point[1]) != ($verticesY[$j] > $point[1])) &&
			($point[0] < ($verticesX[$j] - $verticesX[$i]) * ($point[1] - $verticesY[$i]) / ($verticesY[$j] - $verticesY[$i]) + $verticesX[$i]))) {
			$c = !$c;
		}
	}

	return $c;
}

function check_zones($inference_json, $source_image, $serial_no)
{
	global $debug;
	$width = 0;
	$height = 0;

	$imagemagick_cmd=<<<HEREDOC
		/usr/bin/gm -identify -format "%w:%h" "{$source_image}"
	HEREDOC;

	//get image dimensions
	if ( is_file($source_image))
	{
	
		$return_output = shell_exec(
			$imagemagick_cmd);

		//return $return_output;

		list( $width, $height) = explode(":", $return_output);
	}
	else{
		echo $source_image. ' : NOT FOUND ! ';
	}

	// if ( isset ( $debug ))
	// 	if ( $debug)
	// 	{
	// 		echo $imagemagick_cmd . "\n\n";
	// 		echo $width . " :: " . $height . "\n\n";
	// 		echo $return_output;
	// 	}


	//decode the json into array
	if ( strlen($inference_json) > 1 )
	{
		$inference_obj = json_decode($inference_json, true);
	}
	else
	{
		$inference_obj = array(
			'class' => array(),
			'confs' => array(),
			'boxes' => array(),
			'colors' => array()
		);
	}   

	// if ( isset ( $debug ))
	// 	if ( $debug)
	// 		var_dump ($inference_obj);

	for ($i=0; $i<count($inference_obj['boxes']); $i++)
	{
		//print_r( $inference_obj['class'][$i] );

		//$imagemagick_box_cmd[] = "-stroke ".$inference_obj['class'][$i][1]. " -draw \" roundRectangle " .$inference_obj['boxes'][$i][0] . ", " . $inference_obj['boxes'][$i][1] . ", " . $inference_obj['boxes'][$i][2] . ", " . $inference_obj['boxes'][$i][3] . ", 5, 5 \""; 
	}
}

$is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');

$is_cloudflare_https = (!empty($_SERVER['HTTP_CF_VISITOR']) && $_SERVER['HTTP_CF_VISITOR'] == '{"scheme":"https"}');


function safe_log($file, $message) {
    $fp = fopen($file, 'a');
    if ($fp) {
        if (flock($fp, LOCK_EX)) { // Acquire an exclusive lock
            fwrite($fp, $message . PHP_EOL);
            fflush($fp); // Flush output before releasing the lock
            flock($fp, LOCK_UN); // Release the lock
        }
        fclose($fp);
    } else {
        // Handle error opening the file
        error_log("Could not open log file: $file");
    }
}

?>