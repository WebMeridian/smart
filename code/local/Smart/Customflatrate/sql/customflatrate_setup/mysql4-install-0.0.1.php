<?php
$installer = $this;
$installer->startSetup();

$installer->run("CREATE TABLE IF NOT EXISTS `smart_customflatrate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` int(10) DEFAULT 0,
  `title` varchar(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `code` varchar(250) DEFAULT NULL,
  `type` varchar(250) DEFAULT NULL,
  `handling_type` varchar(250) DEFAULT NULL,
  `handling_fee` float(11) DEFAULT 0,  
  `price` float(11) DEFAULT 0,  
  `specificerrmsg` text DEFAULT NULL,
  `infotext` text DEFAULT NULL,  
  `sallowspecific` int(10) DEFAULT 0,
  `specificcountry` varchar(250) DEFAULT NULL,
  `showmethod` int(10) DEFAULT 0,
  `sort_order` int(10) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


");


$installer->endSetup();