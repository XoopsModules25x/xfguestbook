#
# Structure de la table `xfguestbook_config`
#

CREATE TABLE `xfguestbook_config` (
  `conf_id`        SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `conf_cat`       SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
  `conf_name`      VARCHAR(25)          NOT NULL DEFAULT '',
  `conf_title`     VARCHAR(30)          NOT NULL DEFAULT '',
  `conf_desc`      VARCHAR(30)          NOT NULL DEFAULT '',
  `conf_value`     TEXT                 NOT NULL,
  `conf_formtype`  VARCHAR(15)          NOT NULL DEFAULT '',
  `conf_valuetype` VARCHAR(10)          NOT NULL DEFAULT '',
  `conf_order`     SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`conf_id`)
)
  ENGINE = MyISAM
  AUTO_INCREMENT = 11;

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
