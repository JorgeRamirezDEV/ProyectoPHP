<?php
require_once 'sesiones.php';
comprobar_sesion();
$cod = $_POST['cod'];
$unidades = $_POST['unidades'];
/* Si existe el código restamos las unidades, con un mínimo de 0 */
if(isset($_SESSION['carrito'][$cod])){
    $_SESSION['carrito'][$cod] -= $unidades;
    if($_SESSION['carrito'][$cod] <= 0){
        unset($_SESSION['carrito'][$cod]);
    }
}
header("Location: carrito.php");