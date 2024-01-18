<?php
        //Creamos las variables de conexión a MySQL
    function CrearBaseDatos() {
        $host="localhost";
        $usuario="root";
        $pass="";

        //Establecemos la conexión con MySQL
        $conexion=mysqli_connect($host,$usuario,$pass) or die("Error de conexión");

        $borrar = "DROP DATABASE DWES";
        $borrada = mysqli_query($conexion, $borrar);

        $crear="CREATE DATABASE IF NOT EXISTS DWES";
        $creada=mysqli_query($conexion,$crear);

        if($creada){
            echo("<script>console.log('La base de datos DWES se ha creado correctamente');</script>");
        }else{
            echo "<script>console.log('La base de datos DWES no se ha creado');</script>";
        }

        //Conectamos a la base de datos
        mysqli_select_db($conexion,"DWES") or die("Error seleccionando la base de datos");

        //Creamos las tablas categorias y productos y las ejecutamos
        $tabla1="CREATE TABLE IF NOT EXISTS CATEGORIAS(
            cod_cat INT(5) NOT NULL AUTO_INCREMENT,
            nombre VARCHAR(50),
            CONSTRAINT PK_CAT PRIMARY KEY (cod_cat)
        )";

        $tabla2="CREATE TABLE IF NOT EXISTS PRODUCTOS(
            cod_prod INT(5) NOT NULL AUTO_INCREMENT,
            nombre VARCHAR(50),
            stock INT(9),
            cod_cat INT(5),
            CONSTRAINT FK_PRODCAT FOREIGN KEY (cod_cat) REFERENCES CATEGORIAS(cod_cat) ON DELETE SET NULL ON UPDATE CASCADE,
            CONSTRAINT PK_PROD PRIMARY KEY (cod_prod)
        )";
        mysqli_query($conexion, $tabla1) or die("Error creando la tabla CATEGORIAS");
        mysqli_query($conexion, $tabla2) or die("Error creando la tabla PRODUCTOS");

        //Creamos las tablas restaurantes y pedidos y las ejecutamos
        $tabla3="CREATE TABLE IF NOT EXISTS RESTAURANTE(
            cod_rest INT(5) NOT NULL AUTO_INCREMENT,
            correo VARCHAR(50) NOT NULL,
            clave VARCHAR(50),
            CONSTRAINT PK_REST PRIMARY KEY (cod_rest),
            CONSTRAINT RES_UNICA UNIQUE (correo)
        )";

        $tabla4="CREATE TABLE IF NOT EXISTS PEDIDOS(
            cod_ped INT(5) NOT NULL AUTO_INCREMENT,
            fecha DATE NOT NULL DEFAULT CURDATE(),
            cod_rest INT(5),
            CONSTRAINT FK_REST FOREIGN KEY (cod_rest) REFERENCES RESTAURANTE(cod_rest) ON DELETE SET NULL ON UPDATE CASCADE,
            CONSTRAINT PK_PED PRIMARY KEY (cod_ped)
        )";
        mysqli_query($conexion, $tabla3) or die("Error creando la tabla RESTAURANTE");
        mysqli_query($conexion, $tabla4) or die("Error creando la tabla PEDIDOS");

        //Creamos la tabla que conecta Pedidos y Productos y la ejecutamos
        $tabla5="CREATE TABLE IF NOT EXISTS PEDIDOSPRODUCTOS(
            cod_ped INT(5),
            cod_prod INT(5),
            unidades INT(5) NOT NULL,
            CONSTRAINT PK_PEDPRO PRIMARY KEY (cod_ped, cod_prod),
            CONSTRAINT FK_PEDPRO_PE FOREIGN KEY (cod_ped) REFERENCES PEDIDOS(cod_ped) ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT FK_PEDPRO_PR FOREIGN KEY (cod_prod) REFERENCES PRODUCTOS(cod_prod) ON DELETE CASCADE ON UPDATE CASCADE
        )";
        mysqli_query($conexion, $tabla5) or die("Error creando la tabla PEDIDOSPRODUCTOS");


        //INSERTAMOS PRODUCTOS EN LAS TABLAS:
            // Insertar datos en la tabla CATEGORIAS
    $insertarCategorias = "INSERT INTO CATEGORIAS (nombre) VALUES
                                                                    ('Pasta'),
                                                                    ('Hamburguesas'),
                                                                    ('Pescado'),
                                                                    ('Carne'),
                                                                    ('Postres'),
                                                                    ('Bebidas')";
    mysqli_query($conexion, $insertarCategorias) or die("Error insertando datos en CATEGORIAS");

    // Insertar datos en la tabla RESTAURANTE
    $insertarRestaurantes = "INSERT INTO RESTAURANTE (correo, clave) VALUES
                                                                            ('restaurante1@gmail.com', '121'),
                                                                            ('restaurante2@gmail.com', '122'),
                                                                            ('restaurante3@gmail.com', '123')";
    mysqli_query($conexion, $insertarRestaurantes) or die("Error insertando datos en RESTAURANTE");

    // Insertar datos en la tabla PRODUCTOS
    $insertarProductos = "INSERT INTO PRODUCTOS (nombre, stock, cod_cat) VALUES
                                                                        ('Macarrones', 100, 1),
                                                                        ('Pollo', 50, 2),
                                                                        ('Espaguetis', 200, 1)";
    mysqli_query($conexion, $insertarProductos) or die("Error insertando datos en PRODUCTOS");

    // Insertar datos en la tabla PEDIDOS


    // Insertar datos en la tabla PEDIDOSPRODUCTOS

    }

    function conexionBD() {

        $host="localhost";
        $usuario="root";
        $pass="";
        $nom_db = "DWES";

        $conexion = mysqli_connect($host, $usuario, $pass);
        mysqli_select_db($conexion, $nom_db);

        if(!$conexion){
            echo "<script>console.log('Fallo en la conexión');</script>";;
        }
        else {
            return $conexion;
        }

    }

    function insertarCarrito($codigoProducto, $cantidad) {

        $conexion = conexionBD();

        
        $sentencia="SELECT $cantidad FROM pedidosproductos WHERE cod_ped = 1 && cod_prod = $codigoProducto;";
        $result = mysqli_query($conexion, $sentencia);
        $leer = mysqli_fetch_row($result);
        if($leer == 0) {

        $insertarPedidosProductos = "INSERT INTO PEDIDOSPRODUCTOS (cod_ped, cod_prod, unidades) VALUES
        (1, $codigoProducto, $cantidad)";

        mysqli_query($conexion, $insertarPedidosProductos) or die("Error insertando datos en PEDIDOSPRODUCTOS");

        }
        else {
        $insertarPedidosProductos = "UPDATE PEDIDOSPRODUCTOS SET unidades = $leer+$cantidad WHERE cod_prod = $codigoProducto && cod_ped = 1";
        $actualizarProductos = "UPDATE PRODUCTOS SET stock = stock-$cantidad WHERE cod_prod = $codigoProducto";
        mysqli_query($conexion, $insertarPedidosProductos) or die("Error actualizando datos en PEDIDOSPRODUCTOS");
        mysqli_query($conexion, $actualizarProductos) or die("Error insertando datos en PRODUCTOS");
        }
        return $leer;
    }

    

    
?>