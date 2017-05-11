-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Lug 01, 2016 alle 11:50
-- Versione del server: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `managerdb`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `clienti`
--

CREATE TABLE IF NOT EXISTS `clienti` (
`idCliente` int(11) NOT NULL,
  `codCliente` varchar(30) NOT NULL,
  `ragSociale` varchar(60) NOT NULL,
  `citta` varchar(30) DEFAULT NULL,
  `indirizzo` varchar(50) DEFAULT NULL,
  `provincia` varchar(2) DEFAULT NULL,
  `comune` varchar(50) DEFAULT NULL,
  `CAP` varchar(10) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `pIva` varchar(20) DEFAULT NULL,
  `CF` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `detrazioni`
--

CREATE TABLE IF NOT EXISTS `detrazioni` (
`idDetrazione` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `importo` double NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `entrate`
--

CREATE TABLE IF NOT EXISTS `entrate` (
`idEntrata` int(11) NOT NULL,
  `dataFattura` date NOT NULL,
  `voce` varchar(60) NOT NULL,
  `importo` double NOT NULL,
  `dataPagamento` date NOT NULL,
  `fatto` tinyint(1) NOT NULL,
  `fkCliente` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `nomeuscita`
--

CREATE TABLE IF NOT EXISTS `nomeuscita` (
  `nome` varchar(40) NOT NULL,
  `colore` varchar(20) NOT NULL,
  `categoria` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `tipouscita`
--

CREATE TABLE IF NOT EXISTS `tipouscita` (
  `categoria` varchar(30) NOT NULL,
  `colore` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `tipo_detrazioni`
--

CREATE TABLE IF NOT EXISTS `tipo_detrazioni` (
  `nomeDet` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `uscite`
--

CREATE TABLE IF NOT EXISTS `uscite` (
`idUscita` int(11) NOT NULL,
  `dataFattura` date NOT NULL,
  `voce` varchar(60) NOT NULL,
  `importo` double NOT NULL,
  `dataPagamento` date NOT NULL,
  `categoria` varchar(30) NOT NULL,
  `fatta` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`idUser` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `cognome` varchar(60) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `citta` varchar(30) DEFAULT NULL,
  `indirizzo` varchar(50) DEFAULT NULL,
  `provincia` varchar(2) DEFAULT NULL,
  `CAP` varchar(10) DEFAULT NULL,
  `comune` varchar(50) DEFAULT NULL,
  `cellulare` varchar(10) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `pIva` varchar(20) DEFAULT NULL,
  `CF` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clienti`
--
ALTER TABLE `clienti`
 ADD PRIMARY KEY (`idCliente`);

--
-- Indexes for table `detrazioni`
--
ALTER TABLE `detrazioni`
 ADD PRIMARY KEY (`idDetrazione`);

--
-- Indexes for table `entrate`
--
ALTER TABLE `entrate`
 ADD PRIMARY KEY (`idEntrata`), ADD KEY `fkCliente` (`fkCliente`);

--
-- Indexes for table `nomeuscita`
--
ALTER TABLE `nomeuscita`
 ADD PRIMARY KEY (`nome`), ADD KEY `categoria` (`categoria`);

--
-- Indexes for table `tipouscita`
--
ALTER TABLE `tipouscita`
 ADD PRIMARY KEY (`categoria`);

--
-- Indexes for table `tipo_detrazioni`
--
ALTER TABLE `tipo_detrazioni`
 ADD PRIMARY KEY (`nomeDet`);

--
-- Indexes for table `uscite`
--
ALTER TABLE `uscite`
 ADD PRIMARY KEY (`idUscita`), ADD KEY `categoria` (`categoria`), ADD KEY `voce` (`voce`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clienti`
--
ALTER TABLE `clienti`
MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `detrazioni`
--
ALTER TABLE `detrazioni`
MODIFY `idDetrazione` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `entrate`
--
ALTER TABLE `entrate`
MODIFY `idEntrata` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `uscite`
--
ALTER TABLE `uscite`
MODIFY `idUscita` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `entrate`
--
ALTER TABLE `entrate`
ADD CONSTRAINT `Entrate_ibfk_1` FOREIGN KEY (`fkCliente`) REFERENCES `clienti` (`idCliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `nomeuscita`
--
ALTER TABLE `nomeuscita`
ADD CONSTRAINT `NomeUscita_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `tipouscita` (`categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `uscite`
--
ALTER TABLE `uscite`
ADD CONSTRAINT `Uscite_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `tipouscita` (`categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `Uscite_ibfk_2` FOREIGN KEY (`voce`) REFERENCES `nomeuscita` (`nome`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
