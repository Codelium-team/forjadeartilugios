<?php
session_start();
include('../conexiones.php');


$usuario = $_POST['email']; 
$pass = $_POST['pass']; 

$query = $conn->prepare("SELECT * FROM usuarios WHERE email = :usuario"); 
$query->bindParam(":usuario", $usuario);
$query->execute();

$result = $query->fetch(PDO::FETCH_ASSOC);

if ($result && password_verify($pass, $result['password'])) {
    if ($result) {
        $_SESSION['usuario'] = $result['email'];
        $_SESSION['activo'] = true;
        $_SESSION['id'] = $result['id'];
        
       header("Location: ../views/formulario.php?valida=si");
    }
} else {
    header("Location: ../views/formulario.php?error=si");
    exit();
}

?>
