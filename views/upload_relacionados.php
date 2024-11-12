<?php
include(__DIR__ . '../../conexiones.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que todos los datos necesarios estén presentes
    if (isset($_FILES['image'], $_POST['id_producto'], $_POST['id_producto_relacionado'])) {
        $id_producto = $_POST['id_producto'];
        $id_producto_relacionado = $_POST['id_producto_relacionado'];
        $image = $_FILES['image'];

        // Verificar si el archivo ha sido cargado correctamente
        if ($image['error'] === UPLOAD_ERR_OK) {
            // Subir la imagen
            $target_dir = "../assets/img/";
            $target_file = $target_dir . basename($image['name']);
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                // Guardar la imagen en la tabla `imagenes_productos`
                $sql = "INSERT INTO imagenes_productos (id_producto, archivo, FUA) VALUES (:id_producto, :archivo, NOW())";
                $stmt = $conn->prepare($sql);
                $stmt->execute(['id_producto' => $id_producto_relacionado, 'archivo' => $target_file]);

                // Asociar los productos en `productos_relacionados`
                $sqlRelacionados = "INSERT INTO productos_relacionados (id_producto, id_producto_relacionado) VALUES (:id_producto, :id_producto_relacionado)";
                $stmtRelacionados = $conn->prepare($sqlRelacionados);
                $stmtRelacionados->execute(['id_producto' => $id_producto, 'id_producto_relacionado' => $id_producto_relacionado]);

                echo "Imagen subida y producto relacionado agregado exitosamente.";
            } else {
                echo "Error al mover la imagen al directorio de destino.";
            }
        } else {
            echo "Error al cargar la imagen: " . $image['error'];
        }
    } else {
        // Mensajes de depuración para identificar campos faltantes
        if (!isset($_FILES['image'])) echo "Campo de imagen no recibido. ";
        if (!isset($_POST['id_producto'])) echo "ID de producto no recibido. ";
        if (!isset($_POST['id_producto_relacionado'])) echo "ID de producto relacionado no recibido. ";
    }
} else {
    // Mostrar el formulario cuando se carga con el método GET
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Subir Imagen Relacionada</title>
    </head>
    <body>
        <form action="upload_relacionados.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_producto" value="1"> <!-- Cambia este valor según el producto -->
            <input type="hidden" name="id_producto_relacionado" value="2"> <!-- Cambia este valor según el producto relacionado -->
            
            <label for="image">Selecciona una imagen:</label>
            <input type="file" name="image" id="image" required>

            <button type="submit">Subir imagen relacionada</button>
        </form>
    </body>
    </html>
    <?php
}
?>
