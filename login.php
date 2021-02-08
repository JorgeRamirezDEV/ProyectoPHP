<?php
require_once 'bd.php';
/* Formulario de login habitual
si va bien abre sesión, guarda el nombre de usuario y redirige a principal.php
si va mal, mensaje de error */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usu = comprobar_usuario($_POST['usuario'], $_POST['clave']);
    if ($usu === FALSE) {
        $err = TRUE;
        $usuario = $_POST['usuario'];
    } else {
        session_start();
        // $usu tiene como campos correo, codRes y correo
        $_SESSION['usuario'] = $usu;
        $_SESSION['carrito'] = [];
        header("Location: categorias.php");
        return;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Formulario de login</title>
</head>
<body>
    <?php if(isset($_GET['redirigido'])) {
        echo "<p>Haga login para continuar</p>";
    } ?>
    <?php if(isset($err) and $err == TRUE) {
        echo "<p>Revise usuario y contraseña</p>";
    } ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" id="usuario" value="<?php if(isset($usuario)) echo $usuario;?>">
        <label for="clave">Clave</label>
        <input type="password" name="clave" id="clave">
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>
