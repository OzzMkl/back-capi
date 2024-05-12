-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 12-05-2024 a las 05:24:06
-- Versión del servidor: 5.7.36
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbcapi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

DROP TABLE IF EXISTS `contactos`;
CREATE TABLE IF NOT EXISTS `contactos` (
  `idContacto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `apellido_paterno` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `apellido_materno` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idContacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

DROP TABLE IF EXISTS `direcciones`;
CREATE TABLE IF NOT EXISTS `direcciones` (
  `idDireccion` int(11) NOT NULL AUTO_INCREMENT,
  `idContactoFk` int(11) NOT NULL,
  `estado` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ciudad` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `colonia` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `calle` varchar(80) COLLATE utf8_spanish2_ci NOT NULL,
  `numero` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `codigo_postal` varchar(5) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idDireccion`),
  KEY `idContactoFk` (`idContactoFk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emails`
--

DROP TABLE IF EXISTS `emails`;
CREATE TABLE IF NOT EXISTS `emails` (
  `idEmail` int(11) NOT NULL AUTO_INCREMENT,
  `idContactoFk` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idEmail`),
  KEY `idContactoFk` (`idContactoFk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefonos`
--

DROP TABLE IF EXISTS `telefonos`;
CREATE TABLE IF NOT EXISTS `telefonos` (
  `idTelefono` int(11) NOT NULL AUTO_INCREMENT,
  `idContactoFk` int(11) NOT NULL,
  `telefono` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`idTelefono`),
  KEY `idContactoFk` (`idContactoFk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `direcciones_ibfk_1` FOREIGN KEY (`idContactoFk`) REFERENCES `contactos` (`idContacto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `emails`
--
ALTER TABLE `emails`
  ADD CONSTRAINT `emails_ibfk_1` FOREIGN KEY (`idContactoFk`) REFERENCES `contactos` (`idContacto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `telefonos`
--
ALTER TABLE `telefonos`
  ADD CONSTRAINT `telefonos_ibfk_1` FOREIGN KEY (`idContactoFk`) REFERENCES `contactos` (`idContacto`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
