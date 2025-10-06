-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-10-2025 a las 00:00:00
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
-- Base de datos: `base_kam`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `id_personal` int(11) NOT NULL,
  `cedula_personal` varchar(15) NOT NULL,
  `fecha_asistencia` date NOT NULL,
  `hora_entrada` time DEFAULT NULL,
  `hora_salida` time DEFAULT NULL,
  `tipo_asistencia` enum('manual','huella') DEFAULT 'manual',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `plantilla_huella` longtext DEFAULT NULL,
  `estado_asistencia` enum('confirmada','pendiente','rechazada') DEFAULT 'pendiente',
  `id_sesion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombre_usuario` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `accion` varchar(255) NOT NULL,
  `fecha_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id`, `usuario_id`, `nombre_usuario`, `correo`, `accion`, `fecha_hora`) VALUES
(59, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-03-24 13:30:05'),
(60, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-03-24 13:37:46'),
(61, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-03-24 13:42:36'),
(62, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-03-24 19:01:51'),
(63, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-03-24 19:20:24'),
(64, 24, 'Marianny', 'marian@gmail.com', 'Inicio de sesiÃ³n', '2025-03-25 01:38:45'),
(65, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-03-25 03:59:37'),
(66, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-03-25 08:37:24'),
(67, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-03-25 08:43:35'),
(68, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-03-26 17:12:37'),
(69, 25, 'karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-03-26 17:32:06'),
(70, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-03-26 18:42:44'),
(71, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-03-26 22:32:19'),
(72, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-03-27 16:30:09'),
(73, 23, 'Alexandra', 'xandrapini@gmail.com', 'Inicio de sesiÃ³n', '2025-03-27 18:41:59'),
(74, 24, 'Marianny', 'marian@gmail.com', 'Inicio de sesiÃ³n', '2025-03-27 18:42:44'),
(75, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-03-27 18:43:32'),
(77, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-03-31 20:49:47'),
(79, 25, 'Karla', 'karlaad142@gmail.com', 'Añadio personal ', '2025-03-31 20:55:26'),
(80, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-01 19:15:47'),
(81, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-02 20:34:26'),
(82, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-02 20:34:27'),
(83, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-02 20:34:28'),
(84, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-02 20:34:28'),
(85, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-02 20:34:29'),
(86, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-02 20:34:29'),
(87, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-02 20:34:30'),
(88, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-02 20:37:21'),
(89, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-03 19:32:37'),
(90, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-07 20:39:07'),
(91, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-07 21:56:01'),
(92, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-07 22:03:35'),
(93, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-08 10:20:27'),
(94, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-09 09:57:31'),
(95, 25, 'Karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-09 09:57:33'),
(96, 25, 'karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-09 11:34:04'),
(97, 25, 'karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-09 11:34:07'),
(98, 25, 'karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-09 11:34:13'),
(99, 25, 'karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-09 11:34:14'),
(100, 25, 'karla', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-04-09 11:34:14'),
(101, 23, 'Alexandra', 'xandrapini@gmail.com', 'Inicio de sesiÃ³n', '2025-06-02 22:27:04'),
(102, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-06-06 10:19:51'),
(103, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-06-07 20:15:42'),
(104, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-06-11 17:58:49'),
(105, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-06-13 19:37:01'),
(106, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-06-13 19:37:18'),
(107, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-06-16 13:55:13'),
(108, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-06-18 17:49:38'),
(109, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-06-23 11:13:49'),
(110, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-07-03 11:41:16'),
(111, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-07-10 20:46:41'),
(112, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-07-10 20:46:43'),
(113, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-07-13 22:57:05'),
(114, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-07-14 19:05:42'),
(115, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-07-14 19:06:03'),
(116, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-07-24 11:25:28'),
(117, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesiÃ³n', '2025-07-24 15:26:26'),
(118, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-09-23 17:27:01'),
(119, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-09-24 17:49:36'),
(120, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-10-01 12:10:12'),
(121, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-10-02 23:27:43'),
(122, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-10-03 01:08:05'),
(123, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-10-03 06:42:09'),
(124, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-10-03 07:18:26'),
(125, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-10-03 17:31:11'),
(126, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-10-03 17:31:12'),
(127, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-10-03 17:31:14'),
(128, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-10-03 17:31:15'),
(129, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-10-03 17:31:15'),
(130, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-10-03 17:31:16'),
(131, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-10-03 17:31:17'),
(132, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-10-03 17:31:17'),
(133, 25, 'kil', 'karlaad142@gmail.com', 'Inicio de sesión', '2025-10-03 17:31:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id` int(100) NOT NULL,
  `codigo_cargo` text NOT NULL,
  `nombre_cargo` text NOT NULL,
  `descripcion_cargo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grado y seccion`
--

CREATE TABLE `grado y seccion` (
  `id` int(100) NOT NULL,
  `codigo_grado_seccion` text NOT NULL,
  `nombre_grado_seccion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_personal` int(11) NOT NULL,
  `cedula_personal` varchar(50) NOT NULL,
  `fecha_permiso` date NOT NULL,
  `Tipo_reposo` int(50) NOT NULL,
  `Descripcion` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_modulos`
--

CREATE TABLE `permisos_modulos` (
  `id` int(11) NOT NULL,
  `nivel_usuario` varchar(50) NOT NULL,
  `modulo` varchar(100) NOT NULL,
  `permitido` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `permisos_modulos`
--

INSERT INTO `permisos_modulos` (`id`, `nivel_usuario`, `modulo`, `permitido`) VALUES
(1, 'Administrador', 'PERSONAL.php', 1),
(2, 'Administrador', 'asistencia.php', 1),
(3, 'Administrador', 'horarios.php', 1),
(4, 'Administrador', 'MODULOS_REPORTES.php', 1),
(5, 'Administrador', 'formato.php', 1),
(6, 'Administrador', 'ayuda.php', 1),
(7, 'Administrador', 'mantenibilidad.php', 1),
(8, 'Secretaria', 'MODULOS_REPORTES.php', 1),
(9, 'Secretaria', 'formato.php', 1),
(10, 'RRHH', 'PERSONAL.php', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id_personal` int(11) NOT NULL,
  `nombre_personal` varchar(255) NOT NULL,
  `apellido_personal` varchar(255) NOT NULL,
  `cedula_personal` varchar(50) NOT NULL,
  `titulo_personal` varchar(255) NOT NULL,
  `correo_personal` varchar(255) NOT NULL,
  `nacimiento_personal` date NOT NULL,
  `ingreso_personal` date NOT NULL,
  `cargo_personal` varchar(255) NOT NULL,
  `huella_dactilar` mediumblob NOT NULL,
  `nacionalidad_personal` varchar(100) DEFAULT NULL,
  `tipo` enum('Parcial','Tiempo Completo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id_personal`, `nombre_personal`, `apellido_personal`, `cedula_personal`, `titulo_personal`, `correo_personal`, `nacimiento_personal`, `ingreso_personal`, `cargo_personal`, `huella_dactilar`, `nacionalidad_personal`, `tipo`) VALUES
(92, 'Karla', 'Calcurian', 'V-31500713', '', 'karlaad142@gmail.com', '2005-12-13', '2025-03-22', 'Maestra', '', NULL, 'Parcial'),
(93, 'Karina', 'Calcurian', 'V-31500712', '', 'karlaad142@gmail.com', '2005-12-13', '2025-03-22', 'Prof.Biologia', '', NULL, 'Parcial'),
(94, 'Karina', 'Calcurian', 'V-31500717', '', 'karlaad142@gmail.com', '2005-12-13', '2025-03-22', 'Profesor', '', NULL, 'Parcial'),
(95, 'Karina', 'Calcurian', 'V-31500719', '', 'karlaad142@gmail.com', '2005-12-13', '2025-03-22', 'Profesora', '', NULL, 'Parcial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `nivel_usuario` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `token_recuperacion` varchar(64) DEFAULT NULL,
  `expiracion_token` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `nivel_usuario`, `correo`, `contrasena`, `token_recuperacion`, `expiracion_token`) VALUES
(25, 'kil', 'administrador', 'karlaad142@gmail.com', '$2y$10$grbt7MQtLm1sPLvj39erYu/H248tzD62B2PeqVK0Bwtt9DQp2Jy2m', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_roles`
--

CREATE TABLE `usuario_roles` (
  `usuario_id` int(11) DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id_personal`),
  ADD UNIQUE KEY `cedula_personal` (`cedula_personal`,`fecha_asistencia`,`hora_entrada`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`codigo_cargo`(50));

--
-- Indices de la tabla `grado y seccion`
--
ALTER TABLE `grado y seccion`
  ADD PRIMARY KEY (`codigo_grado_seccion`(50));

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_personal`);

--
-- Indices de la tabla `permisos_modulos`
--
ALTER TABLE `permisos_modulos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id_personal`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario_roles`
--
ALTER TABLE `usuario_roles`
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id_personal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_personal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos_modulos`
--
ALTER TABLE `permisos_modulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_personal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuario_roles`
--
ALTER TABLE `usuario_roles`
  ADD CONSTRAINT `usuario_roles_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
