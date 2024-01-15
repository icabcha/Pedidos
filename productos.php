<?php
    require 'functions.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <style>
        /*Estilo del título y de la tabla*/
        h1, table{
            width: 100%;
            background-color: white;
            text-align: center;
            border: 2px solid #292d3e;
            border-radius: 4px;
            padding: 2% 0;
        }

        /*Estilo para que los bordes de la tabla se fusionen y no estén separados*/
        table{
            border-collapse: collapse;
        }

        /*Estilo de cada celda de la tabla*/
        td{
            border: 1px solid #292d3e;
            padding: 8px;
        }

        /*Estilo de la primera fila de la tabla*/
        #fila1{
            background-color: #292d3e;
            color: white;
        }

        /*Estilo de cada columna de la tablas de la página Linea de detalle*/
        .ldd--col{
            width: 33%;
            padding: 8px;
            border: none;
        }

        /*Estilo de la tabla cuya clase es ldd en la página de Linea de detalle*/
        .ldd{
            margin-top: 2%;
        border-bottom: 2px solid #292d3e;
        }

        /*Estilo de la fila que se añade a una tabla ya existente en la página Línea de detalle*/
        .ldd--row{
            border-top: none;
            border-bottom: 2px solid #292d3e;
        }
    </style>
</head>
<body>
    <?php
        //INICIAMOS SESION Y CONECTAMOS A LA BASE DE DATOS  
        conexionBD();

        if(isset($_REQUEST["categoria"])){
            $categoria = $_REQUEST["categoria"];
        }

        //Creamos la sentencia SQL de consulta y la ejecutamos
        $leer="SELECT * FROM `productos` WHERE cod_cat=$categoria;";
        $registros=mysqli_query(conexionBD(),$leer);    
    ?>

    <!--Creamos una tabla cuya primera fila será el encabezado-->
    <table>
        <tr id="fila1">
            <td>Código de producto</td>
            <td>Nombre</td>
            <td>Stock</td>
            <td>Código de categoría</td>
        </tr>
        <?php
            //Recorremos todos los resultados de la consulta anterior y los mostramos. Cada resultado será una fila de la tabla
            while($registro=mysqli_fetch_row($registros)){
        ?>
                <tr>
                    <td><?php echo $registro[0]; ?></td>
                    <td><?php echo $registro[1]; ?></td>
                    <td><?php echo $registro[2]; ?></td>
                    <td><?php echo $registro[3]; ?></td>
                </tr>
        <?php
            }
        ?>
    </table>
    <p style="text-align: center;">
        <input type="button" value="Volver a Categorias" class="categoriasbutton" id="btncategorias" 
        onclick="document.location.href='categorias.php'"/>
        <input type="button" value="Carrito" class="carritobutton" id="btncarrito" 
        onclick="document.location.href='carrito.php'"/>
    </p>
</body>
</html>