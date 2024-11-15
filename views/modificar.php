<?php
include(__DIR__ . '../../conexiones.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>formulario modificar PERSONAL</title>
    <link href="../assets/css/modificar.css" rel="stylesheet" type="text/css" media="screen" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <P>Bienvenido: </P>
    <?php echo $_SESSION["usuario"]; ?></br>
    <a href="salir.php?sal=si">CERRAR SESIÓN</a>
    <h1 align='center'>REGISTROS EXISTENTES</h1>
    <br><br>
    <?php
    include('conexion.php');

    // Obtener todos los usuarios de la tabla 'usuarios'
    $sql = "SELECT * FROM usuarios";
    $query = $conn->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    echo "<table width='80%' align='center'></tr>";
    echo "<th width='20%'>ID</th>";
    echo "<th width='20%'>NOMBRE</th>";
    echo "<th width='20%'>EMAIL</th>";
    echo "<th width='20%'>TELÉFONO</th>";
    echo "</tr>";

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            echo "</tr>";
            echo '<td width=20%>' . $result['id_usuario'] . '</td>';
            echo '<td width=20%>' . $result['nombre'] . '</td>';
            echo '<td width=20%>' . $result['email'] . '</td>';
            echo '<td width=20%>' . $result['telefono'] . '</td>';
            echo "</tr>";
        }
    }

    echo "</table></br>";
    ?>
    <div class="encabezado">
        <h1>Modificar registro</h1>
    </div>

    <div class="formulario">
        <form name="registro" method="post" action="" enctype="application/x-www-form-urlencoded">
            <div class="campo">
                <label>Ingresa el ID de usuario que deseas modificar:</label>
                <input name='seleccionar' type="text" required>
            </div>

            <div class="campo">
                <label for="id_usuario">ID Usuario:</label>
                <input type="text" name="id_usuario" required />
            </div>

            <div class="campo">
                <div class="en-linea izquierdo">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" required />
                </div>

                <div class="en-linea">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" name="telefono" required />
                </div>
            </div>

            <div class="campo">
                <label for="email">Correo electrónico:</label>
                <input type="email" name="email" required />
            </div>

            <div class="botones">
                <input type="submit" name="modificar" value="Modificar" />
            </div>
        </form>

        <?php
        if (isset($_POST['modificar'])) {
            $seleccionar = $_POST['seleccionar'];
            $id_usuario = $_POST['id_usuario'];
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $email = $_POST['email'];

            // Validación básica
            if (empty($id_usuario) || empty($nombre) || empty($telefono) || empty($email)) {
                echo "Por favor complete todos los campos.";
            } else {
                // Consulta para actualizar los datos del usuario
                $sql = "UPDATE usuarios SET nombre = :nombre, telefono = :telefono, email = :email WHERE id_usuario = :id_usuario";
                $query = $conn->prepare($sql);

                // Asignar valores a los parámetros
                $query->bindParam(':nombre', $nombre);
                $query->bindParam(':telefono', $telefono);
                $query->bindParam(':email', $email);
                $query->bindParam(':id_usuario', $id_usuario);

                // Ejecutar la consulta y verificar si fue exitosa
                if ($query->execute()) {
                    echo "Usuario actualizado correctamente.";
                } else {
                    echo "No se pudo modificar el usuario. Verifique los datos ingresados.";
                }
            }
        }
        ?>
    </div>
</body>

</html>
