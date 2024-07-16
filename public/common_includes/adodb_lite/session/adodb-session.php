<?php
/*

if suhosin is used, the session and cookie data is encrypted
pls
goto php.ini and add

[suhosin]
suhosin.session.encrypt = off
suhosin.cookie.encrypt = off


CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `username` varchar(127) default NULL,

  `persist_id` varchar(127) default NULL,
  `session_id` varchar(127) NOT NULL,

  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime NOT NULL,
  `expire_datetime` datetime NOT NULL,


  `auto_login` tinyint(1) NOT NULL default '0',
  `session_data` text,
  `is_admin` tinyint(1) NOT NULL default '0',
  `ip_address` varchar(64) default NULL,
  `browser` varchar(256) default NULL,
  `request_url` varchar(256) default NULL,
  `request_server` varchar(128) default NULL,
  `request_hostname` varchar(64) default NULL,
  `request_details` varchar(512) default NULL,

  PRIMARY KEY  (`id`),
  KEY `session_id` (`session_id`),
  KEY `persist_id` (`persist_id`),
  KEY `user_id` (`user_id`),
  KEY `expire_datetime` (`expire_datetime`)

) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

*/

if (!defined('_ADODB_LAYER')) {
	require_once realpath(dirname(__FILE__) . '/../adodb.inc.php');
}

if (defined('ADODB_SESSION')) return 1;

define('ADODB_SESSION', dirname(__FILE__));

class ADODB_Session {


	var $session_data = array();	//This is a redundant variable, storing the current session data, it will be used for comparing it the update data is the same then no update is needed.

/*
	var $auto_login = false;
	var $user_id = false;
	var $username = false;
	var $session_id = false;
	var $persist_id = false;
	var $is_admin = false;
	var $create_datetime = false;
	var $update_datetime = false;
	var $expire_datetime = false;
*/

	public static function create_log($string){
		global $SESSION_ACTION_LOGGING;
		global $SESSION_ACTION_LOGGING_FILE;
		if ($SESSION_ACTION_LOGGING !== false){
			file_put_contents($SESSION_ACTION_LOGGING_FILE,  date('Y-m-d H:i:s') . " " . $string."\n\n", FILE_APPEND);
		}
	}


	public static function ip_address(){
		$ip = array();
		//check ip from share internet
		if (!empty($_SERVER['HTTP_CLIENT_IP']))	{
			$ip[] = $_SERVER['HTTP_CLIENT_IP'];
		}
		//to check ip is pass from proxy
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip[] = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		if (!empty($_SERVER['REMOTE_ADDR'])){
			$ip[] = $_SERVER['REMOTE_ADDR'];
		}

		return implode('|',$ip);
	}

	public static function browser_detection(){
		$browser = (!empty($_SERVER['HTTP_USER_AGENT'])) ? htmlspecialchars((string) $_SERVER['HTTP_USER_AGENT']) : '' ;
		return $browser;
	}

	public static function request_url(){
		$request_url = (!empty($_SERVER['REQUEST_URI'])) ? htmlspecialchars((string) $_SERVER['REQUEST_URI']) : '' ;

		return substr($request_url, 0, 255);
	}

