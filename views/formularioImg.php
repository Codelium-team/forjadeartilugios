<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Imagen</title>
</head>
<body>
<form action="../upload_imag.php" method="POST" enctype="multipart/form-data">
    <label for="archivo">Selecciona una imagen:</label>
    <input type="file" name="archivo" required>

    <button type="submit">Subir Imagen</button>
</form>
</body>
</html>
