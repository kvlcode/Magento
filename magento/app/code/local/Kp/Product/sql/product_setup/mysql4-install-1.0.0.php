<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('product')};
CREATE TABLE {$this->getTable('product')} (
  `product_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(256) NOT NULL,
  `sku` varchar(128) NOT NULL,
  `price` float NOT NULL,
    `quantity` int(8) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `createdAt` datetime DEFAULT NULL,
    `updatedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();