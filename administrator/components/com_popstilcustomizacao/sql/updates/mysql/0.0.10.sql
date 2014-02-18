DROP TABLE IF EXISTS `#__customizacao_tamanhos`;
DROP TABLE IF EXISTS `#__customizacao_categoria_tamanhos`;

CREATE TABLE `#__customizacao_categoria_tamanhos` (
	`id_cat_tamanho` int(11) NOT NULL AUTO_INCREMENT,
	`titulo` varchar(55) NOT NULL,
	`dataAlteracao` text null,
	PRIMARY KEY (`id_cat_tamanho`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__customizacao_tamanhos` (
  `id_tamanho` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `largura` varchar(10) NOT NULL,
  `altura` varchar(10) NOT NULL,
  `dataAlteracao` text null,
   PRIMARY KEY  (`id_tamanho`),
   FOREIGN KEY (`id_categoria`) REFERENCES `#__customizacao_categoria_tamanhos`(`id_cat_tamanho`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__customizacao_numeropessoas` (
  `id_numpessoas` int(11) NOT NULL AUTO_INCREMENT,
  `numero_pessoas` int(2) NOT NULL,
  `id_tamanho` int(11) NOT NULL,
  `dataAlteracao` text null,
  `preco` decimal(10,2),
   PRIMARY KEY  (`id_tamanho`,`id_numpessoas`),
   FOREIGN KEY (`id_categoria`) REFERENCES `#__customizacao_categoria_tamanhos`(`id_cat_tamanho`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__customizacao_categoria_tamanhos` (id_cat_tamanho,titulo,dataAlteracao) VALUES (1,'Quadrado',now());
INSERT INTO `#__customizacao_categoria_tamanhos` (id_cat_tamanho,titulo,dataAlteracao) VALUES (2,'Retangular',now());

INSERT INTO `#__customizacao_tamanhos` (id_tamanho,id_categoria,largura,altura,dataAlteracao) VALUES(1,1,'30','30',now());
INSERT INTO `#__customizacao_tamanhos` (id_tamanho,id_categoria,largura,altura,dataAlteracao) VALUES(2,1,'40','40',now());
INSERT INTO `#__customizacao_tamanhos` (id_tamanho,id_categoria,largura,altura,dataAlteracao) VALUES(3,1,'60','60',now());
INSERT INTO `#__customizacao_tamanhos` (id_tamanho,id_categoria,largura,altura,dataAlteracao) VALUES(4,1,'80','80',now());

INSERT INTO `#__customizacao_tamanhos` (id_tamanho,id_categoria,largura,altura,dataAlteracao) VALUES(5,2,'40','30',now());
INSERT INTO `#__customizacao_tamanhos` (id_tamanho,id_categoria,largura,altura,dataAlteracao) VALUES(6,2,'50','40',now());
INSERT INTO `#__customizacao_tamanhos` (id_tamanho,id_categoria,largura,altura,dataAlteracao) VALUES(7,2,'60','40',now());
INSERT INTO `#__customizacao_tamanhos` (id_tamanho,id_categoria,largura,altura,dataAlteracao) VALUES(8,2,'80','60',now());

INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(1,1,now(),550);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(1,2,now(),650);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(1,3,now(),750);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(1,4,now(),840);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(1,5,now(),940);

INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(2,1,now(),570);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(2,2,now(),670);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(2,3,now(),770);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(2,4,now(),860);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(2,5,now(),960);

INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(3,1,now(),690);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(3,2,now(),790);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(3,3,now(),900);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(3,4,now(),990);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(3,5,now(),1090);

INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(4,1,now(),840);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(4,2,now(),940);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(4,3,now(),1040);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(4,4,now(),1140);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(4,5,now(),1240);

INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(5,1,now(),570);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(5,2,now(),670);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(5,3,now(),770);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(5,4,now(),860);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(5,5,now(),960);

INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(6,1,now(),610);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(6,2,now(),710);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(6,3,now(),820);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(6,4,now(),900);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(6,5,now(),1000);

INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(7,1,now(),640);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(7,2,now(),740);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(7,3,now(),840);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(7,4,now(),930);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(7,5,now(),1030);

INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(8,1,now(),770);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(8,2,now(),870);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(8,3,now(),970);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(8,4,now(),1060);
INSERT INTO `#__customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(8,5,now(),1160);
