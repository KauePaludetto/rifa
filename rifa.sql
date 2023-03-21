-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 13-Mar-2023 às 15:59
-- Versão do servidor: 8.0.27
-- versão do PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `rifa`
--

DELIMITER $$
--
-- Procedimentos
--
DROP PROCEDURE IF EXISTS `administrador_alterar`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `administrador_alterar` (IN `_email` VARCHAR(100), IN `_senha` VARCHAR(200), IN `_nome` VARCHAR(200), IN `_telefone` VARCHAR(200))  UPDATE administrador SET
    senha = _senha,
    nome = _nome,
    telefone = _telefone
WHERE
    email = _email$$

DROP PROCEDURE IF EXISTS `administrador_cadastrar`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `administrador_cadastrar` (IN `_email` VARCHAR(100), IN `_senha` VARCHAR(200), IN `_nome` VARCHAR(200), IN `_telefone` VARCHAR(200))  INSERT INTO administrador VALUES(_email, _senha, _nome, _telefone)$$

DROP PROCEDURE IF EXISTS `administrador_consultarPorEmail`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `administrador_consultarPorEmail` (IN `_email` VARCHAR(100))  SELECT * FROM administrador WHERE administrador.email = _email$$

DROP PROCEDURE IF EXISTS `numero_alterarStatus`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `numero_alterarStatus` (IN `fk_Rifa_id` INT, IN `numero` INT, IN `status` INT)  BEGIN
    UPDATE numero set 
    `status` = `status`,
    `hora_atulalizacao` = NOW()
    WHERE 
        fk_Rifa_id = fk_Rifa_id AND numero = numero;

END$$

DROP PROCEDURE IF EXISTS `numero_cadastrar`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `numero_cadastrar` (IN `fk_Rifa_id` INT, IN `numero` INT, IN `cliente` VARCHAR(200))  INSERT INTO numero(`fk_Rifa_id`, `numero`, `status`, `hora_registro`, `hora_atulalizacao`, `cliente`) VALUES (fk_Rifa_id,numero,1,now(),now(),cliente)$$

DROP PROCEDURE IF EXISTS `numero_deletar`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `numero_deletar` (IN `fk_Rifa_id` INT, IN `numero` INT)  DELETE FROM numero WHERE numero.fk_Rifa_id = fk_Rifa_id AND numero.numero = numero$$

DROP PROCEDURE IF EXISTS `numero_listarPorStatus`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `numero_listarPorStatus` (IN `_fk_Rifa_id` INT, IN `_status` INT)  BEGIN
	IF _status <> 0 THEN
   SELECT * FROM numero WHERE numero.fk_Rifa_id = _fk_Rifa_id AND numero.status = _status;
    ELSE
    SELECT * FROM numero WHERE numero.fk_Rifa_id = _fk_Rifa_id;
    END IF;
   
END$$

DROP PROCEDURE IF EXISTS `rifa_alterar`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `rifa_alterar` (IN `id` INT, IN `nome` VARCHAR(200), IN `descricao` VARCHAR(200), IN `imagen_capa` VARCHAR(200), IN `numeros` INT, IN `valor` DOUBLE, IN `data_encerramento` DATETIME)  BEGIN
    UPDATE rifa SET
        nome = nome
        ,descricao = descricao
        ,imagen_capa = imagen_capa
        ,numeros = numeros
        ,valor = valor
        ,data_encerramento = data_encerramento
    WHERE
        rifa.id = id;   
END$$

DROP PROCEDURE IF EXISTS `rifa_cadastrar`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `rifa_cadastrar` (IN `nome` VARCHAR(200), IN `descricao` VARCHAR(200), IN `imagen_capa` VARCHAR(200), IN `numeros` INT, IN `valor` DOUBLE, IN `data_encerramento` DATETIME, IN `fk_Administrador_email` VARCHAR(100))  BEGIN
    INSERT INTO rifa VALUES(
        null
        ,nome
        ,descricao
        ,imagen_capa
        ,numeros
        ,valor
        ,NOW()
        ,data_encerramento
        ,fk_Administrador_email
    );
END$$

DROP PROCEDURE IF EXISTS `rifa_consultarNome`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `rifa_consultarNome` (IN `nome` VARCHAR(100))  SELECT * FROM rifa WHERE rifa.nome LIKE concat('%',nome,'%')$$

