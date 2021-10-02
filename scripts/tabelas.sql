CREATE DATABASE `escalamusical_db` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;

CREATE TABLE `escalaintegrantes_tb` (
  `escIntID` int NOT NULL AUTO_INCREMENT,
  `escIntIDGrupo` int NOT NULL,
  `escIntIDIntegrante` int NOT NULL,
  `escIntObservacao` varchar(100) DEFAULT NULL COMMENT 'Exemplo: "Estará usando contrabaixo de 5 cordas", etc...',
  `escIntAtivo` int NOT NULL COMMENT '1 - Ativo\n0 - Inativo',
  PRIMARY KEY (`escIntID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `escalamusicas_tb` (
  `escMusID` int NOT NULL AUTO_INCREMENT,
  `escMusIDGrupo` int NOT NULL,
  `escMusIDMusica` int NOT NULL,
  `escMusObservacao` varchar(100) DEFAULT NULL COMMENT 'Exemplo: "Baixar o tom", "ritmo de rock", "sem bateria", etc',
  `escMusAtivo` int NOT NULL COMMENT '1 - Ativo\n0 - Inativo',
  PRIMARY KEY (`escMusID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `grupos_tb` (
  `gruID` int NOT NULL AUTO_INCREMENT,
  `gruDescricao` varchar(100) NOT NULL,
  `gruObservacoes` varchar(200) DEFAULT NULL,
  `gruData` date DEFAULT NULL,
  `gruHora` time DEFAULT NULL,
  `gruStatus` int NOT NULL COMMENT '1 - Ativo\n0 - Inativo (posso estar montando a escala antes de aparecer a todos)\n2 - Arquivoado (já foi)\n3 - Cancelado',
  PRIMARY KEY (`gruID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `integrantes_tb` (
  `intID` int NOT NULL AUTO_INCREMENT,
  `intNome` varchar(45) NOT NULL,
  `intContato` varchar(100) DEFAULT NULL,
  `intAtivo` int NOT NULL COMMENT '1 - Ativo\n0 - Inativo',
  PRIMARY KEY (`intID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `musicas_tb` (
  `musID` int NOT NULL AUTO_INCREMENT,
  `musNome` varchar(45) NOT NULL,
  `musArtista` varchar(45) DEFAULT NULL,
  `musLink` varchar(200) DEFAULT NULL,
  `musAtivo` int NOT NULL COMMENT '1 - Ativo\n0 - Inativo',
  `musDescricao` varchar(100) DEFAULT NULL COMMENT 'Exemplo: "Versão original", "versão internacional", "outra melodia", etc',
  PRIMARY KEY (`musID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `usuarios_tb` (
  `usuID` int NOT NULL AUTO_INCREMENT,
  `usuNome` varchar(50) NOT NULL,
  `usuLogin` varchar(20) NOT NULL,
  `usuSenha` varchar(50) NOT NULL,
  `usuSituacao` int NOT NULL,
  PRIMARY KEY (`usuID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `categorias_tb` (
  `catID` int NOT NULL AUTO_INCREMENT,
  `catNome` varchar(20) NOT NULL,
  `catDescricao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`catID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;