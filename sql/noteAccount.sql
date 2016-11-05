`noteAccount`

CREATE TABLE IF NOT EXISTS `noteAccount` (
  `listID` int(255) NOT NULL AUTO_INCREMENT,
  `user` varchar(150) CHARACTER SET utf8 NOT NULL,
  `list` text CHARACTER SET utf8 NOT NULL,
  `moneyIN` int(255) NOT NULL,
  `moneyOUT` int(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`listID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;