<?php
// Iniciar la sesión para poder utilizar $_SESSION
session_start();

// Verificar si el usuario ha iniciado sesión, si no redirigir a login
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

include(__DIR__ . '../../conexiones.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/mostrar.css" rel="stylesheet" type="text/css" media="screen" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Formulario mostrar PERSONAL</title>
</head>

<body>
    <p>Bienvenido: <?php echo $_SESSION["usuario"]; ?></p>
    <a href="salir.php?sal=si">CERRAR SESIÓN</a>
    <h1 align='center'>REGISTROS DE USUARIOS</h1>
    <br><br>

    <?php
    // Establecer la conexión con la base de datos
    try {
        $sql = "SELECT * FROM usuarios";  // Cambia 'usuarios' por el nombre real de tu tabla
        $query = $conn->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($query->rowCount() > 0) {
            echo "<table width='80%' align='center'>";
            echo "<tr><th width='20%'>RUT</th><th width='20%'>NOMBRE</th><th width='20%'>APELLIDO</th><th width='20%'>EMAIL</th></tr>";

            foreach ($results as $result) {
                echo "<tr>";
                echo '<td width="20%">' . $result['rut'] . '</td>';
                echo '<td width="20%">' . $result['nombre'] . '</td>';
                echo '<td width="20%">' . $result['apellido'] . '</td>';
                echo '<td width="20%">' . $result['email'] . '</td>';
                echo "</tr>";
            }

            echo "</table><br>";
        } else {
            echo "<p>No se encontraron registros.</p>";
        }
    } catch (PDOException $e) {
        echo "Error al obtener los datos: " . $e->getMessage();
    }
    ?>
</body>

</html>
