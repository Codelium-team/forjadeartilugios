<?php
// Incluir el archivo de conexión a la base de datos
include('../conexiones.php');

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];

    // Preparar la consulta para insertar el nuevo usuario en la base de datos
    $query = $conn->prepare("INSERT INTO usuarios (nombre, email, telefono, password, FUA) VALUES (:nombre, :email, :telefono, :password, NOW())");
    $query->bindParam(':nombre', $nombre);
    $query->bindParam(':email', $email);
    $query->bindParam(':telefono', $telefono);
    $query->bindParam(':password', $password);

    // Ejecutar la consulta
    if ($query->execute()) {
        // Redirigir con el parámetro para mostrar la alerta
        header("Location: agregar.php?valida=si");
        exit;
    } else {
        echo "Error al agregar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/agregar.css" rel="stylesheet" type="text/css" media="screen" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
    // Verificar si el parámetro 'valida' está presente en la URL
    if (isset($_GET['valida']) && $_GET['valida'] === 'si') {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Usuario agregado con éxito',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location.href = '../views/formulario.php';
            });
        </script>";
    }
    ?>

    <form method="post" action="agregar.php">
        <h2>Agregar Usuario</h2>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required /><br>

        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" required /><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" required /><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required /><br>

        <input type="submit" value="Agregar Usuario" />
    </form>
</body>
</html>
