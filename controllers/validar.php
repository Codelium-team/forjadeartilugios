<?php
session_start();
include('../conexiones.php'); // Correcto


$usuario = $_POST['email']; 
$pass = $_POST['pass']; 

$query = $conn->prepare("SELECT * FROM usuarios WHERE email = :usuario AND password = :pass"); 
$query->bindParam(":usuario", $usuario);
$query->bindParam(":pass", $pass);
$query->execute();

$count = $query->rowCount();
$result = $query->fetch(PDO::FETCH_ASSOC);

if ($count > 0) {
    $_SESSION['activo'] = true;
    $_SESSION['usuario'] = $usuario;

    if ($result['id_usuario'] == 1) { // Cambia '1' por el ID específico que deseas validar
        header("Location: ../views/mostrar.php");
        // Cambia la ruta para redirigir correctamente
        exit();
    } else {
        header("Location: ../views/formulario.php?error=no_autorizado");
        exit();
    }
} else {
    header("Location: ../views/formulario.php?error=si");
    exit();
}
?>
