<?php
$servidor = "localhost";
$user = "root";
$password = "";

$nom_db = "DWES";

$conn = mysqli_connect($servidor, $user, $password, $nom_db);

if(!$conn){
    echo "!!!Conexion Fallida!!!";
}
