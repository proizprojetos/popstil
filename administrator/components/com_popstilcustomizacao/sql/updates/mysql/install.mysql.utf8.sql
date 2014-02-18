DROP TABLE IF EXISTS `#__customizacao_tamanhos`;

CREATE TABLE `#__customizacao_tamanhos` (
  `id_tamanho` int(11) NOT NULL AUTO_INCREMENT,
  `largura` varchar(10) NOT NULL,
  `altura` varchar(10) NOT NULL,
  `dataAlteracao` text null,
  `preco` decimal(10,2),
   PRIMARY KEY  (`id_tamanho`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__customizacao_tamanhos` (largura,altura,dataAlteracao,preco) VALUES('100','70',now(),150,00);