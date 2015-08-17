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

INSERT INTO `xfguestbook_config` VALUES (1, 2, 'opt_mail', '_AM_XFGB_MAILTRUE', '', '1', 'selectmail', 'int', 1);
INSERT INTO `xfguestbook_config` VALUES (2, 2, 'opt_gender', '_AM_XFGB_GENDER_OPT', '', '1', 'yesno', 'int', 2);
INSERT INTO `xfguestbook_config` VALUES (3, 2, 'opt_country', '_AM_XFGB_COUNTRY_OPT', '', '1', 'yesno', 'text', 3);
INSERT INTO `xfguestbook_config` VALUES (4, 2, 'opt_icon', '_AM_XFGB_OPT1', '', '1', 'yesno', 'int', 5);
INSERT INTO `xfguestbook_config` VALUES (7, 2, 'opt_url', '_AM_XFGB_URL_OPT', '', '1', 'selectaction', 'int', 8);
INSERT INTO `xfguestbook_config` VALUES (8, 2, 'opt_code', '_AM_XFGB_CODE_OPT', '', '0', 'yesno', 'int', 9);
INSERT INTO `xfguestbook_config` VALUES (9, 2, 'countrybydefault', '_AM_XFGB_COUNTRYDEF', '', '', 'selectcountry', 'text', 4);
INSERT INTO `xfguestbook_config` VALUES (10, 2, 'opt_website', '_AM_XFGB_WEBSITE_OPT', '', '0', 'selectwebsite', 'int', 10);
