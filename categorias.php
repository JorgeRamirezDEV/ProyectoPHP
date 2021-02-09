<?php
/* Comprueba que el usuario haya abierto sesión o redirige */
require 'sesiones.php';
require_once 'bd.php';
comprobar_sesion();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset = "UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Lista de categorías</title>
</head>
<body>
    <?php require 'cabecera.php';?>
    <hl>Lista de categorías</hl>
    <!-- Lista de vínculos con la forma productos.php?categoria=1 -->
    <?php
    $categorias = cargar_categoria();
    if($categorias === FALSE) {
        echo "<p class='error'>Error al conectar con la base datos</
            p>";
    }else{
        echo "<ul>";
        foreach($categorias as $cat){
            /* $cat['nombre'] $cat['codCat'] */
            $url="productos.php?categoria=".$cat['codCat'];
            echo "<li><a href='$url'>".$cat['nombre']."</a></li>";
        }
        echo "</ul>";
    }
    ?>
</body>
</html>