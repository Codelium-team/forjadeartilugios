<?php
include(__DIR__ . '../../conexiones.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/eliminar.css" rel="stylesheet" type="text/css" media="screen" />
    <title>Formulario eliminar USUARIOS</title>
</head>

<body>
    <P>Bienvenido: </P>
    <?php echo $_SESSION["usuario"]; ?><br>
    <a href="salir.php?sal=si">CERRAR SESIÓN</a>
    <h1 align='center'>REGISTROS EXISTENTES</h1>
    <br><br>

    <?php
    // Consulta para obtener los usuarios
    $sql = "SELECT * FROM usuarios"; // Consulta a la tabla 'usuarios'
    $query = $conn->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar la tabla de usuarios
    echo "<table width='80%' align='center'>";
    echo "<tr><th width='20%'>ID</th><th width='20%'>NOMBRE</th><th width='20%'>APELLIDO</th><th width='20%'>EMAIL</th><th width='20%'>ACCIONES</th></tr>";

    // Verificar si hay registros
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            // Mostrar cada fila de la tabla con los datos del usuario
            echo "<tr>";
            echo "<td width='20%'>" . $result['id_usuario'] . "</td>";  // Mostrar ID
            echo "<td width='20%'>" . $result['nombre'] . "</td>";
            echo "<td width='20%'>" . $result['apellido'] . "</td>";
            echo "<td width='20%'>" . $result['email'] . "</td>";
            // Enlace para eliminar usuario por ID
            echo "<td width='20%'><a href='eliminar.php?id=" . $result['id_usuario'] . "'>Eliminar</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5' align='center'>No hay registros disponibles</td></tr>";
    }

    echo "</table><br>";
    ?>

    <?php
    // Verificar si se ha recibido un ID a través de la URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Consulta para eliminar al usuario por ID
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id"; // Usar 'id_usuario' como el campo único
        $query = $conn->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT); // El 'id' es un entero
        if ($query->execute()) {
            echo "El usuario ha sido eliminado correctamente.";
            // Redirigir después de la eliminación para evitar que el formulario se resubmit
            header("Location: eliminar.php");
            exit;
        } else {
            echo "Hubo un error al intentar eliminar el usuario.";
        }
    }
    ?>

</body>
</html>
