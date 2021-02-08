-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 08-02-2021 a las 11:49:26
-- Versión del servidor: 10.3.25-MariaDB-0ubuntu0.20.04.1
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `codCat` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`codCat`, `nombre`, `descripcion`) VALUES
(1, 'Bebidas', 'Bebidas fresquitas'),
(2, 'Tapas', 'Tapas baratas'),
(3, 'Platos', 'Platos más completos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `codPed` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `enviado` int(11) NOT NULL,
  `restaurante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`codPed`, `fecha`, `enviado`, `restaurante`) VALUES
(1, '2021-02-08', 0, 2),
(2, '2021-02-08', 0, 2),
(3, '2021-02-08', 0, 3),
(4, '2021-02-08', 0, 3),
(5, '2021-02-08', 0, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidoProducto`
--

CREATE TABLE `pedidoProducto` (
  `codPedProd` int(11) NOT NULL,
  `pedido` int(11) NOT NULL,
  `producto` int(11) NOT NULL,
  `unidades` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `pedidoProducto`
--

INSERT INTO `pedidoProducto` (`codPedProd`, `pedido`, `producto`, `unidades`) VALUES
(1, 1, 1, 3),
(2, 2, 2, 3),
(3, 2, 3, 3),
(4, 3, 1, 1),
(5, 3, 5, 4),
(6, 4, 1, 7),
(7, 4, 4, 5),
(8, 5, 1, 7),
(9, 5, 4, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codProd` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(90) COLLATE utf8mb4_spanish_ci NOT NULL,
  `peso` double NOT NULL,
  `stock` int(11) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codProd`, `nombre`, `descripcion`, `peso`, `stock`, `categoria`) VALUES
(1, 'CocaCola', 'CocaCola bien fresquita', 1, 482, 1),
(2, 'FantaNaranja', 'Fanta de naranja', 1, 397, 1),
(3, 'PapasPobre', 'Papas a lo pobre con huevo', 2, 27, 2),
(4, 'Perrito', 'Perrito caliente', 1, 39, 2),
(5, 'EspaguetisPesto', 'Espaguettis al pesto', 2, 36, 3),
(6, 'Risotto', 'Risotto de setas', 2, 35, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurante`
--

CREATE TABLE `restaurante` (
  `codRes` int(11) NOT NULL,
  `correo` varchar(90) COLLATE utf8mb4_spanish_ci NOT NULL,
  `clave` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `pais` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `CP` int(11) NOT NULL,
  `ciudad` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `direccion` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `restaurante`
--

INSERT INTO `restaurante` (`codRes`, `correo`, `clave`, `pais`, `CP`, `ciudad`, `direccion`) VALUES
(1, 'restaurante@correo.es', 'restaurante', 'España', 18015, 'Granada', 'Francisco Ayala'),
(2, 'algsus@correo.es', 'algsus', 'Álgebra', 11100, 'Hilbert', 'Matriz 1'),
(3, 'jesus@trucosuso.com', 'jesus', 'España', 18015, 'Granada', 'Falsa, 123');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`codCat`),
  ADD UNIQUE KEY `UN_NOM_CAT` (`nombre`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`codPed`),
  ADD KEY `Restaurante` (`restaurante`);

--
-- Indices de la tabla `pedidoProducto`
--
ALTER TABLE `pedidoProducto`
  ADD PRIMARY KEY (`codPedProd`),
  ADD KEY `codProd` (`producto`),
  ADD KEY `codPed` (`pedido`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codProd`),
  ADD KEY `Categoria` (`categoria`);

--
-- Indices de la tabla `restaurante`
--
ALTER TABLE `restaurante`
  ADD PRIMARY KEY (`codRes`),
  ADD UNIQUE KEY `UN_RES_COR` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `codCat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `codPed` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pedidoProducto`
--
ALTER TABLE `pedidoProducto`
  MODIFY `codPedProd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `codProd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `restaurante`
--
ALTER TABLE `restaurante`
  MODIFY `codRes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `Restaurante` FOREIGN KEY (`restaurante`) REFERENCES `restaurante` (`codRes`);

--
-- Filtros para la tabla `pedidoProducto`
--
ALTER TABLE `pedidoProducto`
  ADD CONSTRAINT `codPed` FOREIGN KEY (`pedido`) REFERENCES `pedido` (`codPed`),
  ADD CONSTRAINT `codProd` FOREIGN KEY (`producto`) REFERENCES `producto` (`codProd`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `Categoria` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`codCat`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
