#
# Structure de la table `xfguestbook_country`
#

CREATE TABLE `xfguestbook_country` (
  `country_id`   MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_code` VARCHAR(5)            NOT NULL DEFAULT '0',
  `country_name` VARCHAR(50)           NOT NULL DEFAULT '',
  PRIMARY KEY (`country_id`),
  KEY `country_code` (`country_code`)
)
  ENGINE = MyISAM
  AUTO_INCREMENT = 51;
