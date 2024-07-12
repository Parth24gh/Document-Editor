SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET NAMES UTF8;

/*initially notes use to be saved on 'data' table but later creation of user was embedded 
in which each user had their own table in database to save theire notes.*/

CREATE TABLE IF NOT EXISTS `data` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `fdate` varchar(50) NOT NULL,
  `ldate` varchar(50) NOT NULL,
  `contents` mediumtext NOT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS `users` (
  `password` varchar(128) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;