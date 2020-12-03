-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 02-12-2020 a las 17:53:19
-- Versión del servidor: 10.4.16-MariaDB
-- Versión de PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `GOROVI`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Categorias`
--

CREATE TABLE `Categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `imagen` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `Categorias`
--

INSERT INTO `Categorias` (`id`, `nombre`, `imagen`) VALUES
(5, 'Sombreros', 'imagen.png'),
(8, 'Pantalones', 'imagen.png'),
(11, 'Zapatos', 'imagen.png'),
(12, 'Camisetas', 'imagen.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Productos`
--

CREATE TABLE `Productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `descripcion` varchar(64) DEFAULT NULL,
  `categoria` int(11) NOT NULL,
  `imagen` varchar(16) NOT NULL,
  `precio` double NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `Productos`
--

INSERT INTO `Productos` (`id`, `nombre`, `descripcion`, `categoria`, `imagen`, `precio`, `stock`) VALUES
(3, 'Flanders', 'Sin descripción. ', 5, 'imagen.png', 2, 0),
(4, 'Toporejas', 'Sin descripción. ', 5, 'imagen.png', 4, 0),
(5, 'Tophat', 'Sin descripción. ', 5, 'imagen.png', 2, 0),
(6, 'Silvercrab', 'Sin descripción. ', 8, 'imagen.png', 16, 0),
(7, 'Flamencos', 'Sin descripción. ', 8, 'imagen.png', 8, 0),
(8, 'Payaso', 'Sin descripción. ', 11, 'imagen.png', 10, 0),
(9, 'Alpino', 'Sin descripción. ', 12, 'imagen.png', 4, 0),
(10, 'Invernalia', 'Sin descripción. ', 12, 'imagen.png', 9, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(16) NOT NULL,
  `contraseña` varchar(32) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `apellidos` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `imagen` varchar(16) NOT NULL,
  `rol` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`id`, `usuario`, `contraseña`, `nombre`, `apellidos`, `email`, `imagen`, `rol`) VALUES
(31, 'Javi', '4d186321c1a7f0f354b297e8914ab240', 'Javier', 'Perez Gutierrez', 'javipg@gmail.com', 'imagen.png', 'administrador'),
(41, 'prueba', '81dc9bdb52d04dc20036dbd8313ed055', 'Proban', 'Martinez', 'pmar@correo.com', 'imagen.png', 'cliente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Categorias`
--
ALTER TABLE `Categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `Productos`
--
ALTER TABLE `Productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`,`categoria`) USING BTREE,
  ADD KEY `categoria_productos` (`categoria`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Categorias`
--
ALTER TABLE `Categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `Productos`
--
ALTER TABLE `Productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Productos`
--
ALTER TABLE `Productos`
  ADD CONSTRAINT `categoria_productos` FOREIGN KEY (`categoria`) REFERENCES `Categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
