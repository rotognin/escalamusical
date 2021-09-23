-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 11-Set-2021 às 16:39
-- Versão do servidor: 8.0.21
-- versão do PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `atividades_db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividades_tb`
--

DROP TABLE IF EXISTS `atividades_tb`;
CREATE TABLE IF NOT EXISTS `atividades_tb` (
  `atvID` int NOT NULL AUTO_INCREMENT,
  `atvUsuID` int NOT NULL,
  `atvNome` varchar(100) NOT NULL,
  `atvDescricao` varchar(300) NOT NULL,
  `atvInativo` int NOT NULL,
  `atvStatus` int NOT NULL,
  PRIMARY KEY (`atvID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `horarios_tb`
--

DROP TABLE IF EXISTS `horarios_tb`;
CREATE TABLE IF NOT EXISTS `horarios_tb` (
  `horID` int NOT NULL AUTO_INCREMENT,
  `horAtvID` int NOT NULL,
  `horDataIni` date NOT NULL,
  `horHoraIni` time NOT NULL,
  `horDataFim` date DEFAULT NULL,
  `horHoraFim` time DEFAULT NULL,
  PRIMARY KEY (`horID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_tb`
--

DROP TABLE IF EXISTS `usuarios_tb`;
CREATE TABLE IF NOT EXISTS `usuarios_tb` (
  `usuID` int NOT NULL AUTO_INCREMENT,
  `usuNome` varchar(50) NOT NULL,
  `usuLogin` varchar(20) NOT NULL,
  `usuSenha` varchar(50) NOT NULL,
  `usuSituacao` int NOT NULL,
  PRIMARY KEY (`usuID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
