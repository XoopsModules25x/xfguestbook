#
# Structure de la table `xfguestbook_badips`
#

CREATE TABLE `xfguestbook_badips` (
  `ip_id`    MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_value` VARCHAR(50)           NOT NULL DEFAULT '',
  PRIMARY KEY (`ip_id`),
  KEY `country_code` (`ip_value`)
)
  ENGINE = MyISAM
  AUTO_INCREMENT = 1;
