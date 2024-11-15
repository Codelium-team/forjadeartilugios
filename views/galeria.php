<?php
include(__DIR__ . '../../conexiones.php');

$cmd = $_REQUEST['cmd'] ?? 'get'; // Por defecto, ejecuta 'get' si no se proporciona otro comando.

switch ($cmd) {
    case 'get':
        getImages();
        break;
    default:
        echo "Comando no reconocido";
        break;
}

function getImages() {
    global $conn; // Utiliza la variable de conexión global

    $sql = "SELECT * FROM imagenes_productos"; // Cambia esto si necesitas filtrar por id_producto.
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<h1>Galería de Imágenes</h1>';
    echo '<div class="galeria">';
    foreach ($result as $imagen) {
        // Asegúrate de que el producto está relacionado con la imagen
        $id_producto = $imagen['id_producto']; // Obtén el ID del producto relacionado
        echo '<div class="imagen">';
        echo '<a href="detalle_producto.php?id=' . htmlspecialchars($id_producto) . '">'; // Link al detalle del producto
        echo '<img src="../' . htmlspecialchars($imagen['archivo']) . '" alt="Imagen" style="width:200px;height:150px;">'; // Ajusta el tamaño según sea necesario
        echo '</a>';
        echo '</div>';
    }
    echo '</div>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/galerias.css"> <!-- Asegúrate de que la ruta sea correcta -->
    <title>Galería</title>
</head>
<body>

<div class="header">
                <div class="logo">Mi Tienda</div>
                <nav>
                    <a href="#">Home</a>
                    <a href="#">Catálogo</a>
                    <a href="#">Sobre Nosotros</a>
                    <a href="#">Cotizar</a>
                </nav>
            </div>
    <!-- Aquí va el contenido de las imágenes generado por PHP -->
   
</body>
</html>
