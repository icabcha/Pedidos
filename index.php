<?php
    require 'functions.php';
    CrearBaseDatos();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>

</head>
<body>
    
    <form action="login.php" method="post">
        <label>Usuario</label>
        <input type="text" name="user">
        <label>Contrasena</label>
        <input type="password" name="pass">

        <button type="submit">Iniciar sesión </button>
    </form>
</body>
</html>