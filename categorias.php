<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <style>
        div#categorias{
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
            justify-content: space-evenly;
        }
        div#categorias a{
            margin: 20px;
            width: 300px;
            padding: 10px;
            text-decoration: none;
            background-color: #292d3e;
            transition: 0.5s;
        }
        div#categorias a:hover {
            background-color: #6d4fa7;
        }
        div#categorias img {
            width: 100%;
        }
        div#categorias h4{
            text-align: center;
            color: white;
            margin: 5px;
        }
    </style>
</head>

<body>
<?php 
//NICIAMOS SESION Y CONECTAMOS A LA BASE DE DATOS  
$nombreBD='DWES';
$servidor='localhost';
$usuario='root';
$password='';

$conexion=mysqli_connect($servidor,$usuario,$password);
mysqli_select_db($conexion,$nombreBD);

//CONTAMOS EL MINIMO Y EL MAXIMO PARA DESPUES HACER UN BUCLE

$codmax = "SELECT MAX(cod_cat) FROM CATEGORIAS";
$MAX = mysqli_query($conexion,$codmax);
$codmin = "SELECT MIN(cod_cat) FROM CATEGORIAS";
$MIN = mysqli_query($conexion,$codmin);

$nummax = mysqli_fetch_row($MAX);
$nummin = mysqli_fetch_row($MIN);

?>

     <div id="titulo">
        <p>luis</p>
     </div>

     <div id="carrito">
        <p>luis</p>
     </div>

     <div id="categorias">
        <?php
            for($i = 1; $i <= $nummax[0];$i++){
                $buscarCategorias = "SELECT * FROM CATEGORIAS WHERE cod_cat = '$i'";
                $InfoCategorias = mysqli_query($conexion, $buscarCategorias);
                $Categorias=mysqli_fetch_row($InfoCategorias);
                echo "<a href=productos.php?categoria=".$Categorias[0].">";
                    echo '<h4>'. $Categorias[1] .'</h4>';
                echo '</a>';
            }
        ?>
     </div>
     <?php
        // CERRAMOS LA CONEXION
        mysqli_close($conexion);  
    ?>
</body>
</html>