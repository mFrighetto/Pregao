-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 09-Out-2019 às 06:49
-- Versão do servidor: 5.7.23
-- versão do PHP: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pregao`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `editalentidade`
--

CREATE TABLE `editalentidade` (
  `cdEntidade` int(11) NOT NULL,
  `dtAnoProcesso` int(11) NOT NULL,
  `nrPregao` int(11) NOT NULL,
  `dsObjeto` varchar(500) NOT NULL,
  `nrCasasDecimais` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `entidade`
--

CREATE TABLE `entidade` (
  `cdEntidade` int(11) NOT NULL,
  `nmEntidade` varchar(200) NOT NULL,
  `flAplicaBeneficios` tinyint(1) NOT NULL,
  `flFormaBeneficios` tinyint(1) DEFAULT NULL,
  `vlPercentual` float(4,2) DEFAULT NULL,
  `flLocalPrioridadeRegional` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `itemeditalentidade`
--

CREATE TABLE `itemeditalentidade` (
  `cdEntidade` int(11) NOT NULL,
  `dtAnoProcesso` int(11) NOT NULL,
  `nrPregao` int(11) NOT NULL,
  `nrLote` int(11) NOT NULL,
  `nrItem` int(11) NOT NULL,
  `vlQuantidade` float(12,3) NOT NULL,
  `dsUnidade` varchar(4) NOT NULL,
  `dsItem` text NOT NULL,
  `vlUnitario` float(12,4) NOT NULL,
  `tpLote` int(11) NOT NULL,
  `nrLoteCotaPrincipal` int(11) DEFAULT NULL,
  `flPrioridade` tinyint(1) NOT NULL,
  `flSituacao` smallint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `licitanteedital`
--

CREATE TABLE `licitanteedital` (
  `cdEntidade` int(11) NOT NULL,
  `dtAnoProcesso` int(11) NOT NULL,
  `nrPregao` int(11) NOT NULL,
  `nrDocumentoLicitante` varchar(18) NOT NULL,
  `nmLicitante` varchar(100) NOT NULL,
  `flMPE` tinyint(1) NOT NULL,
  `tpAmbito` int(11) NOT NULL,
  `nrDocumentoRepresentante` varchar(14) DEFAULT NULL,
  `nmRepresentante` varchar(100) DEFAULT NULL,
  `flClassificado` smallint(1) DEFAULT '2',
  `dsMotivoDesclassificado` varchar(500) DEFAULT NULL,
  `flHabilitado` smallint(1) DEFAULT '2',
  `dsMotivoInabilitado` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `propostalicitante`
--

CREATE TABLE `propostalicitante` (
  `cdEntidade` int(11) NOT NULL,
  `dtAnoProcesso` int(11) NOT NULL,
  `nrPregao` int(11) NOT NULL,
  `nrLote` int(11) NOT NULL,
  `nrItem` int(11) NOT NULL,
  `nrDocumentoLicitante` varchar(18) NOT NULL,
  `vlProposta` float(12,4) DEFAULT NULL,
  `vlOferta` float(12,4) DEFAULT NULL,
  `dsMarca` varchar(30) DEFAULT NULL,
  `flClassificado` smallint(1) DEFAULT '2',
  `dsMotivoDesclassificado` varchar(500) DEFAULT NULL,
  `flHabilitado` smallint(1) DEFAULT '2',
  `dsMotivoInabilitado` varchar(500) DEFAULT NULL,
  `flVencedor` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `editalentidade`
--
ALTER TABLE `editalentidade`
  ADD PRIMARY KEY (`cdEntidade`,`dtAnoProcesso`,`nrPregao`);

--
-- Indexes for table `entidade`
--
ALTER TABLE `entidade`
  ADD PRIMARY KEY (`cdEntidade`);

--
-- Indexes for table `itemeditalentidade`
--
ALTER TABLE `itemeditalentidade`
  ADD PRIMARY KEY (`cdEntidade`,`dtAnoProcesso`,`nrPregao`,`nrLote`,`nrItem`);

--
-- Indexes for table `licitanteedital`
--
ALTER TABLE `licitanteedital`
  ADD PRIMARY KEY (`cdEntidade`,`dtAnoProcesso`,`nrPregao`,`nrDocumentoLicitante`);

--
-- Indexes for table `propostalicitante`
--
ALTER TABLE `propostalicitante`
  ADD PRIMARY KEY (`cdEntidade`,`dtAnoProcesso`,`nrPregao`,`nrLote`,`nrItem`,`nrDocumentoLicitante`);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `editalentidade`
--
ALTER TABLE `editalentidade`
  ADD CONSTRAINT `editalentidade_ibfk_1` FOREIGN KEY (`cdEntidade`) REFERENCES `entidade` (`cdEntidade`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `itemeditalentidade`
--
ALTER TABLE `itemeditalentidade`
  ADD CONSTRAINT `itemeditalentidade_ibfk_1` FOREIGN KEY (`cdEntidade`,`dtAnoProcesso`,`nrPregao`) REFERENCES `editalentidade` (`cdEntidade`, `dtAnoProcesso`, `nrPregao`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `licitanteedital`
--
ALTER TABLE `licitanteedital`
  ADD CONSTRAINT `licitanteedital_ibfk_1` FOREIGN KEY (`cdEntidade`,`dtAnoProcesso`,`nrPregao`) REFERENCES `editalentidade` (`cdEntidade`, `dtAnoProcesso`, `nrPregao`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `propostalicitante`
--
ALTER TABLE `propostalicitante`
  ADD CONSTRAINT `propostalicitante_ibfk_1` FOREIGN KEY (`cdEntidade`,`dtAnoProcesso`,`nrPregao`,`nrLote`,`nrItem`) REFERENCES `itemeditalentidade` (`cdEntidade`, `dtAnoProcesso`, `nrPregao`, `nrLote`, `nrItem`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
