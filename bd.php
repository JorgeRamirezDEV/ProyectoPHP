<?php

/**
 * Devuelve la configuración de la base de datos
 * @param $nombre string ruta del archivo de configuración
 * @param $esquema  string ruta del fichero XSD para validar
 * @throws Exception si no se puede validar la configuración
 * @return array con Cadena de conexión, usuario, contraseña
 */
function leer_config($nombre, $esquema) {
    $configuracion = new DOMDocument();
    $configuracion->load($nombre);
    $valido = $configuracion->schemaValidate($esquema);
    if ($valido) {
        $elementosConfiguracion = [];
        foreach ($configuracion->documentElement->childNodes as $node) {
            if (trim($node->textContent) != FALSE) {
                array_push($elementosConfiguracion, $node->textContent);
            }
        }
        $cadenaConexion = "mysql:dbname=".$elementosConfiguracion[1].";host=".$elementosConfiguracion[0];
        return array($cadenaConexion, $elementosConfiguracion[2], $elementosConfiguracion[3]);
    } else {
        throw new Exception("No se ha podido validar el archivo de configuración");
    }
}

/**
 * Devuelve un cursor con las categorías
 * @return FALSE|PDOStatement
 * @throws Exception
 */
function cargar_categorias() {
    $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
    $bd = new PDO($res[0], $res[1], $res[2]);
    $ins = "SELECT codCat, nombre FROM categoria";
    $resul = $bd->query($ins);
    if(!$resul) {
        return FALSE;
    }
    if($resul->rowCount() === 0) {
        return FALSE;
    }
    return $resul;
}

/**
 * Devuelve un array con el nombre y la descripción de la categoría
 * @param $codCat number codigo categoría
 * @return FALSE|array
 * @throws Exception
 */
function cargar_categoria($codCat) {
    $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
    $bd = new PDO($res[0], $res[1], $res[2]);
    $ins = "SELECT nombre, descripcion FROM categoria WHERE codCat=$codCat";
    $resul = $bd->query($ins);
    if(!$resul) {
        return FALSE;
    }
    if($resul->rowCount() === 0) {
        return FALSE;
    }
    $categoria = $resul -> fetch();
    return array(
        "nombre" => $categoria['nombre'],
        "descripcion" => $categoria['descripcion']
    );
}

/**
 * Si el usuario existe devuelve un array con el codRes (código de restaurante) y el correo. Si hay algún error o los datos son incorrectos devuelve FALSE
 * @param $nombre string correo del restaurante
 * @param $clave string clave del restaurante
 * @return FALSE|array
 * @throws Exception
 */
function comprobar_usuario($nombre, $clave) {
    $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
    $bd = new PDO($res[0], $res[1], $res[2]);
    $ins = "SELECT codRes, correo FROM restaurante WHERE correo='$nombre' AND clave='$clave'";
    $resul = $bd->query($ins);
    if(!$resul) {
        return FALSE;
    }
    if($resul->rowCount() === 0) {
        return FALSE;
    }
    $usuario = $resul -> fetch();
    return array(
        "codRes" => $usuario['codRes'],
        "correo" => $usuario['correo']
    );
}

/**
 * Devuelve un cursor con los productos de la categoría. Incluye todas las columnas de la BD. Si hay algún error con la base de datos, la categoría no existe o no tiene productos, devuelve false
 * @param $codCat number Codigo categoria
 * @return false|PDOStatement
 */
function cargar_productos_categoria($codCat) {
    $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
    $bd = new PDO($res[0], $res[1], $res[2]);
    $ins = "SELECT * FROM producto WHERE categoria='$codCat'";
    $resul = $bd->query($ins);
    if(!$resul) {
        return FALSE;
    }
    if($resul->rowCount() === 0) {
        return FALSE;
    }
    return $resul;
}

/**
 * @param $codigosProductos
 * @return false|PDOStatement
 * @throws Exception
 */
function cargar_productos($codigosProductos) {
    $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
    $bd = new PDO($res[0], $res[1], $res[2]);
    $texto_in = implode(",", $codigosProductos);
    $ins = "select * from producto where codProd in ($texto_in)";
    $resul = $bd->query($ins);
    if (!$resul) {
        return FALSE;
    }
    return $resul;
}

/**
 * @param $carrito
 * @param $codRes
 * @return false|string
 * @throws Exception
 */
function insertar_pedido($carrito, $codRes){
    $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
    $bd = new PDO($res[0], $res[1], $res[2]);
    $bd->beginTransaction();
    $hora = date("Y-m-d H:i:s", time());
    // Insertar el pedido
    $sql = "INSERT INTO pedido(fecha, enviado, restaurante) VALUES ( '$hora' ,0, $codRes)";
    $resul = $bd->query($sql);
    if (!$resul) {
        return FALSE;
    }
    // Coger el id del nuevo pedido para las filas detalle
    $pedido = $bd->lastinsertid();
    // Insertar las filas en pedidoproductos
    foreach($carrito as $codProd=>$unidades){
        $sql = "INSERT INTO pedidoProducto(pedido, producto, unidades) VALUES ($pedido, $codProd, $unidades)";
        echo $sql;
        $resul = $bd->query($sql);
        if (!$resul) {
            $bd->rollback();
            return FALSE;
        }

        $sql = "UPDATE producto SET stock = stock - $unidades WHERE codProd = $codProd";
        $resul=$bd->query($sql);
        if(!$resul){
            $bd->rollback() ;
            return FALSE;
        }
    }
    $bd->commit() ;
    return $pedido;
}