<?php
session_start();

//COMPROBAR SI SE HA INICIADO SESION
if(isset($_SESSION['user']) && isset($_SESSION['pass'])){

}else{
    echo "<h1>NO HAS INICIADO SESION TONTO</h1>";
}

?>