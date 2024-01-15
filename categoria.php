<?php
    session_start();
    if(isset($_SESSION['usuario']) && isset($_SESSION['pass'])){
       
        echo "<h1>hola mundo</h1>";

    }
?>