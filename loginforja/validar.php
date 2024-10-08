<?php
include('conexion.php');

$usuario = $_POST['email']; 
$pass = ($_POST['pass']); 

$query = $conn->prepare("SELECT * FROM usuarios WHERE email = :usuario AND password = :pass"); 
$query->bindParam(":usuario", $usuario);
$query->bindParam(":pass", $pass);
$query->execute();

$count = $query->rowCount();
$result = $query->fetch(PDO::FETCH_ASSOC);

if ($count > 0) {
    session_start();

    $_SESSION['activo'] = true;
    $_SESSION['usuario'] = $usuario;

    // Aquí se podrían añadir condiciones distintas para cada acción.
    // Asumimos que "id" es un campo en tu base de datos que identifica al usuario
    if ($usuario == '169987777') {
        header("Location: eliminar.php");
    } elseif ($result['tipo_usuario'] == 'admin') {  // Cambia este campo según tu necesidad
        header("Location: modificar.php");
    } else {
        header("Location: mostrar.php");
    }
} else {
    header("Location: formulario.php?error=si");
}
?>
