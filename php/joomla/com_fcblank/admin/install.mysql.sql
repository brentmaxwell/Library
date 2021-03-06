CREATE TABLE IF NOT EXISTS `#__fcblank_tbl`
(
  `id`               int(11)          NOT NULL AUTO_INCREMENT,
  `title`            varchar(255)     NOT NULL,
  `title_alias`      varchar(255)     NOT NULL,
  `introtext`        mediumtext       NOT NULL,
  `fulltext`         mediumtext       NOT NULL,
  `displaydate`      date             NOT NULL DEFAULT '0000-00-00',
  `displaydate2`     date             NOT NULL DEFAULT '0000-00-00',
  `state`            tinyint(3)       NOT NULL DEFAULT '0',
  `published`        tinyint(3)       NOT NULL DEFAULT '0',
  `sectionid`        int(11) unsigned NOT NULL DEFAULT '0',
  `catid`            int(11) unsigned NOT NULL DEFAULT '0',
  `created`          datetime         NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by`       int(11) unsigned NOT NULL DEFAULT '0',
  `modified`         datetime         NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by`      int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out`      int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime         NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering`         int(11)          NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);