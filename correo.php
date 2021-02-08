<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require "/usr/share/php/libphp-phpmailer/src/PHPMailer.php";
require "/usr/share/php/libphp-phpmailer/src/Exception.php";
require "/usr/share/php/libphp-phpmailer/src/SMTP.php";

function crear_correo($carrito, $pedido, $correo){
    $texto = "<h1>Pedido nº $pedido </h1><h2>Restaurante: $correo </h2>";

    $texto .= "Detalle del pedido:";
    $productos = cargar_productos(array_keys($carrito));
    $texto .= "<table>";
    $texto .= "<tr><th>Nombre</th><th>Descripción</th><th>Peso</th><th>Unidades</th></tr>";

    foreach($productos as $producto) {
        $cod= $producto['codProd'];
        $nom = $producto['nombre'];
        $des = $producto['descripcion'];
        $peso = $producto['peso'];
        $unidades = $_SESSION['carrito'][$cod];
        $texto .= "<tr><td>$nom</td><td>$des</td><td>$peso</td><td>$unidades</td></tr>";
    }
    $texto .= "</table>";
    return $texto;
}

function enviar_correo_multiples($lista_correos, $cuerpo, $asunto = "") {

}

function enviar_correos($carrito, $pedido, $correo) {
    $mail = new PHPMailer();
    $mail->IsSMTP();
    // Cambiar a 0 para no ver mensajes de error
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    // Introducir usuario de google
    $mail->Username = "jesuslpinzolas@gmail.com";
    // Introducir clave
    $mail->Password = "yqfevtlnamwujoio";
    $mail->SetFrom("jesuslpinzolas@gmail.com", "Jesús L. Pinzolas");
    // Asunto
    $mail->Subject = "Confirmación pedido";
    $cuerpoMensaje = crear_correo($carrito, $pedido, $correo);
    // Cuerpo
    $mail->MsgHTML($cuerpoMensaje);
    // Destinatario
    $mail->AddAddress($correo);
    // Enviar
    $resul = $mail->Send();
    if (!$resul) {
        echo "Error". $mail->ErrorInfo;
    } else {
        echo "Enviado";
    }
}