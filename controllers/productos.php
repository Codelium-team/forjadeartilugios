<?php 

include(__DIR__.'../../conexiones.php');

$cmd = $_SERVER['REQUEST_METHOD'];
$id = $_REQUEST['id'];

switch ($cmd) {
    case 'GET':
        if(isset($id)) {
            getProductById($conn, $id);
        } else {
            getProducts($conn);
        }
        break;
    case 'POST':
        postProduct($conn);
        break;
    case 'PUT':
        updateProduct($conn, $id);
    case 'DELETE':
        deleteProduct($conn, $id);
        break;
    default:
        echo "Comando no reconocido";
        break;
}
function getProductById($conn, $id_producto) {
    $sqlProducto = "SELECT * FROM productos WHERE id_producto = :id_producto";
    $stmtProducto = $conn->prepare($sqlProducto);
    $stmtProducto->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
    $stmtProducto->execute();
    $producto = $stmtProducto->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        echo json_encode(['error' => 'Producto no encontrado']);
        return;
    }


    $sqlImagenes = "SELECT * FROM imagenes_productos WHERE id_producto = :id_producto";
    $stmtImagenes = $conn->prepare($sqlImagenes);
    $stmtImagenes->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
    $stmtImagenes->execute();
    $imagenes = $stmtImagenes->fetchAll(PDO::FETCH_ASSOC);

    $producto['imagenes'] = [];
    foreach ($imagenes as $imagen) {
        $producto['imagenes'][] = [
            'id_imagen' => $imagen['id_imagen'],
            'archivo' => $imagen['archivo'],
            'principal' => $imagen['principal']
        ];
    }
    echo json_encode($producto);
}
function getProducts($conn) {

    $sqlProductos = "SELECT * FROM productos";
    $stmtProductos = $conn->prepare($sqlProductos);
    $stmtProductos->execute();
    $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);

    $sqlImagenes = "SELECT * FROM imagenes_productos";
    $stmtImagenes = $conn->prepare($sqlImagenes);
    $stmtImagenes->execute();
    $imagenes = $stmtImagenes->fetchAll(PDO::FETCH_ASSOC);

    $imagenesPorProducto = [];
    foreach ($imagenes as $imagen) {
        $idProducto = $imagen['id_producto'];
        if (!isset($imagenesPorProducto[$idProducto])) {
            $imagenesPorProducto[$idProducto] = [];
        }
        $imagenesPorProducto[$idProducto][] = [
            'id_imagen' => $imagen['id_imagen'],
            'archivo' => $imagen['archivo'],
            'principal' => $imagen['principal']
        ];
    }

    foreach ($productos as &$producto) {
        $productoId = $producto['id_producto'];
        $producto['imagenes'] = $imagenesPorProducto[$productoId] ?? [];
    }

    echo json_encode($productos);
}

function postProduct($conn) {
    $usuario = $_POST['id_usuario'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $destacado = $_POST['destacado'];
    $categorias = $_POST['categorias'];
    $imagenes = $_POST['imagenes'];

    $sql = "INSERT INTO productos (id_usuario,nombre_producto, descripcion_producto, destacado, FUA) VALUES (:id_usuario, :nombre_producto, :descripcion_producto, :destacado, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_usuario', $usuario);
    $stmt->bindParam(':nombre_producto', $nombre);
    $stmt->bindParam(':descripcion_producto', $descripcion);
    $stmt->bindParam(':destacado', $destacado);
    $stmt->execute();

    $id_producto = $conn->lastInsertId();

   

    if(isset($categorias)) {
        $sqlCategorias = "INSERT INTO categorias_productos (id_producto, id_categoria) VALUES (:id_producto, :id_categoria)";
        $stmtCategorias = $conn->prepare($sqlCategorias);
    
        foreach ($categorias as $categoria) {
            $stmtCategorias->bindParam(':id_producto', $id_producto);
            $stmtCategorias->bindParam(':id_categoria', $categoria);
            $stmtCategorias->execute();
    }
    }

    if(isset($imagenes)) {
        $sqlImagenes = "INSERT INTO imagenes_productos (id_producto, archivo) VALUES (:id_producto, :archivo)";
        $stmtImagenes = $conn->prepare($sqlImagenes);

        foreach ($imagenes as $imagen) {
            $stmtImagenes->bindParam(':id_producto', $id_producto);
            $stmtImagenes->bindParam(':archivo', $imagen);
            $stmtImagenes->execute();
    }
    }
}

function updateProduct($conn, $id) {
    $usuario = $_POST['id_usuario'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $destacado = $_POST['destacado'];
    $categorias = $_POST['categorias'];
    $imagenes = $_POST['imagenes'];

    $sql = "UPDATE productos SET id_usuario = :id_usuario, nombre_producto = :nombre_producto, descripcion_producto = :descripcion_producto, destacado = :destacado, FUA = NOW() WHERE id_producto = :id_producto";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_usuario', $usuario);
    $stmt->bindParam(':nombre_producto', $nombre);
    $stmt->bindParam(':descripcion_producto', $descripcion);
    $stmt->bindParam(':destacado', $destacado);
    $stmt->bindParam(':id_producto', $id);
    $stmt->execute();

    // Si tengo categorias, primero elimino todas las categorias y luego agrego todas nuevamente
    if(isset($categorias)) {
        $sqlDelete = "DELETE FROM categorias_productos WHERE id_producto = :id_producto";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bindParam(':id_producto', $id);
        $stmtDelete->execute();

        $sqlCategorias = "INSERT INTO categorias_productos (id_producto, id_categoria) VALUES (:id_producto, :id_categoria)";
        $stmtCategorias = $conn->prepare($sqlCategorias);

        foreach ($categorias as $categoria) {
            $stmtCategorias->bindParam(':id_producto', $id);
            $stmtCategorias->bindParam(':id_categoria', $categoria);
            $stmtCategorias->execute();
        }
    }

    if(isset($imagenes)) {
        $sqlDelete = "DELETE FROM imagenes_productos WHERE id_producto = :id_producto";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bindParam(':id_producto', $id);
        $stmtDelete->execute();

        $sqlImagenes = "INSERT INTO imagenes_productos (id_producto, archivo) VALUES (:id_producto, :archivo)";
        $stmtImagenes = $conn->prepare($sqlImagenes);

        foreach ($imagenes as $imagen) {
            $stmtImagenes->bindParam(':id_producto', $id);
            $stmtImagenes->bindParam(':archivo', $imagen);
            $stmtImagenes->execute();
        }
    }
}

function deleteProduct($conn, $id) {
    $sql = "DELETE FROM productos WHERE id_producto = :id_producto";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_producto', $id);
    $stmt->execute();
}