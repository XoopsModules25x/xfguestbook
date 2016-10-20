#
# Structure de la table `xfguestbook_msg`
#

CREATE TABLE `xfguestbook_msg` (
  `msg_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default '0',
  `uname` varchar(150) default NULL,
  `title` varchar(150) default NULL,
  `message` longtext,
  `note` longtext,
  `post_time` int(10) NOT NULL default '0',
  `email` varchar(60) default NULL,
  `url` varchar(100) default NULL,
  `poster_ip` varchar(15) default NULL,
  `moderate` tinyint(1) default NULL,
  `gender` char(1) NOT NULL default '',
  `country` char(5) default NULL,
  `photo` varchar(25) default NULL,
  `flagdir` varchar(20) NOT NULL default '',
  `other` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`msg_id`)
) ENGINE=MyISAM;

#
# Contenu de la table `xfguestbook_msg`
#

INSERT INTO xfguestbook_msg (msg_id, user_id, uname, title, message, note, post_time, email, url, poster_ip, moderate,gender,country,photo,flagdir) VALUES (1, 0, 'Joe Doe PHP team', 'Welcome', ':-) Welcome in your Guestbook', 'You can delete this message', 1073730287, '', '', '127.0.0.1', 0,'M','FR','msg_1000000000.jpg','world_flags');


#
# Structure de la table `xfguestbook_config`
#

CREATE TABLE `xfguestbook_config` (
  `conf_id` smallint(5) unsigned NOT NULL auto_increment,
  `conf_cat` smallint(5) unsigned NOT NULL default '0',
  `conf_name` varchar(25) NOT NULL default '',
  `conf_title` varchar(30) NOT NULL default '',
  `conf_desc` varchar(30) NOT NULL default '',
  `conf_value` text NOT NULL,
  `conf_formtype` varchar(15) NOT NULL default '',
  `conf_valuetype` varchar(10) NOT NULL default '',
  `conf_order` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`conf_id`)
) ENGINE=MyISAM ;

#
# Contenu de la table `xfguestbook_config`
#

INSERT INTO `xfguestbook_config` VALUES (1, 2, 'opt_mail', '_AM_XFGB_MAILTRUE', '', '1', 'selectmail', 'int', 1);
INSERT INTO `xfguestbook_config` VALUES (2, 2, 'opt_gender', '_AM_XFGB_GENDER_OPT', '', '1', 'yesno', 'int', 2);
INSERT INTO `xfguestbook_config` VALUES (3, 2, 'opt_country', '_AM_XFGB_COUNTRY_OPT', '', '1', 'yesno', 'text', 3);
INSERT INTO `xfguestbook_config` VALUES (4, 2, 'opt_icon', '_AM_XFGB_OPT1', '', '1', 'yesno', 'int', 5);
INSERT INTO `xfguestbook_config` VALUES (7, 2, 'opt_url', '_AM_XFGB_URL_OPT', '', '1', 'selectaction', 'int', 8);
INSERT INTO `xfguestbook_config` VALUES (8, 2, 'opt_code', '_AM_XFGB_CODE_OPT', '', '0', 'yesno', 'int', 9);
INSERT INTO `xfguestbook_config` VALUES (9, 2, 'countrybydefault', '_AM_XFGB_COUNTRYDEF', '', '', 'selectcountry', 'text', 4);
INSERT INTO `xfguestbook_config` VALUES (10, 2, 'opt_website', '_AM_XFGB_WEBSITE_OPT', '', '2', 'selectwebsite', 'int', 10);

#
# Structure de la table `xfguestbook_country`
#

CREATE TABLE `xfguestbook_country` (
  `country_id` mediumint(8) unsigned NOT NULL auto_increment,
  `country_code` varchar(5) NOT NULL default '0',
  `country_name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`country_id`),
  KEY `country_code` (`country_code`)
) ENGINE=MyISAM ;


#
# Structure de la table `xfguestbook_badips`
#

CREATE TABLE `xfguestbook_badips` (
  `ip_id` mediumint(8) unsigned NOT NULL auto_increment,
  `ip_value` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`ip_id`),
  KEY `country_code` (`ip_value`)
) ENGINE=MyISAM ;
