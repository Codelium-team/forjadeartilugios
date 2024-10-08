<?php
include('sesion.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="estilos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>formulario mostrar USUARIOS</title>
</head>

<body>
    <P>Bienvenido: </P>
    <?php echo $_SESSION["usuario"]; ?></br>
    <a href="salir.php?sal=si">CERRAR SESIÓN</a>
    <h1 align='center'>USUARIOS EXISTENTES</h1>
    <br><br>

    <?php
    include('conexion.php');
    $sql = "SELECT * FROM usuarios";
    $query = $conn->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    echo "<table width='80%' align='center'>";
    echo "<tr>";
    echo "<th width='20%'>ID</th>";
    echo "<th width='20%'>NOMBRE</th>";
    echo "<th width='20%'>EMAIL</th>";
    echo "<th width='20%'>TELEFONO</th>";
    echo "</tr>";

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            echo "<tr>";
            echo '<td width=20%>'.$result['id_usuario'].'</td>';
            echo '<td width=20%>'.$result['nombre'].'</td>';
            echo '<td width=20%>'.$result['email'].'</td>';
            echo '<td width=20%>'.$result['telefono'].'</td>';
            echo "</tr>";
        }			
    }
    echo "</table></br>";
    ?>
</body>
</html>
