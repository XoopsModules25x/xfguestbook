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
) ENGINE=MyISAM AUTO_INCREMENT=11 ;

#
# Contenu de la table `xfguestbook_config`
#

INSERT INTO `xfguestbook_config` VALUES (1, 2, 'opt_mail', 'AM_XFGUESTBOOK_MAILTRUE', '', '1', 'selectmail', 'int', 1);
INSERT INTO `xfguestbook_config` VALUES (2, 2, 'opt_gender', 'AM_XFGUESTBOOK_GENDER_OPT', '', '1', 'yesno', 'int', 2);
INSERT INTO `xfguestbook_config` VALUES (3, 2, 'opt_country', 'AM_XFGUESTBOOK_COUNTRY_OPT', '', '1', 'yesno', 'text', 3);
INSERT INTO `xfguestbook_config` VALUES (4, 2, 'opt_icon', 'AM_XFGUESTBOOK_OPT1', '', '1', 'yesno', 'int', 5);
INSERT INTO `xfguestbook_config` VALUES (7, 2, 'opt_url', 'AM_XFGUESTBOOK_URL_OPT', '', '1', 'selectaction', 'int', 8);
INSERT INTO `xfguestbook_config` VALUES (8, 2, 'opt_code', 'AM_XFGUESTBOOK_CODE_OPT', '', '0', 'yesno', 'int', 9);
INSERT INTO `xfguestbook_config` VALUES (9, 2, 'countrybydefault', 'AM_XFGUESTBOOK_COUNTRYDEF', '', '', 'selectcountry', 'text', 4);
INSERT INTO `xfguestbook_config` VALUES (10, 2, 'opt_website', 'AM_XFGUESTBOOK_WEBSITE_OPT', '', '0', 'selectwebsite', 'int', 10);
