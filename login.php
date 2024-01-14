<?php
session_start();


//TODOS los errores de datos redirecciona a index.php

//caso en la que tendremos un fichero separado para conectar a la base de datos
//para no tener que iniciar session en la base de datos en cada pagina
include "conn_db.php";


//parte que he copiado de un video de youtube para comprobar los datos de inicio de session
if(isset($_POST['user']) && isset($_POST['pass']))
{
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return data;
    }
}

$user = validate($_POST['user']);
$pass = validate($_POST['pass']);


//condicional para comprobar si los campos han sido rellenado
if(empty($user)){
    header ("Location: index.php?error= Usuario obligatorio");
    exit();
}
else if(empty($pass)){
    header ("Location: index.php?error= Contraseña obligatorio");
    exit();
}

//consulta SQL
$sql = "SELECT * FROM users WHERE usuario = '$user' AND pass='$pass'";


//Conexion a la base de datos
$result = mysqli_query($con, $sql);


//comprobar si el usuario y la contraseña esta en la base de datos
if(mysqli_num_rows($result) === 1){
    $row = mysqli_fetch_assoc($result);
    if($row['usuario'] === $user && $row['pass'] === $pass){
        echo "Session Iniciada";
        $_SESSION['usuario'] = $row['usuario'];
        $_SESSION['pass'] = $row['pass'];
        //redirecciona a categoria.php en el caso de inicio session
        header("Location: categorias.php");
        exit();
    }
    //un else para mostrar un mensaje de error en el caso de que no coincida con nuestro BD
    else{
        header("Location: index.php?error= Usuario o Contraseña Incorrecta");
    }
}
else
{
    header("Location: index.php");
    exit();
}
?>