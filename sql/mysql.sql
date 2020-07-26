#
# Structure de la table `xfguestbook_msg`
#

CREATE TABLE `xfguestbook_msg` (
  `msg_id`    INT(11)     NOT NULL AUTO_INCREMENT,
  `user_id`   INT(11)              DEFAULT '0',
  `uname`     VARCHAR(150)         DEFAULT NULL,
  `title`     VARCHAR(150)         DEFAULT NULL,
  `message`   LONGTEXT,
  `note`      LONGTEXT,
  `post_time` INT(10)     NOT NULL DEFAULT '0',
  `email`     VARCHAR(60)          DEFAULT NULL,
  `url`       VARCHAR(100)         DEFAULT NULL,
  `poster_ip` VARCHAR(15)          DEFAULT NULL,
  `moderate`  TINYINT(1)           DEFAULT NULL,
  `gender`    CHAR(1)     NOT NULL DEFAULT '',
  `country`   CHAR(5)              DEFAULT NULL,
  `photo`     VARCHAR(25)          DEFAULT NULL,
  `flagdir`   VARCHAR(20) NOT NULL DEFAULT '',
  `other`     VARCHAR(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`msg_id`)
)
  ENGINE = MyISAM;

#
# Contenu de la table `xfguestbook_msg`
#

INSERT INTO xfguestbook_msg (msg_id, user_id, uname, title, message, note, post_time, email, url, poster_ip, moderate, gender, country, photo, flagdir)
VALUES (1, 0, 'Joe Doe PHP team', 'Welcome', ':-) Welcome in your Guestbook', 'You can delete this message', 1073730287, '', '', '127.0.0.1', 0, 'M', 'FR', 'msg1.jpg', 'world_flags');

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
  ENGINE = MyISAM;

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
INSERT INTO `xfguestbook_config` VALUES (10, 2, 'opt_website', 'AM_XFGUESTBOOK_WEBSITE_OPT', '', '2', 'selectwebsite', 'int', 10);

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
  ENGINE = MyISAM;

#
# Structure de la table `xfguestbook_badips`
#

CREATE TABLE `xfguestbook_badips` (
  `ip_id`    MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_value` VARCHAR(50)           NOT NULL DEFAULT '',
  PRIMARY KEY (`ip_id`),
  KEY `country_code` (`ip_value`)
)
  ENGINE = MyISAM;
