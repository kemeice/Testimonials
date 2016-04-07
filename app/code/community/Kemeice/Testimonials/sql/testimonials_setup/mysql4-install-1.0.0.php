<?php

$installer	= $this;

$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$installer->getTable('Kemeice_testimonials')};
CREATE TABLE {$installer->getTable('Kemeice_testimonials')} (
	`testimonial_id`		int(11) unsigned NOT NULL auto_increment,
	`name`				varchar(255) NOT NULL DEFAULT '',
	`description`		text NOT NULL DEFAULT '',
	`status`			smallint(6) NOT NULL DEFAULT 0,
	`created_time`		datetime NULL,
	`updated_time`		datetime NULL,
	
	PRIMARY KEY (`testimonial_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();