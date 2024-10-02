-- Tabla productos
DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int PRIMARY KEY NOT NULL,
  `nombre_producto` varchar(50) NOT NULL,
  `descripcion_producto` text NOT NULL,
  `destacado` boolean NOT NULL,
  `FUA` datetime NOT NULL
);

-- Tabla categorias_productos
DROP TABLE IF EXISTS `categorias_productos`;
CREATE TABLE IF NOT EXISTS `categorias_productos` (
  `id` int PRIMARY KEY NOT NULL,
  `id_producto` int NOT NULL,
  `id_categoria` int NOT NULL
);

-- Tabla categorias
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int PRIMARY KEY NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `FUA` datetime NOT NULL
);

-- Tabla imagenes_productos
DROP TABLE IF EXISTS `imagenes_productos`;
CREATE TABLE IF NOT EXISTS `imagenes_productos` (
  `id_imagen` int PRIMARY KEY NOT NULL,
  `id_producto` int NOT NULL,
  `archivo` varchar(250) NOT NULL,
  `FUA` datetime NOT NULL
);

-- Tabla mensajes
DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int PRIMARY KEY NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `texto` text NOT NULL,
  `estado` boolean NOT NULL
);

-- Tabla imagenes_mensaje
DROP TABLE IF EXISTS `imagenes_mensaje`;
CREATE TABLE IF NOT EXISTS `imagenes_mensaje` (
  `id_imagen` int PRIMARY KEY NOT NULL,
  `id_mensaje` int NOT NULL,
  `archivo` varchar(250) NOT NULL,
  `FUA` datetime NOT NULL
);

-- Tabla usuarios
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int PRIMARY KEY NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `FUA` datetime NOT NULL
);

--llaves foráneas
ALTER TABLE `categorias_productos` ADD FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);
ALTER TABLE `categorias_productos` ADD FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
ALTER TABLE `imagenes_productos` ADD FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);
ALTER TABLE `imagenes_mensaje` ADD FOREIGN KEY (`id_mensaje`) REFERENCES `mensajes` (`id_mensaje`);