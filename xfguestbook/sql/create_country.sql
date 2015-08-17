#
# Structure de la table `xfguestbook_country`
#

CREATE TABLE `xfguestbook_country` (
  `country_id` mediumint(8) unsigned NOT NULL auto_increment,
  `country_code` varchar(5) NOT NULL default '0',
  `country_name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`country_id`),
  KEY `country_code` (`country_code`)
) ENGINE=MyISAM AUTO_INCREMENT=51 ;
