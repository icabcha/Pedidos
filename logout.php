<?php
    require 'functions.php';


    //PRIMERO LLAMAMOS A LA FUNCION DE DESHACER PEDIDO PARA CERRAR LA SESION
    session_destroy();

    //LUEGO REDIRIGIMOS A INDEX.PHP
    header("Location: index.php");


?>