DROP PROCEDURE IF EXISTS `rifa_consultarPorData`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `rifa_consultarPorData` (IN `inicio` DATE, IN `termino` DATE)  SELECT * FROM rifa WHERE rifa.data_criacao BETWEEN inicio AND termino$$

DROP PROCEDURE IF EXISTS `rifa_consultarPorId`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `rifa_consultarPorId` (IN `id` INT)  SELECT * FROM rifa WHERE rifa.id = id$$

DROP PROCEDURE IF EXISTS `rifa_deletar`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `rifa_deletar` (IN `id` INT)  BEGIN
    DELETE FROM rifa WHERE rifa.id = id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `administrador`
--

DROP TABLE IF EXISTS `administrador`;
CREATE TABLE IF NOT EXISTS `administrador` (
  `email` varchar(100) NOT NULL,
  `senha` varchar(200) DEFAULT NULL,
  `nome` varchar(200) DEFAULT NULL,
  `telefone` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `administrador`
--

INSERT INTO `administrador` (`email`, `senha`, `nome`, `telefone`) VALUES
('camargoliveira@gmail.com', '$2y$12$oe5Kbg9fi9MG284JhSc9Y.3F2m9TEqj2CEkiVOb10r5Rn.dzXibmK', 'Eliton Camargo de Oliveira', '14996874866'),
('jhonykl@gmail.com', '$2y$12$VNZ809DeRdS3bbI2JmCeruDplTHRvywLd9Q7FM6oXP/lYP45PvYvu', 'Jhony Alex', '159888777');

-- --------------------------------------------------------

--
-- Estrutura da tabela `numero`
--

DROP TABLE IF EXISTS `numero`;
CREATE TABLE IF NOT EXISTS `numero` (
  `fk_Rifa_id` int NOT NULL,
  `numero` int NOT NULL,
  `status` int DEFAULT NULL,
  `hora_registro` datetime DEFAULT NULL,
  `hora_atulalizacao` datetime DEFAULT NULL,
  `cliente` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`fk_Rifa_id`,`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `numero`
--

INSERT INTO `numero` (`fk_Rifa_id`, `numero`, `status`, `hora_registro`, `hora_atulalizacao`, `cliente`) VALUES
(6, 2, 2, '2023-03-09 20:50:49', '2023-03-13 10:13:58', 'Eliton camargo; 324324'),
(6, 4, 2, '2023-03-09 20:51:39', '2023-03-13 10:13:58', 'Eliton camargo; 324324'),
(6, 5, 2, '2023-03-09 20:52:18', '2023-03-13 10:13:58', 'Marcos; 324324'),
(6, 9, 2, '2023-03-09 20:51:49', '2023-03-13 10:13:58', 'Eliton camargo; 324324'),
(7, 1, 2, '2023-03-13 10:07:06', '2023-03-13 10:13:58', 'Eliton Camargo; 14997886655'),
(7, 10, 2, '2023-03-13 10:06:25', '2023-03-13 10:13:58', 'Eliton Camargo; 14997886655'),
(7, 11, 2, '2023-03-13 10:07:01', '2023-03-13 10:13:58', 'Eliton Camargo; 14997886655');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rifa`
--

DROP TABLE IF EXISTS `rifa`;
CREATE TABLE IF NOT EXISTS `rifa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `imagen_capa` varchar(200) DEFAULT NULL,
  `numeros` int DEFAULT NULL,
  `valor` double DEFAULT NULL,
  `data_criacao` datetime NOT NULL,
  `data_encerramento` datetime NOT NULL,
  `fk_Administrador_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Rifa_2` (`fk_Administrador_email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `rifa`
--

INSERT INTO `rifa` (`id`, `nome`, `descricao`, `imagen_capa`, `numeros`, `valor`, `data_criacao`, `data_encerramento`, `fk_Administrador_email`) VALUES
(5, 'a', '', '', 100, 0, '2023-03-09 20:07:51', '0000-00-00 00:00:00', ''),
(6, 's', '', '', 10, 0, '2023-03-09 20:08:03', '0000-00-00 00:00:00', ''),
(7, 'Riafa Jhony', 'Teste Rifa Jhony', 'teste.png', 50, 10, '2023-03-13 10:03:18', '2023-05-10 00:00:00', 'jhonykl@gmail.com');

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `numero`
--
ALTER TABLE `numero`
  ADD CONSTRAINT `FK_Numero_1` FOREIGN KEY (`fk_Rifa_id`) REFERENCES `rifa` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
