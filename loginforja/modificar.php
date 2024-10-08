<?php
include('conexion.php');
include('sesion.php'); // Asegúrate de estar validando la sesión

if (!isset($_SESSION['usuario'])) {
    // Si no hay usuario en la sesión, redirige a login
    header("Location: formulario.php");
    exit();
}

// Verificar si el formulario ha sido enviado
if (isset($_POST['modificar'])) {
    // Asegúrate de sanitizar y validar los inputs para mayor seguridad
    $seleccionar = $_POST['seleccionar'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    // Cambié la tabla de "registros" a "usuarios"
    // Usar sentencias preparadas correctamente
    $sql = "UPDATE usuarios SET nombre = :nombre, email = :email, telefono = :telefono
            WHERE email = :seleccionar";

    $query = $conn->prepare($sql);

    // Vinculamos los valores de manera segura
    $query->bindParam(':nombre', $nombre);
    $query->bindParam(':email', $email);
    $query->bindParam(':telefono', $telefono);
    $query->bindParam(':seleccionar', $seleccionar);

    // Ejecutar la consulta
    try {
        if ($query->execute()) {
            echo "<p>Usuario actualizado correctamente.</p>";
            header("Location: modificar.php"); // Redirigir a la misma página para evitar reenvío de formulario
            exit();
        } else {
            echo "<p>Error al actualizar el registro.</p>";
            print_r($query->errorInfo()); // Imprime los errores de la consulta si los hay
        }
    } catch (PDOException $e) {
        echo "Error al ejecutar la consulta: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Modificar Usuario</title>
</head>
<body>
    <h1>Modificar Datos del Usuario</h1>

    <!-- Formulario para seleccionar y modificar el usuario -->
    <form action="modificar.php" method="post">
        <label for="seleccionar">Correo electrónico del usuario a modificar:</label>
        <input type="text" name="seleccionar" required placeholder="Email del usuario">
        <br><br>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required placeholder="Nombre del usuario">
        <br><br>

        <label for="email">Nuevo Correo electrónico:</label>
        <input type="email" name="email" required placeholder="Nuevo Email">
        <br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" required placeholder="Teléfono del usuario">
        <br><br>

        <input type="submit" name="modificar" value="Modificar Usuario">
    </form>

    <!-- Mostrar la lista de usuarios -->
    <h2>Usuarios Existentes</h2>
    <?php
    $sql = "SELECT * FROM usuarios";
    $query = $conn->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($query->rowCount() > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th></tr>";
        foreach ($results as $result) {
            echo "<tr>";
            echo "<td>" . $result['id_usuario'] . "</td>";
            echo "<td>" . $result['nombre'] . "</td>";
            echo "<td>" . $result['email'] . "</td>";
            echo "<td>" . $result['telefono'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No hay usuarios registrados.";
    }
    ?>
</body>
</html>
