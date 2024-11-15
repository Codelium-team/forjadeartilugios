<?php
session_start();
include('../conexiones.php');

$usuario = $_POST['email']; 
$pass = $_POST['pass']; 

$query = $conn->prepare("SELECT * FROM usuarios WHERE email = :usuario"); 
$query->bindParam(":usuario", $usuario);
$query->execute();

$result = $query->fetch(PDO::FETCH_ASSOC);

// Verifica si el usuario existe y si la contraseña es igual a la de la base de datos
if ($result && $pass === $result['password']) {
    // Si las credenciales son correctas
    $_SESSION['usuario'] = $result['email'];
    $_SESSION['activo'] = true;
    $_SESSION['id'] = $result['id_usuario'];
    
    // Redirigir con mensaje de éxito
    header("Location: ../views/formulario.php?valida=si");
    exit();
} else {
    // Si las credenciales no son correctas
    header("Location: ../views/formulario.php?error=si");
    exit();
}
?>
