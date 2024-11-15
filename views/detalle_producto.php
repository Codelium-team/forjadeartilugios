<?php
include(__DIR__ . '../../conexiones.php');

// Obtener el ID del producto desde el parámetro GET
$id_producto = $_GET['id'] ?? null;

if ($id_producto) {
    // Consultar los detalles del producto
    $sqlProducto = "SELECT * FROM productos WHERE id_producto = :id_producto";
    $stmtProducto = $conn->prepare($sqlProducto);
    $stmtProducto->execute(['id_producto' => $id_producto]);
    $producto = $stmtProducto->fetch(PDO::FETCH_ASSOC);

    // Consultar la imagen principal y otras imágenes del producto
    $sqlImagenes = "SELECT archivo FROM imagenes_productos WHERE id_producto = :id_producto";
    $stmtImagenes = $conn->prepare($sqlImagenes);
    $stmtImagenes->execute(['id_producto' => $id_producto]);
    $imagenes = $stmtImagenes->fetchAll(PDO::FETCH_ASSOC);

    if ($producto && $imagenes) {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Detalles del Producto</title>
            <link rel="stylesheet" href="../assets/css/detalle.css"> 
            <style>
                body {
                    font-family: Arial, sans-serif;
                }
                .header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 10px 20px;
                    background-color: #f8f8f8;
                    border-bottom: 1px solid #ddd;
                }
                .header .logo {
                    font-size: 24px;
                    font-weight: bold;
                }
                .header nav a {
                    margin: 0 10px;
                    text-decoration: none;
                    color: #333;
                }
                .container {
                    display: flex;
                    max-width: 1200px;
                    margin: 20px auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    background-color: #fff;
                }
                .images {
                    flex: 1;
                    margin-right: 20px;
                }
                .images img {
                    width: 100%;
                    max-height: 400px;
                    object-fit: cover;
                    margin-bottom: 10px;
                }
                .thumbnails {
                    display: flex;
                    justify-content: space-between;
                }
                .thumbnails img {
                    width: 24%;
                    cursor: pointer;
                }
                .details {
                    flex: 1;
                }
                .details h2 {
                    margin-top: 0;
                }
                .details p {
                    margin: 10px 0;
                }
                .contact-button {
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #000;
                    color: #fff;
                    text-decoration: none;
                    margin-top: 20px;
                }
            </style>
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
            <div class="container">
                <div class="images">
                    <?php if (!empty($imagenes)): ?>
                        <img src="../<?= htmlspecialchars($imagenes[0]['archivo']) ?>" alt="Imagen del Producto">
                        <div class="thumbnails">
                            <?php foreach ($imagenes as $key => $img): ?>
                                <?php if ($key > 0): // Saltar la primera imagen ya que es la imagen principal ?>
                                    <img src="../<?= htmlspecialchars($img['archivo']) ?>" alt="Miniatura del Producto">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="details">
                    <?php if (!empty($producto)): ?>
                        <h2><?= htmlspecialchars($producto['nombre_producto']) ?></h2>
                        <p><?= htmlspecialchars($producto['descripcion_producto']) ?></p>
                        <a href="#" class="contact-button">Contacto</a>
                    <?php else: ?>
                        <p>Producto no encontrado.</p>
                    <?php endif; ?>
                </div>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo 'Producto no encontrado o sin imagen disponible.';
    }
} else {
    echo 'ID de producto no especificado.';
}
?>
