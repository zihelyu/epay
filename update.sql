ALTER TABLE `pay_user`
ADD COLUMN `rate` varchar(8) DEFAULT NULL;

ALTER TABLE `pay_user`
ADD COLUMN `qq_uid` varchar(32) DEFAULT NULL;

ALTER TABLE `pay_order`
ADD COLUMN `domain` varchar(32) DEFAULT NULL,
ADD COLUMN `ip` varchar(20) DEFAULT NULL;

ALTER TABLE `pay_user`
ADD COLUMN `settle_id` int(1) NOT NULL DEFAULT '1',
ADD COLUMN `email` varchar(32) DEFAULT NULL,
ADD COLUMN `phone` varchar(20) DEFAULT NULL,
ADD COLUMN `qq` varchar(20) DEFAULT NULL;

ALTER TABLE `pay_settle`
MODIFY COLUMN `type` int(1) NOT NULL DEFAULT '1';

DROP TABLE IF EXISTS `pay_regcode`;
CREATE TABLE `pay_regcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL DEFAULT '0',
  `code` varchar(32) NOT NULL,
  `email` varchar(32) DEFAULT NULL,
  `time` int(11) NOT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `trade_no` varchar(32) DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `pay_user`
ADD COLUMN `wxid` varchar(32) DEFAULT NULL;