<?php
// Conexión a la base de datos
$host = 'localhost';
$dbname = 'forjadeartilugios';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}

// Procesamiento del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fua = date('Y-m-d H:i:s');

    // Comprobar si se ha subido un archivo
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $archivo_tmp = $_FILES['archivo']['tmp_name'];
        $nombre_archivo = basename($_FILES['archivo']['name']);
        $directorio_destino = 'assets/img/';  // Guardar en assets/img/

        // Crear el directorio si no existe
        if (!is_dir($directorio_destino)) {
            mkdir($directorio_destino, 0755, true);
        }

        // Generar una ruta única para evitar colisiones
        $ruta_destino = $directorio_destino . uniqid() . '_' . $nombre_archivo;

        // Mover el archivo subido al directorio final
        if (move_uploaded_file($archivo_tmp, $ruta_destino)) {
            // Insertar referencia en la base de datos
            $sql = "INSERT INTO productos (id_usuario, nombre_producto, descripcion_producto, destacado, FUA) 
                    VALUES (:id_usuario, :nombre_producto, :descripcion_producto, :destacado, NOW())";

            // Asegúrate de tener estas variables en algún lugar de tu código o puedes obtenerlas de otra manera
            $id_usuario = 1; // Cambia esto según tu lógica
            $nombre_producto = 'Nombre de Producto'; // Cambia esto según tu lógica
            $descripcion_producto = 'Descripción del Producto'; // Cambia esto según tu lógica
            $destacado = 0; // O 1, según sea necesario

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':nombre_producto', $nombre_producto, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion_producto', $descripcion_producto, PDO::PARAM_STR);
            $stmt->bindParam(':destacado', $destacado, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Obtener el ID del último producto insertado
                $id_producto = $pdo->lastInsertId();

                // Ahora, insertar la imagen con el ID del producto
                $sql_imagen = "INSERT INTO imagenes_productos (id_producto, archivo, FUA) 
                               VALUES (:id_producto, :archivo, :fua)";
                $stmt_imagen = $pdo->prepare($sql_imagen);
                $stmt_imagen->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
                $stmt_imagen->bindParam(':archivo', $ruta_destino, PDO::PARAM_STR);
                $stmt_imagen->bindParam(':fua', $fua, PDO::PARAM_STR);

                if ($stmt_imagen->execute()) {
                    echo "Imagen subida y guardada correctamente.";
                } else {
                    echo "Error al guardar la imagen en la base de datos.";
                }
            } else {
                echo "Error al guardar el producto en la base de datos.";
            }
        } else {
            echo "Error al mover el archivo al directorio de destino.";
        }
    } else {
        // Mostrar el código de error para depuración
        echo "Error en la subida de archivo. Código de error: " . $_FILES['archivo']['error'];
    }
}
?>
