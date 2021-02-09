<?php
session_start();
// Eliminar todas las variables de sesión
session_unset();
// Eliminar la sesión
session_destroy();

// Redirigir a Login
header("Location: login.php");