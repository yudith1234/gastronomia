-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-05-2023 a las 19:06:15
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `apprestaurant1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `codigo` varchar(5) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(7,2) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `estado` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `codigo`, `nombre`, `descripcion`, `precio`, `foto`, `estado`) VALUES
(1, 'EX', 'chicharron de cerdo', 'Chicharron de Chancho', '20.00', 'chicharron.jpg', 'activado'),
(3, 'cuyet', 'cuy Chactado', 'cuy Chactado cuy Chactado', '12.00', 'cuy-chactado.jpg', 'desactivado'),
(4, 'cuho', 'cuy al horno', 'con papas ,ensalada y rocoto', '30.00', 'C:\\Users\\Evelyn Mercedes\\Downloads/', 'activado'),
(5, 'soch', 'sopa chairo', 'Con tripas de cordero y sarapata', '18.00', 'C:\\Users\\Evelyn Mercedes\\Downloads/', 'desactivado'),
(7, 'supe', 'sopa de pescado', 'con papas sancochadas y ensalada', '20.00', 'C:\\Users\\Evelyn Mercedes\\Downloads/', 'desactivado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `contrasena`, `nombre`, `tipo`) VALUES
(1, 'admin@gmail.com', '1234', 'Juan Perez', 1),
(3, 'torres@gmail.com', 'thor1\r\n', 'Lucas Torres', 1),
(4, 'ala2@gmail.com', 'perro', 'Julio Muñoz', 2),
(9, 'piedras2@gmail.com', 'dino', 'Pedro Picapiedra', 3),
(10, 'ferna2@gmail.com', 'wiss', 'fernando Davila', 3),
(11, 'veda@gmail.com', 'dedo', 'vilma perez', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
