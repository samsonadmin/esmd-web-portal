-- $CVSHeader$

CREATE DATABASE /*! IF NOT EXISTS */ adodb_sessions;

DROP TABLE /*! IF EXISTS */ sessions;

CREATE TABLE /*! IF NOT EXISTS */ sessions (
	ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	SessionID VARCHAR(64), 
	session_data TEXT DEFAULT '', 
	expiry INT(11),
	expireref	VARCHAR(250)	DEFAULT '',
	INDEX (SessionID),
	INDEX expiry (expiry)
);



CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `session_id` varchar(32) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `username` varchar(128) default NULL,
  `create_datetime` datetime NOT NULL,
  `expire_datetime` datetime NOT NULL,
  `auto_login` tinyint(1) NOT NULL default '0',
  `session_data` text,
  `is_admin` tinyint(1) NOT NULL default '0',
  `browser` varchar(128) default NULL,
  `ip_address` varchar(64) default NULL,
  PRIMARY KEY  (`id`),
  KEY `session_id` (`session_id`),
  KEY `user_id` (`user_id`),
  KEY `expire_datetime` (`expire_datetime`),
  KEY `ip_address` (`ip_address`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;