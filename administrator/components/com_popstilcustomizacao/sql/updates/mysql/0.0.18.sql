DROP TABLE IF EXISTS `#__customizacao_molduras`;

CREATE TABLE `#__customizacao_molduras` (
	`id_moldura` int(11) NOT NULL AUTO_INCREMENT,
	`titulo` varchar(55) NOT NULL,
	`url_moldura` text null,
	`dataAlteracao` text null,
	PRIMARY KEY (`id_moldura`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;