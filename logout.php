<?php
    require 'functions.php';


    //PRIMERO LLAMAMOS A LA FUNCION DE DESHACER PEDIDO PARA CERRAR LA SESION
    deshacerPedido();

    //LUEGO REDIRIGIMOS A INDEX.PHP
    header("Location: index.php");


?>