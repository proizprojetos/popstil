DROP TABLE IF EXISTS `#__popstil_customizacao_tamanhos`;
DROP TABLE IF EXISTS `#__popstil_customizacao_categoria_tamanhos`;
DROP TABLE IF EXISTS `#__popstil_customizacao_numeropessoas`;
DROP TABLE IF EXISTS `#__popstil_customizacao_molduras`;
DROP TABLE IF EXISTS `#__popstil_enderecos`;
DROP TABLE IF EXISTS `#__popstil_usuarios`;

CREATE TABLE `#__popstil_customizacao_categoria_tamanhos` (
	`id_cat_tamanho` int(11) NOT NULL AUTO_INCREMENT,
	`titulo` varchar(55) NOT NULL,
	`dataAlteracao` text null,
	PRIMARY KEY (`id_cat_tamanho`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__popstil_customizacao_tamanhos` (
  `id_tamanho` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `largura` varchar(10) NOT NULL,
  `altura` varchar(10) NOT NULL,
  `estilo` text null,
  `peso` decimal(4,2),
  `dataAlteracao` text null,
   PRIMARY KEY  (`id_tamanho`),
   FOREIGN KEY (`id_categoria`) REFERENCES `#__popstil_customizacao_categoria_tamanhos`(`id_cat_tamanho`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__popstil_customizacao_numeropessoas` (
  `id_numpessoas` int(11) NOT NULL AUTO_INCREMENT,
  `numero_pessoas` int(2) NOT NULL,
  `id_tamanho` int(11) NOT NULL,
  `dataAlteracao` text null,
  `preco` decimal(10,2),
   PRIMARY KEY  (`id_numpessoas`),
   FOREIGN KEY (`id_tamanho`) REFERENCES `#__popstil_customizacao_tamanhos`(`id_tamanho`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__popstil_customizacao_molduras` (
	`id_moldura` int(11) NOT NULL AUTO_INCREMENT,
	`titulo` varchar(55) NOT NULL,
	`url_moldura` text null,
	`dataAlteracao` text null,
	PRIMARY KEY (`id_moldura`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__popstil_usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nomecompleto` VARCHAR(255) NOT NULL ,
  `CPF` INT(11) NOT NULL COMMENT '		' ,
  `datanascimento` TIMESTAMP NULL ,
  `sexo` TEXT(1) NULL ,
  `username` VARCHAR(100) NOT NULL COMMENT '	' ,
  `password` VARCHAR(100) NOT NULL ,
  `email` VARCHAR(100) NOT NULL COMMENT '	' ,
  `enviaremail` VARCHAR(100) NOT NULL ,
  `dataregistro` DATETIME NULL ,
  `ddd1` VARCHAR(3) NULL ,
  `telefone1` VARCHAR(10) NULL ,
  `ddd2` VARCHAR(3) NULL ,
  `telefone2` VARCHAR(10) NULL ,
  `params` TEXT NULL ,
  PRIMARY KEY (`id`) 
)PACK_KEYS = 0 ROW_FORMAT = DEFAULT;

CREATE TABLE `#__popstil_enderecos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `popstil_usuario_idusuario` INT(11) NOT NULL ,
  `endereco` VARCHAR(255) NULL ,
  `numero` INT NULL ,
  `complemento` VARCHAR(100) NULL ,
  `cep` INT(8) NULL ,
  `bairro` VARCHAR(100) NULL ,
  `cidade` VARCHAR(100) NULL ,
  `estado` VARCHAR(45) NULL ,
  `pais` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `Endereco_FKIndex1` (`popstil_usuario_idusuario` ASC) ,
  CONSTRAINT `fk_771C868F-EB31-4A72-B034-DDFA4BFD6A4E`
    FOREIGN KEY (`popstil_usuario_idusuario` )
    REFERENCES `#__popstil_usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
PACK_KEYS = 0
ROW_FORMAT = DEFAULT;




INSERT INTO `#__popstil_customizacao_categoria_tamanhos` (id_cat_tamanho,titulo,dataAlteracao) VALUES (1,'Quadrado',now());
INSERT INTO `#__popstil_customizacao_categoria_tamanhos` (id_cat_tamanho,titulo,dataAlteracao) VALUES (2,'Retangular',now());

INSERT INTO `#__popstil_customizacao_tamanhos` (id_tamanho,id_categoria,largura,altura,estilo,peso,dataAlteracao) VALUES(1,1,'30','30','width:35px;height:35px;margin:49px;','3.50',now());
INSERT INTO `#__popstil_customizacao_tamanhos` (id_tamanho,id_categoria,largura,altura,estilo,peso,dataAlteracao) VALUES(2,1,'40','40','width: 56px;height: 56px;margin:38px;','3.50',now());
INSERT INTO `#__popstil_customizacao_tamanhos` (id_tamanho,id_categoria,largura,altura,estilo,peso,dataAlteracao) VALUES(3,1,'60','60','width: 84px;height: 84px;margin:24px','6.00',now());
INSERT INTO `#__popstil_customizacao_tamanhos` (id_tamanho,id_categoria,largura,altura,estilo,peso,dataAlteracao) VALUES(4,1,'80','80','width: 112px;height: 112px;margin:10px','6.00',now());

INSERT INTO `#__popstil_customizacao_tamanhos` (id_tamanho,id_categoria,largura,altura,estilo,peso,dataAlteracao) VALUES(5,2,'40','30','width: 52px;height: 18px;margin: 48px;','3.50',now());
INSERT INTO `#__popstil_customizacao_tamanhos` (id_tamanho,id_categoria,largura,altura,estilo,peso,dataAlteracao) VALUES(6,2,'50','40','width: 71px;height: 35px;margin: 39px;','3.50',now());
INSERT INTO `#__popstil_customizacao_tamanhos` (id_tamanho,id_categoria,largura,altura,estilo,peso,dataAlteracao) VALUES(7,2,'60','40','width: 99px;height: 61px;margin: 26px;','6.00',now());
INSERT INTO `#__popstil_customizacao_tamanhos` (id_tamanho,id_categoria,largura,altura,estilo,peso,dataAlteracao) VALUES(8,2,'80','60','width: 130px;height: 90px;margin: 10px;','6.00',now());

INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(1,1,now(),550);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(1,2,now(),650);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(1,3,now(),750);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(1,4,now(),840);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(1,5,now(),940);

INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(2,1,now(),570);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(2,2,now(),670);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(2,3,now(),770);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(2,4,now(),860);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(2,5,now(),960);

INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(3,1,now(),690);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(3,2,now(),790);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(3,3,now(),900);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(3,4,now(),990);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(3,5,now(),1090);

INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(4,1,now(),840);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(4,2,now(),940);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(4,3,now(),1040);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(4,4,now(),1140);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(4,5,now(),1240);

INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(5,1,now(),570);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(5,2,now(),670);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(5,3,now(),770);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(5,4,now(),860);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(5,5,now(),960);

INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(6,1,now(),610);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(6,2,now(),710);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(6,3,now(),820);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(6,4,now(),900);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(6,5,now(),1000);

INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(7,1,now(),640);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(7,2,now(),740);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(7,3,now(),840);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(7,4,now(),930);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(7,5,now(),1030);

INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(8,1,now(),770);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(8,2,now(),870);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(8,3,now(),970);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(8,4,now(),1060);
INSERT INTO `#__popstil_customizacao_numeropessoas` (id_tamanho,numero_pessoas,dataAlteracao,preco) VALUES(8,5,now(),1160);

INSERT INTO `#__popstil_customizacao_molduras` (titulo,url_moldura,dataAlteracao) VALUES('Preta','/media/com_popstil/popstilcustomizacao/moldura1_.png',now());
INSERT INTO `#__popstil_customizacao_molduras` (titulo,url_moldura,dataAlteracao) VALUES('Branca','/media/com_popstil/popstilcustomizacao/moldura2_.png',now());





