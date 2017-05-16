-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.19-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5169
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for gab
CREATE DATABASE IF NOT EXISTS `gab` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `gab`;

-- Dumping structure for table gab.absence
CREATE TABLE IF NOT EXISTS `absence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_etudiant` int(11) NOT NULL,
  `crn_horaire` varchar(255) NOT NULL,
  `type_absence` varchar(255) NOT NULL,
  `is_old` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_etudiant` (`id_etudiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table gab.absence: ~0 rows (approximately)
/*!40000 ALTER TABLE `absence` DISABLE KEYS */;
/*!40000 ALTER TABLE `absence` ENABLE KEYS */;

-- Dumping structure for table gab.avertissement
CREATE TABLE IF NOT EXISTS `avertissement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `professeur` int(11) NOT NULL,
  `etudiant` int(11) NOT NULL,
  `raison` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `professeur_etudiant` (`professeur`,`etudiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table gab.avertissement: ~0 rows (approximately)
/*!40000 ALTER TABLE `avertissement` DISABLE KEYS */;
/*!40000 ALTER TABLE `avertissement` ENABLE KEYS */;

-- Dumping structure for table gab.element_module
CREATE TABLE IF NOT EXISTS `element_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` int(11) NOT NULL,
  `intitule` varchar(255) NOT NULL,
  `proportion` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module` (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table gab.element_module: ~0 rows (approximately)
/*!40000 ALTER TABLE `element_module` DISABLE KEYS */;
INSERT IGNORE INTO `element_module` (`id`, `module`, `intitule`, `proportion`) VALUES
	(1, 1, 'Algèbre', '');
/*!40000 ALTER TABLE `element_module` ENABLE KEYS */;

-- Dumping structure for table gab.etudiant
CREATE TABLE IF NOT EXISTS `etudiant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `cin` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `cne` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `date_naissance` date NOT NULL,
  `adresse` text NOT NULL,
  `lieu_naissance` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table gab.etudiant: ~0 rows (approximately)
/*!40000 ALTER TABLE `etudiant` DISABLE KEYS */;
INSERT IGNORE INTO `etudiant` (`id`, `id_user`, `cin`, `nom`, `cne`, `prenom`, `date_naissance`, `adresse`, `lieu_naissance`, `telephone`, `email`) VALUES
	(1, 8, 'LE20225', 'Ahannuk', '1122558899', 'Fidaous', '1996-02-11', 'Martil', 'Martil', '06666666', 'ahannuk@gmail.com');
/*!40000 ALTER TABLE `etudiant` ENABLE KEYS */;

-- Dumping structure for table gab.module
CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_module` varchar(255) NOT NULL,
  `nature` varchar(255) NOT NULL,
  `enseigne_par` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `enseigne_par` (`enseigne_par`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table gab.module: ~0 rows (approximately)
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT IGNORE INTO `module` (`id`, `nom_module`, `nature`, `enseigne_par`) VALUES
	(3, 'Math', 'Module scientifique et technique', 1);
/*!40000 ALTER TABLE `module` ENABLE KEYS */;

-- Dumping structure for table gab.professeur
CREATE TABLE IF NOT EXISTS `professeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `som` int(7) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table gab.professeur: ~0 rows (approximately)
/*!40000 ALTER TABLE `professeur` DISABLE KEYS */;
INSERT IGNORE INTO `professeur` (`id`, `id_user`, `som`, `nom`, `prenom`, `email`, `telephone`) VALUES
	(1, 7, 7777777, 'Lionnel', 'Messi', 'messi@gmail.com', '0666552288');
/*!40000 ALTER TABLE `professeur` ENABLE KEYS */;

-- Dumping structure for table gab.utilisateur
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT 'etudiant',
  `active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table gab.utilisateur: ~3 rows (approximately)
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT IGNORE INTO `utilisateur` (`id`, `login`, `password`, `type`, `active`) VALUES
	(1, 'admin', 'password', 'admin', 1),
	(7, 'professeur', 'password', 'professeur', 0),
	(8, 'etudiant', 'password', 'etudiant', 0);
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
