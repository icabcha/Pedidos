<?php
session_start();


//TODOS los errores de datos redirecciona a index.php

//caso en la que tendremos un fichero separado para conectar a la base de datos
//para no tener que iniciar session en la base de datos en cada pagina
//include "conn_db.php";
//$conn = new mysqli("localhost", "root", "", "DWES");
//new PDO("mysql:host=".SERVIDOR.";charset=utf8", USUARIO, CLAVE);

$nombreBD='DWES';
$servidor='localhost';
$usuario='root';
$password='';

$conexion=mysqli_connect($servidor,$usuario,$password);
mysqli_select_db($conexion,$nombreBD) or die("no se pudo conex¡ctar");

//parte para comprobar los datos de inicio de session
if(isset($_POST['user']) && isset($_POST['pass']))
{
    $user = $_POST['user'];
    $pass = $_POST['pass'];
}




//condicional para comprobar si los campos han sido rellenado
if(empty($user)){
    header ("Location: index.php?error= Usuario obligatorio");
    exit();
}
else if(empty($pass)){
    header ("Location: index.php?error= Contraseña obligatoria");
    exit();
}

//consulta SQL
$sql = "SELECT * FROM RESTAURANTE WHERE correo = '$user' AND clave = '$pass'";


//Conexion a la base de datos
//$result = mysqli_query($conn, $sql);
$result = mysqli_query($conexion,$sql);
$row = mysqli_fetch_row($result);





//comprobar si el usuario y la contraseña esta en la base de datos

if(mysqli_num_rows($result) === 1){
    //$row = mysqli_fetch_assoc($result);
    if($row[1] === $user && $row[2] === $pass){
        echo "Session Iniciada";
        $_SESSION['usuario'] = $row[1];
        $_SESSION['pass'] = $row[2];
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