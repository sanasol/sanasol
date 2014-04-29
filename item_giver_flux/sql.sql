CREATE TABLE IF NOT EXISTS `itemgiver` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `item_id` int(10) NOT NULL,
  `amount` int(5) NOT NULL,
  `account_id` int(11) NOT NULL,
  `time` int(30) NOT NULL,
  `sender` int(30) NOT NULL,
  `received` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `itemgiver` (`id`, `item_id`, `amount`, `account_id`, `time`, `sender`, `received`) VALUES
(1, 501, 10, 2000000, 1398283016, 2000000, 0);