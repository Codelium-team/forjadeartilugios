<?php
include(__DIR__ . '../../conexiones.php');

$id_producto = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_producto === 0) {
    header("Location: galeria.php");
    exit();
}

$cmd = 'get';
$producto = json_decode(file_get_contents("http://localhost/miphp/forjadeartilugios/controllers/productos.php?cmd=$cmd&id=$id_producto"), true);
$imagenes = getImagesByProductId($id_producto); // Llama a la función para obtener imágenes

function getImagesByProductId($id_producto) {
    global $conn;
    $sql = "SELECT * FROM imagenes_productos WHERE id_producto = :id_producto";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_producto', $id_producto);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/galeria.css"> <!-- Asegúrate de que la ruta sea correcta -->

    <title>Detalle del Producto</title>

    <style>
        .detalle-producto {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }
        .detalle-producto img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<?php if (!empty($producto)): ?>
    <div class="detalle-producto">
        <?php foreach ($imagenes as $img): ?>
            <img src="../<?= htmlspecialchars($img['archivo']) ?>" alt="Imagen del Producto">
        <?php endforeach; ?>
        <h2><?= htmlspecialchars($producto[0]['nombre_producto']) ?></h2>
        <p><?= htmlspecialchars($producto[0]['descripcion_producto']) ?></p>
    </div>
<?php else: ?>
    <p>Producto no encontrado.</p>
<?php endif; ?>

</body>
</html>
