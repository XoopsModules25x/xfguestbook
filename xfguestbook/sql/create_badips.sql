#
# Structure de la table `xfguestbook_badips`
#

CREATE TABLE `xfguestbook_badips` (
  `ip_id` mediumint(8) unsigned NOT NULL auto_increment,
  `ip_value` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`ip_id`),
  KEY `country_code` (`ip_value`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
