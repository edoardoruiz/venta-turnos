-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2023 a las 17:13:25
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `venta-turnos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno`
--

CREATE TABLE `turno` (
  `ID` int(11) NOT NULL,
  `Turno` varchar(100) NOT NULL,
  `Precio` decimal(10,0) NOT NULL,
  `Disponibilidad` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `turno`
--

INSERT INTO `turno` (`ID`, `Turno`, `Precio`, `Disponibilidad`) VALUES
(1, 'Honor Salida', 200, 44),
(2, 'Turno 1', 25, 44),
(3, 'Turno 2', 25, 44),
(4, 'Extraordinario Catedral', 100, 44),
(5, 'Extraordinario Portal', 60, 44),
(6, 'Extraordinario Entre Parques', 60, 44),
(7, 'Extraordinario Palacio I', 60, 44),
(8, 'Extraordinario Palacio II', 60, 44),
(9, 'Turno 8', 25, 44),
(10, 'Turno 9', 25, 44),
(11, 'Turno 10', 25, 44),
(12, 'Turno 11', 25, 44),
(13, 'Turno 12', 25, 44),
(14, 'Turno 13', 25, 44),
(15, 'Turno 14', 25, 44),
(16, 'Turno 15', 25, 44),
(17, 'Turno 16', 25, 44),
(18, 'Turno 17', 25, 44),
(19, 'Extraordinario Isabel La Católica', 60, 44),
(20, 'Turno 19', 25, 44),
(21, 'Turno 20', 25, 44),
(22, 'Turno 21', 25, 44),
(23, 'Turno 22', 25, 44),
(24, 'Extraordinario La Merced', 60, 44),
(25, 'Turno 24', 25, 44),
(26, 'Turno 25', 25, 44),
(27, 'Turno 26', 25, 44),
(28, 'Honor Entrada', 200, 44);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