	public static function server_hostname(){
		$request_hostname = (!empty($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : '' ;
		return $request_hostname;
	}

	public static function server_host(){
		$request_server = (!empty($_SERVER['SERVER_ADDR'])) ? $_SERVER['SERVER_ADDR'] : '' ;
		return $request_server;
	}

	public static function request_details(){
		//$request_details = serialize ( $_POST );
		$request_details = serialize ( $_COOKIE );
		/* //no more used in php 5.3
		if ( !get_magic_quotes_gpc() ){
			$request_details = addslashes($request_details);
		}
		*/

		return $request_details;

	}

	public static function new_session_id(){
		return md5(rand(100,50000) . 's' . time());
	}


	public static function sess_open($sess_path, $sess_name, $persist = null) {

		$database	= $GLOBALS['ADODB_SESSION_DB'];
		$driver		= $GLOBALS['ADODB_SESSION_DRIVER'];
		$host		= $GLOBALS['ADODB_SESSION_CONNECT'];
		$password	= $GLOBALS['ADODB_SESSION_PWD'];
		$user		= $GLOBALS['ADODB_SESSION_USER'];
//		$table		= 'session';
		$GLOBALS['ADODB_SESSION_TBL'] = 'session';

/*		$cookie_domain = 'car1.hk';*/



//		$GLOBALS['ADODB_SESSION_TBL'] = (!empty($GLOBALS['ADODB_SESSION_TBL'])) ? $GLOBALS['ADODB_SESSION_TBL'] : 'sessions';

		$db_object =& ADONewConnection($driver);

		if ($persist) {
			switch($persist) {
			default:
			case 'P': $result = $db_object->PConnect($host, $user, $password, $database); break;
			case 'C': $result = $db_object->Connect($host, $user, $password, $database); break;
			case 'N': $result = $db_object->NConnect($host, $user, $password, $database); break;
			}
		} else {
			$result = $db_object->Connect($host, $user, $password, $database);
		}

		if ($result == true)
			$GLOBALS['ADODB_SESS_CONN'] =& $db_object;

		return $result;
	}

	public static function sess_close() {

		ADODB_Session::create_log('Calling sess_close ------------'."\r\n");
		return true;
	}

	public static function sess_read($sess_id) {
		global $SESSION_DEFAULT_EXPIRE_TIME;
		global $SESSION_TIME_FOR_EXTENDING_SESSION;
		global $session_data;
		global $SESSION_LOG_LEVEL;

		ADODB_Session::create_log('Calling sess_read('.$sess_id.')');

		$db_object =& $GLOBALS['ADODB_SESS_CONN'];
		$table = $GLOBALS['ADODB_SESSION_TBL'];

		if ( trim($sess_id) != '') {
			$sql = "SELECT * FROM $table WHERE session_id = '$sess_id'";

		}else{
			$sql = "SELECT * FROM $table WHERE 1=0"; //select a non-existing
		}

		ADODB_Session::create_log($sql);

		$result = $db_object->execute($sql);

		if (!$result->RecordCount()) {
			ADODB_Session::create_log('Recordset not found');
			$expire_notify = $GLOBALS['ADODB_SESSION_EXPIRE_NOTIFY'];
			$notify = '';
			if (isset($expire_notify)) {
				$var = reset($expire_notify);
				global $$var;
				if (isset($$var)) {
					$notify = $$var;
				}
			}


			/* if the session comes from sso then allow specifing the session id */
			/*
			if ( preg_match('/^SSO-(\w*+)-(\w*+)-([a-z0-9]*+)$/', $sess_id) ){
				$new_session_id = $sess_id;
			}else{
				//regen as usual
				$new_session_id = ADODB_Session::new_session_id();
			}
			*/

			$new_session_id = ADODB_Session::new_session_id();


/*			global $cookie_domain;*/

			$ip_address = '';
			$browser = '';

			if ( $SESSION_LOG_LEVEL > 0 ){
				$ip_address = ADODB_Session::ip_address();
			}

			if ( $SESSION_LOG_LEVEL > 1 ){
				$browser = ADODB_Session::browser_detection();
			}

			$expire_datetime = date('Y-m-d H:i:s', time() + $SESSION_DEFAULT_EXPIRE_TIME);
			$current_datetime = date('Y-m-d H:i:s');

			$user_id = false;
			$username = false;
			$auto_login = false;
			$is_admin = false;


//			$is_admin = 0;

			$request_url = '';
			$request_server = '';
			$request_hostname = '';
			$request_details = '';

			if ( $SESSION_LOG_LEVEL > 0 ){
				$ip_address = ADODB_Session::ip_address();
			}

			if ( $SESSION_LOG_LEVEL > 1 ){
				$browser = ADODB_Session::browser_detection();
			}

			if ( $SESSION_LOG_LEVEL > 2 ){
				$request_url = ADODB_Session::request_url();
			}

			if ( $SESSION_LOG_LEVEL > 3 ){
				$request_hostname = ADODB_Session::server_hostname();
				$request_server = ADODB_Session::server_host();
			}

			if ( $SESSION_LOG_LEVEL > 4 ){
				$request_details = ADODB_Session::request_details();
			}


			//Give back the new session ID to the browser
			session_id($new_session_id);
			$session_name = session_name();
			//Perhaps this could be done with something better..



			//php 5.1 without httponly
			//setrawcookie( $session_name, rawurlencode($new_session_id), 0, '/', '.car1.hk', false, true );

			header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
			header('Cache-Control: no-cache');
			header('Pragma: no-cache');
			header('Host: .car1.hk');

			//header('Set-Cookie: ' . $session_name . '=' .rawurlencode($new_session_id) .'; Path=/; HttpOnly');

			//header('Set-Cookie: ' . $session_name . '=' .rawurlencode($new_session_id) .'; Domain=.car1.hk; Path=/; HttpOnly');


			setrawcookie( $session_name, rawurlencode($new_session_id), 0, '/', '.car1.hk', false, true);
			setrawcookie( $session_name, rawurlencode($new_session_id), 0, '/', false, true); //this is needed otherwise it might not sync



			$sql = 'INSERT INTO '.$table .' ( id, user_id, username, persist_id, session_id, create_datetime, update_datetime, expire_datetime, auto_login, session_data, is_admin, ip_address, browser, request_url, request_server, request_hostname, request_details ) ';

			$sql .= ' VALUES ( "" , "" , "" , "" , "' .$new_session_id . '" , "' .$current_datetime . '" , "' .$current_datetime . '" , "' .$expire_datetime . '" , "' .$auto_login . '" , "" , "" , "' .$ip_address . '" , "' .$browser . '" , "' .$request_url . '" , "' .$request_server . '" , "' .$request_hostname . '" , "' .$request_details .'" ) ';

			ADODB_Session::create_log($sql);

			//header("host: .car1.hk");
			//header('set-cookie: ' . session_name() . '=' .$new_session_id .'; expires=0; domain=car1.hk; path=/; httponly');


			$db_object->execute($sql);

			if ($db_object->Insert_ID()){
				return $db_object->Insert_ID() ;
			}else{
				ADODB_Session::create_log('Some error with insertion of SQL : '.$sql);
				return false; //this should not happen
			}

		} else {
			ADODB_Session::create_log('The session is found');


			$session_data = trim($result->fields['session_data']) ;

			$epoch_expire_datetime = strtotime($result->fields['expire_datetime']);
			$seconds_to_expire = $epoch_expire_datetime - time();
			if ($seconds_to_expire < 0)
				$seconds_to_expire = 0;

			ADODB_Session::create_log($result->fields['expire_datetime']. " | " .$seconds_to_expire);

			if ($seconds_to_expire < $SESSION_TIME_FOR_EXTENDING_SESSION){
				ADODB_Session::create_log("This session will expire soon at : " . $epoch_expire_datetime);
				ADODB_Session::create_log('default expire: ' . $SESSION_DEFAULT_EXPIRE_TIME);

				$expire_datetime = date('Y-m-d H:i:s', time() + $SESSION_DEFAULT_EXPIRE_TIME);
				$current_datetime = date('Y-m-d H:i:s');


				$sql = "UPDATE $table SET expire_datetime = '$expire_datetime', update_datetime = '$current_datetime' WHERE session_id = '$sess_id' ";

				ADODB_Session::create_log($sql);

				$db_object->execute($sql);
			}

			return $session_data;
		}
	}

	public static function sess_write($sess_id, $data) {


		global $session_data;
		global $internal_update_time;
		global $SESSION_LOG_LEVEL;

		$user_id = 0;
		$username = '';
		$auto_login = false;
		$is_admin = false;
		$persist_id = 0;



		if ($data == $session_data){
			//No point to update it the original is the same as new
			//Because Update of sql is heavy
			return false;
		}


		ADODB_Session::create_log('Calling sess_write('.$sess_id.')');
		ADODB_Session::create_log('Write data ('.$data.')');


		if( trim($sess_id ) == "" ){
			return false;
		}


		$temp_data = explode(";", $data);

		//only for getting the userid, username
		for($i=0; $i<count($temp_data); $i++){

			$this_temp = explode ('|', $temp_data[$i]);

			if ($this_temp[0] == 'user_id' ){
				$index = strpos($this_temp[1], '"');

				if ($index !== false)
					$user_id = (int) trim( substr($this_temp[1], $index) , '"' );

				//echo "user_id:".$user_id;

				continue;
			}elseif ($this_temp[0] == 'username' ){
				$index = strpos($this_temp[1], '"');

				if ($index !== false)
					$username = trim( substr($this_temp[1], $index) , '"' );

				continue;
			}elseif ($this_temp[0] == 'persist_id' ){
				$index = strpos($this_temp[1], '"');

				if ($index !== false)
					$persist_id = trim( substr($this_temp[1], $index) , '"' );

				continue;
			}elseif ($this_temp[0] == 'auto_login' ){
				$index = strpos($this_temp[1], '"');

				if ($index !== false)
					$auto_login = trim( substr($this_temp[1], $index) , '"' );;

				continue;
			}elseif ($this_temp[0] == 'is_admin' ){
				$index = strpos($this_temp[1], '"');

				if ($index !== false)
					$is_admin = (int) trim( substr($this_temp[1], $index) , '"' ); ;
				continue;
			}


		}


//		$data = mysql_real_escape_string($data);

		//Coding needed, update the session_data
		//Also need to implement the max session limit

		$db_object =& $GLOBALS['ADODB_SESS_CONN'];
		$table = $GLOBALS['ADODB_SESSION_TBL'];

		if (isset($GLOBALS['ADODB_SESS_LIFE'])) {
			$lifetime = $GLOBALS['ADODB_SESS_LIFE'];
		}
		else
		{
			$lifetime = ini_get('session.gc_maxlifetime');
			if ($lifetime <= 1) {
				$lifetime = 7200;
			}
		}

		$expire_notify = $GLOBALS['ADODB_SESSION_EXPIRE_NOTIFY'];
		$notify = '';
		if (isset($expire_notify)) {
			$var = reset($expire_notify);
			global $$var;
			if (isset($$var)) {
				$notify = $$var;
			}
		}

		global $SESSION_DEFAULT_EXPIRE_TIME;
		$expire_datetime = date('Y-m-d H:i:s', time() + $SESSION_DEFAULT_EXPIRE_TIME);
		$current_datetime = date('Y-m-d H:i:s');

		/* //no more used in php 5.3
		if ( !get_magic_quotes_gpc() ){
			$data = addslashes($data);
		}
		*/


		$browser = '';
		$request_url = '';
		$request_details = '';
		$request_server = '';
		$request_hostname = '';
		$ip_address = '';


		if ( $SESSION_LOG_LEVEL > 0 ){
			$ip_address = ADODB_Session::ip_address();
		}

		if ( $SESSION_LOG_LEVEL > 1 ){
			$browser = ADODB_Session::browser_detection();
		}

		if ( $SESSION_LOG_LEVEL > 2 ){
			$request_url = ADODB_Session::request_url();
		}

		if ( $SESSION_LOG_LEVEL > 3 ){
			$request_hostname = ADODB_Session::server_hostname();
			$request_server = ADODB_Session::server_host();
		}

		if ( $SESSION_LOG_LEVEL > 4 ){
			$request_details = ADODB_Session::request_details();
		}

		$sql = "UPDATE $table SET expire_datetime = '$expire_datetime', update_datetime = '$current_datetime', session_data = '$data', persist_id = '$persist_id', user_id = '$user_id', username='$username', auto_login ='$auto_login' , is_admin = '$is_admin' , browser = '$browser', request_url = '$request_url', request_server= '$request_server',  request_hostname= '$request_hostname', request_details ='$request_details', ip_address = '$ip_address' WHERE session_id = '$sess_id'";

		ADODB_Session::create_log('Session write: ' . $sql);

		$db_object->execute($sql);
//		$result = $db_object->execute($sql);
		return true;
	}

	public static function sess_destroy($sess_id) {

		ADODB_Session::create_log('Calling sess_destroy('.$sess_id.')');

		$db_object =& $GLOBALS['ADODB_SESS_CONN'];
		$table = $GLOBALS['ADODB_SESSION_TBL'];

		/* perform some security checking */

		$replace_list = array();
		$replace_list[] = ' ';
		$replace_list[] = '\\';
		$replace_list[] = 'delete';
		$replace_list[] = '"';
		$replace_list[] = '*';
		$replace_list[] = '{';
		$replace_list[] = '}';
		$replace_list[] = '(';
		$replace_list[] = ')';

		$clean_sess_id = str_replace($replace_list, '', $sess_id);

		if ( trim ( $clean_sess_id) == "" ){
			return false;
		}

		$sql = "DELETE FROM $table WHERE session_id = '$clean_sess_id'";
		//echo $sql;
		ADODB_Session::create_log('Delete :' . $sql);


		$result =& $db_object->execute($sql);
		if ($result) {
			$result->Close();
		}

		return $result ? true : false;
	}

	public static function sess_gc($sess_maxlifetime) {
		global $SESSION_MAX_SESSIONS_PER_LOGINED_USERS;
		global $SESSION_REMOVE_SESSIONS_PER_LOGINED_USERS;

		ADODB_Session::create_log('Calling sess_gc()');

		$db_object =& $GLOBALS['ADODB_SESS_CONN'];
		$table = $GLOBALS['ADODB_SESSION_TBL'];

//		$current_time = (isset($sess_maxlifetime)) ? $sess_maxlifetime : time();

		$current_time = time();

		//Delete Expired records
		$sql = 'DELETE FROM '.$table. ' WHERE expire_datetime < \'' .date('Y-m-d H:i:s', $current_time) . '\'';
		ADODB_Session::create_log('GC Removal of expired sessions :' .$sql);
		$result =& $db_object->Execute($sql);

		if ($result) {
			$result->Close();
		}


		//We skip removal of limiting session for users is it is defined not to remove.
		if ($SESSION_REMOVE_SESSIONS_PER_LOGINED_USERS == false)
			return true;

		//Perform another query, experienmental, we try to search for users who multi-login and create many unique sessions, we allow only 50 uniques sessions for each users to keep the database size small
		//$SESSION_MAX_SESSIONS_PER_LOGINED_USERS
		$sql = 'SELECT user_id, COUNT(*) AS CNT FROM '.$table . ' WHERE user_id > 0 GROUP BY user_id HAVING CNT > ' . $SESSION_MAX_SESSIONS_PER_LOGINED_USERS;
		ADODB_Session::create_log('Removal of session exceeding max per user_id :'.$sql);
		$result = $db_object->Execute($sql);

		$total_records = $result->RecordCount();
		if ($total_records) {

			$data = $result->GetArray();
			for ($i=0; $i<$total_records; $i++){
				ADODB_Session::create_log('user_id: ' . $data[$i]['user_id'] . ' has session_count: ' . $data[$i]['CNT']);

				$this_sql = 'SELECT * FROM ' . $table . ' WHERE user_id = ' . $data[$i]['user_id'] . ' ORDER BY create_datetime DESC ';
				ADODB_Session::create_log($this_sql);

				//Retrive 200 records, offset using the $SESSION_MAX_SESSIONS_PER_LOGINED_USERS
				$this_rs = $db_object->SelectLimit($this_sql, 200, $SESSION_MAX_SESSIONS_PER_LOGINED_USERS);

				$this_ids = array();

				while (!$this_rs->EOF){
					$row = $this_rs->fields;
					$id = $row['id'];
					ADODB_Session::create_log('Removing id: ' .$id);

					$this_ids[] = $row['id'];;

					$this_rs->MoveNext();
				}

				if (count($this_ids) > 0){
					$ids_str = implode(',' , $this_ids);
					ADODB_Session::create_log('Removing id: ' .$ids_str);

					$remove_sql = 'DELETE FROM ' . $table . ' WHERE id IN (' . $ids_str . ')';
					ADODB_Session::create_log('GC removal from user_id : ' .$data[$i]['user_id'] . ': ' . $remove_sql);
					$db_object->Execute($remove_sql);

				}

			}

		}

		$sql = 'optimize table '. $table;
		$db_object->Execute($sql);

		return true;
	}

	function gc($sess_maxlifetime) {
		ADODB_Session::sess_gc($sess_maxlifetime);
	}

	/*
	 * Initialize
	 */
	public static function _init() {
		session_module_name();
		session_set_save_handler(
			array('ADODB_Session', 'sess_open'),	//open
			array('ADODB_Session', 'sess_close'),	//close
			array('ADODB_Session', 'sess_read'),	//read
			array('ADODB_Session', 'sess_write'),	//write
			array('ADODB_Session', 'sess_destroy'),	//destroy
			array('ADODB_Session', 'sess_gc')		//gc
		);
		register_shutdown_function('session_write_close');
	}


}

ADODB_Session::_init();

// for backwards compatability only
function adodb_sess_open($save_path, $session_name, $persist = true) {
	return ADODB_Session::sess_open($save_path, $session_name, $persist);
}

// for backwards compatability only
function adodb_sess_gc($sess_maxlifetime)
{
	return ADODB_Session::gc($sess_maxlifetime);
}

?>