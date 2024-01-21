<?php
require 'functions.php';
session_start();


//TODOS los errores de datos redirecciona a index.php

//caso en la que tendremos un fichero separado para conectar a la base de datos
//para no tener que iniciar session en la base de datos en cada pagina
//include "conn_db.php";
//$conn = new mysqli("localhost", "root", "", "DWES");
//new PDO("mysql:host=".SERVIDOR.";charset=utf8", USUARIO, CLAVE);

$conexion=conexionBD();

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
        $_SESSION['user'] = $row[1];
        $_SESSION['pass'] = $row[2];



        //CREAMOS EL COD_PEDIDO
        //Para ello necesitamos conectarnos a la bd y recoger el codigo de restaurante
        $conexion = conexionBD();
        $usuario = datosUsuario();

        //Si no se ha creado la sesión de pedidos, inserta en la tabla pedidos una linea para que cree con el auto increment el pedido automaticamente
        //hacemos que inserte un pedido null para iniciar la tabla pedidosproductos
        $sentencia = "INSERT INTO PEDIDOS (fecha, cod_rest) VALUES (CURDATE(), $usuario)";
        mysqli_query($conexion, $sentencia) or die("Fallo al crear el pedido");

        //Y cuando se crea, se le hace un select para sacarla y guardarla tanto en una variable de sesión como en una variable normal
        $sentencia = "SELECT cod_ped FROM PEDIDOS WHERE cod_rest = $usuario";
        $result = mysqli_query($conexion, $sentencia);
        $leer = mysqli_fetch_row($result);
        $_SESSION['pedido'] = $leer[0];

        //redirecciona a categoria.php en el caso de inicio session
        header("Location: categorias.php");
                
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