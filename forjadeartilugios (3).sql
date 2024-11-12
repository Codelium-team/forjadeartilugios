SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `FUA` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `categorias_productos` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `imagenes_mensaje` (
  `id_imagen` int(11) NOT NULL,
  `id_mensaje` int(11) NOT NULL,
  `archivo` varchar(250) NOT NULL,
  `FUA` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `imagenes_productos` (
  `id_imagen` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `archivo` varchar(250) NOT NULL,
  `FUA` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `imagenes_productos` (`id_imagen`, `id_producto`, `archivo`, `FUA`) VALUES
(2, 1, 'assets/img/67169159b947a_forja img.png', '2024-10-21 19:37:29'),
(3, 2, 'assets/img/671694a1e2803_forja img.png', '2024-10-21 19:51:29'),
(4, 3, 'assets/img/671697364589d_forja img.png', '2024-10-21 20:02:30'),
(5, 4, 'assets/img/6716973dac453_forja img.png', '2024-10-21 20:02:37'),
(6, 5, 'assets/img/67169b68c9c2d_forja img.png', '2024-10-21 20:20:24'),
(7, 6, 'assets/img/6716b0ab777d2_cajonart.png', '2024-10-21 21:51:07'),
(8, 7, 'assets/img/6716b97110d6b_cajonart.png', '2024-10-21 22:28:33'),
(9, 8, 'assets/img/6717b00650607_Captura_de_pantalla_2024-10-01_234851.png', '2024-10-22 16:00:38');

CREATE TABLE `mensajes` (
  `id_mensaje` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `asunto` varchar(250) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `texto` text NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `FUA` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre_producto` varchar(50) NOT NULL,
  `descripcion_producto` text NOT NULL,
  `destacado` tinyint(1) NOT NULL,
  `FUA` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `productos` (`id_producto`, `id_usuario`, `nombre_producto`, `descripcion_producto`, `destacado`, `FUA`) VALUES
(1, 1, 'Nombre de Producto', 'Descripción del Producto', 0, '2024-10-21 14:37:29'),
(2, 1, 'Nombre de Producto', 'Descripción del Producto', 0, '2024-10-21 14:51:29'),
(3, 1, 'Nombre de Producto', 'Descripción del Producto', 0, '2024-10-21 15:02:30'),
(4, 1, 'Nombre de Producto', 'Descripción del Producto', 0, '2024-10-21 15:02:37'),
(5, 1, 'Nombre de Producto', 'Descripción del Producto', 0, '2024-10-21 15:20:24'),
(6, 1, 'Nombre de Producto', 'Descripción del Producto', 0, '2024-10-21 16:51:07'),
(7, 1, 'Nombre de Producto', 'Descripción del Producto', 0, '2024-10-21 17:28:33'),
(8, 1, 'Nombre de Producto', 'Descripción del Producto', 0, '2024-10-22 11:00:38');


CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `FUA` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`, `telefono`, `FUA`) VALUES
(1, 'Mauricio Araya', 'mauricioaraya.ib@gmail.com', '123456', '993704038', '2024-10-08 17:17:03');

ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

ALTER TABLE `categorias_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

ALTER TABLE `imagenes_mensaje`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `id_mensaje` (`id_mensaje`);

ALTER TABLE `imagenes_productos`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `id_producto` (`id_producto`);

ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `id_usuario` (`id_usuario`);

ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `categorias_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `imagenes_mensaje`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `imagenes_productos`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `mensajes`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `categorias_productos`
  ADD CONSTRAINT `categorias_productos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `categorias_productos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

ALTER TABLE `imagenes_mensaje`
  ADD CONSTRAINT `imagenes_mensaje_ibfk_1` FOREIGN KEY (`id_mensaje`) REFERENCES `mensajes` (`id_mensaje`);

ALTER TABLE `imagenes_productos`
  ADD CONSTRAINT `imagenes_productos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

CREATE TABLE `productos_relacionados` (
  `id_producto` int(11) NOT NULL,
  `id_producto_relacionado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `productos_relacionados`
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_producto_relacionado` (`id_producto_relacionado`);

ALTER TABLE `productos_relacionados`
  ADD CONSTRAINT `productos_relacionados_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `productos_relacionados_ibfk_2` FOREIGN KEY (`id_producto_relacionado`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;
COMMIT;
