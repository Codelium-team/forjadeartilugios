<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/estilos.css" rel="stylesheet" type="text/css" media="screen" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Login</title>
</head>
<body>
    <div class="login">
        <img src="../assets/img/logo.jpg" alt="Logo" class="logo">
        <h2>Login</h2>
        <form name="login" method="post" action="../controllers/validar.php" enctype="application/x-www-form-urlencoded">
            <div class="input-group">
                <label for="email">Correo electrónico:</label>
                <input type="text" name="email" required />
            </div>
            <div class="input-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="pass" required />
            </div>
            <div class="input-group">
                <input type="submit" name="ingresar" value="Ingresar"/>
            </div>
            <p class="forgot-password"><a href="#">¿Olvidaste tu contraseña?</a></p>
        </form>
    </div>

    <script>
        // Comprueba si hay un error en la URL y muestra una alerta en consecuencia
        <?php
        if (isset($_GET["error"]) && $_GET["error"] == "si") {
            echo "Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Las credenciales son incorrectas',
            });";
        } elseif (isset($_GET['valida']) && $_GET['valida'] == "si") {
            echo "Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Inicio de sesión exitoso',
                showConfirmButton: false,
                timer: 3000
            });";
        }
        ?>
    </script>
</body>
</html>
