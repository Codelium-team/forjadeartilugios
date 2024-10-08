<?php include('sesion.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="estilos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Formulario Eliminar Usuarios</title>
</head>
<body>
    <p>Bienvenido: <?php echo $_SESSION["usuario"]; ?></p>
    <a href="salir.php?sal=si">CERRAR SESIÓN</a>
    
    <h1>Usuarios Existentes</h1>
    
    <?php
    include('conexion.php');
    $sql = "SELECT * FROM usuarios";
    $query = $conn->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    echo "<table>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Nombre</th>";
    echo "<th>Email</th>";
    echo "<th>Teléfono</th>";
    echo "</tr>";

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            echo "<tr>";
            echo '<td>'.$result['id_usuario'].'</td>';
            echo '<td>'.$result['nombre'].'</td>';
            echo '<td>'.$result['email'].'</td>';
            echo '<td>'.$result['telefono'].'</td>';
            echo "</tr>";
        }			
    }
    echo "</table>";
    ?>

    <div>
        <form action="" method="post">
            <label>Ingresa el ID del usuario que desea eliminar:</label>
            <input name="eliminar-registro" type="text" required>
            <input name="eliminar" type="submit" value="Eliminar">
        </form>	

        <?php
        if (isset($_POST['eliminar'])) {
            $eliminar = $_POST['eliminar-registro'];
            $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
            $query = $conn->prepare($sql);
            $query->bindParam(":id_usuario", $eliminar);
            $query->execute();
            header("Location:eliminar.php");
        }
        ?>	
    </div>
</body>
</html>
