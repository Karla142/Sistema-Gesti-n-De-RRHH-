-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-10-2025 a las 00:00:40
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_horarios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bloques_completo`
--

CREATE TABLE `bloques_completo` (
  `id` int(11) NOT NULL,
  `horario_id` int(11) DEFAULT NULL,
  `dia` varchar(20) DEFAULT NULL,
  `bloque_hora` varchar(20) DEFAULT NULL,
  `nivel` varchar(50) DEFAULT NULL,
  `seccion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `bloques_completo`
--

INSERT INTO `bloques_completo` (`id`, `horario_id`, `dia`, `bloque_hora`, `nivel`, `seccion`) VALUES
(11, 31, 'Lunes', '7:00 am', '1° Grado', 'A'),
(12, 31, 'Martes', '7:00 am', '1° Grado', 'A'),
(13, 31, 'Miércoles', '9:00 am', '1° Grado', 'A'),
(14, 31, 'Jueves', '9:30 am', '1° Grado', 'A'),
(15, 31, 'Viernes', '8:50 am', '1° Grado', 'A'),
(16, 32, 'Lunes', '7:00 am', '5° Año', 'A'),
(17, 32, 'Martes', '7:00 am', '5° Año', 'A'),
(18, 32, 'Miércoles', '9:00 am', '5° Año', 'A'),
(19, 32, 'Jueves', '9:30 am', '5° Año', 'A'),
(20, 32, 'Viernes', '8:50 am', '5° Año', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bloques_parcial`
--

CREATE TABLE `bloques_parcial` (
  `id` int(11) NOT NULL,
  `horario_id` int(11) DEFAULT NULL,
  `dia` varchar(20) DEFAULT NULL,
  `hora` varchar(20) DEFAULT NULL,
  `nivel` varchar(50) DEFAULT NULL,
  `seccion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `bloques_parcial`
--

INSERT INTO `bloques_parcial` (`id`, `horario_id`, `dia`, `hora`, `nivel`, `seccion`) VALUES
(18, 30, 'Miércoles', '8:00 am a 10:00 am', '1° nivel', 'A'),
(19, 30, 'Jueves', '8:00 am a 11:00 am', '2° nivel', 'A'),
(20, 30, 'Viernes', '8:00 am a 10:00 am', '3° nivel', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `cedula` varchar(20) DEFAULT NULL,
  `materia_id` int(11) DEFAULT NULL,
  `tipo` enum('parcial','tiempo_completo') NOT NULL,
  `total_horas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id`, `cedula`, `materia_id`, `tipo`, `total_horas`) VALUES
(30, 'V-31500713', 18, 'parcial', 7),
(31, 'V-31500713', 25, 'tiempo_completo', NULL),
(32, 'V-31500719', 28, 'tiempo_completo', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `nombre`) VALUES
(23, 'Biología'),
(19, 'Ciencias naturales'),
(18, 'Ciencias sociales'),
(22, 'Comunicación y representación'),
(27, 'CRP'),
(24, 'Educación física'),
(25, 'Física'),
(15, 'Formación personal y social'),
(16, 'Informática'),
(20, 'Inglés'),
(21, 'Manos a la siembra'),
(17, 'Matemática'),
(28, 'Proyecto'),
(26, 'Química');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `cedula` varchar(20) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `cargo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`cedula`, `nombre`, `apellido`, `cargo`) VALUES
('V-31500713', 'Karla', 'Calcurian', 'Maestra'),
('V-31500719', 'Karina', 'Calcurian', 'Profesora');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bloques_completo`
--
ALTER TABLE `bloques_completo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `horario_id` (`horario_id`);

--
-- Indices de la tabla `bloques_parcial`
--
ALTER TABLE `bloques_parcial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `horario_id` (`horario_id`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materia_id` (`materia_id`),
  ADD KEY `idx_cedula` (`cedula`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`cedula`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bloques_completo`
--
ALTER TABLE `bloques_completo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `bloques_parcial`
--
ALTER TABLE `bloques_parcial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bloques_completo`
--
ALTER TABLE `bloques_completo`
  ADD CONSTRAINT `bloques_completo_ibfk_1` FOREIGN KEY (`horario_id`) REFERENCES `horarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `bloques_parcial`
--
ALTER TABLE `bloques_parcial`
  ADD CONSTRAINT `bloques_parcial_ibfk_1` FOREIGN KEY (`horario_id`) REFERENCES `horarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `fk_cedula` FOREIGN KEY (`cedula`) REFERENCES `personal` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `horarios_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `personal` (`cedula`),
  ADD CONSTRAINT `horarios_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
