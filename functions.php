<?php
        //Creamos las variables de conexión a MySQL


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
    //Esta funcion coge el código del restaurante de la sesión.
    function datosUsuario() {

        $conexion = conexionBD();
        $user = $_SESSION['user'];
        $sentencia = "SELECT cod_rest FROM RESTAURANTE WHERE correo = '$user'";
        $result = mysqli_query($conexion, $sentencia);
        $leer = mysqli_fetch_row($result);
        return $leer[0];

    }

    function insertarCarrito($codigoProducto, $cantidad) {

        $conexion = conexionBD();
        $usuario = datosUsuario();

        //Si no se ha creado la sesión de pedidos, inserta en la tabla pedidos una linea para que cree con el auto increment el pedido automaticamente
        if (!isset($_SESSION['pedido'])) {
            $sentencia = "INSERT INTO PEDIDOS (fecha, cod_rest) VALUES (CURDATE(), $usuario)";
            mysqli_query($conexion, $sentencia) or die("Fallo al crear el pedido");

            //Y cuando se crea, se le hace un select para sacarla y guardarla tanto en una variable de sesión como en una variable normal
            $sentencia = "SELECT cod_ped FROM PEDIDOS WHERE cod_rest = $usuario ORDER BY cod_ped DESC LIMIT 1";
            $result = mysqli_query($conexion, $sentencia);
            $leer = mysqli_fetch_row($result);
            $_SESSION['pedido'] = $leer[0];
            $pedido = $_SESSION['pedido'];
        }
        else { //Si ya existe la sesión de pedidos no la crea y la guarda en la variable para no poner la variable de sesión desde el principio
            $pedido = $_SESSION['pedido'];
        }
        
        $sentencia = "INSERT INTO PEDIDOSPRODUCTOS (cod_ped, cod_prod, unidades) VALUES($pedido, $codigoProducto, 0)";
        mysqli_query($conexion, $sentencia) /*or die("Fallo al crear el carrito")*/;

        //Esto lo hago para que comprueba si las unidades son 0 (es decir, se acaba de crear)
        $sentencia="SELECT unidades FROM pedidosproductos WHERE cod_ped = $pedido AND cod_prod = $codigoProducto;";
        $result = mysqli_query($conexion, $sentencia);
        $leer = mysqli_fetch_row($result);

        if(!$leer) { //Escribiendo el comentario me he dado cuenta de que esto sobra realmente, si al final es más comodo con un
                    // update directamente al estar ya con 0 y eso, no sé, cómo lo veis dadme feedback

        $insertarPedidosProductos = "INSERT INTO PEDIDOSPRODUCTOS (cod_ped, cod_prod, unidades) VALUES
        ($pedido, $codigoProducto, $cantidad)";

        mysqli_query($conexion, $insertarPedidosProductos) or die("Error insertando datos en PEDIDOSPRODUCTOS");

        }
        else {
            //Hace un update en las tablas para que sume en el carrito y reste en productos. Al final como en la tabla el máximo
            //es lo que ponga stock no se va a poder coger más de lo que haya
        $insertarPedidosProductos = "UPDATE PEDIDOSPRODUCTOS SET unidades = ($leer[0]+$cantidad) WHERE cod_prod = $codigoProducto AND cod_ped = $pedido";
        $actualizarProductos = "UPDATE PRODUCTOS SET stock = (stock-$cantidad) WHERE cod_prod = $codigoProducto";
        mysqli_query($conexion, $insertarPedidosProductos) or die("Error actualizando datos en PEDIDOSPRODUCTOS");
        mysqli_query($conexion, $actualizarProductos) or die("Error insertando datos en PRODUCTOS");
        }
    }

    function eliminarCarrito($codigoProducto, $cantidad) {


        $conexion = conexionBD();
        $usuario = datosUsuario();

        //Esto para quien lo quiera hacer, que recoja la cantidad igual que en productos

        $pedido = $_SESSION['pedido'];

        $sentencia = "DELETE FROM pedidosproductos WHERE cod_ped = $pedido AND cod_prod = $codigoProducto";
        $actualizarProductos = "UPDATE PRODUCTOS SET stock = (stock+$cantidad) WHERE cod_prod = $codigoProducto";
        mysqli_query($conexion, $sentencia) /*or die("Fallo al borrar del carrito")*/;
        mysqli_query($conexion, $actualizarProductos) /*or die("Fallo al borrar del carrito")*/;
    }
    
?>