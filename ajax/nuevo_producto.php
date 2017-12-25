<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Inicia validacion del lado del servidor */
if (empty($_POST['codigo'])) {
    $errors[] = "Código vacío";
} else if (empty($_POST['nombre'])) {
    $errors[] = "Nombre del producto vacío";
    //} else if ($_POST['estado']==""){
    //	$errors[] = "Selecciona el estado del producto";
} else if (empty($_POST['precio'])) {
    $errors[] = "Precio de venta vacío";
} else if (
        !empty($_POST['codigo']) &&
        !empty($_POST['nombre']) &&
        //$_POST['estado']!="" &&
        !empty($_POST['precio'])
) {
    /* Connect To Database */
    require_once ("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
    require_once ("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
    // escaping, additionally removing everything that could be (html/javascript-) code
    $codigo = mysqli_real_escape_string($con, (strip_tags($_POST["codigo"], ENT_QUOTES)));
    $nombre = mysqli_real_escape_string($con, (strip_tags($_POST["nombre"], ENT_QUOTES)));
    $descripcion = mysqli_real_escape_string($con, (strip_tags($_POST["descripcion"], ENT_QUOTES)));
    $porcentaje = floatval($_POST['porcentaje']);
    $unidad = intval($_POST['unidad']);
    $cantidad = floatval($_POST['cantidad']);
    $tentrega = intval($_POST['tentrega']);
    $precio_venta = floatval($_POST['precio']);
    $id_proveedor = intval($_POST['id_proveedor']);
    // codigo para gestionar foto
    $nombre_foto = time() . "_" . $_FILES["foto"]["name"];
    
    //fin del codigo
    $date_added = date("Y-m-d H:i:s");

    $sql = "INSERT INTO tb_productos (codigo_producto, nombre_producto, descripcion_producto, unidad_medida_id, cantidad_producto, tiempo_entrega_id, porcentaje_dscto_base, precio_producto, foto_producto, fecha_creacion, proveedor_id) VALUES ('$codigo','$nombre','$descripcion','$unidad','$cantidad','$tentrega','$porcentaje',$precio_venta,'$nombre_foto','$date_added',$id_proveedor)";
    $query_new_insert = mysqli_query($con, $sql);
    if ($query_new_insert) {
        /////////////////////////////////////////////////////
         $location = '../fotos/' . $nombre_foto;  
         move_uploaded_file($_FILES["foto"]["tmp_name"], $location);
        /////////////////////////////////////////////////////
        $messages[] = "Producto ha sido ingresado satisfactoriamente.";
    } else {
        $errors [] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($con);
    }
} else {
    $errors [] = "Error desconocido.";
}

if (isset($errors)) {
    ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error!</strong> 
    <?php
    foreach ($errors as $error) {
        echo $error;
    }
    ?>
    </div>
        <?php
    }
    if (isset($messages)) {
        ?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Bien hecho!</strong>
    <?php
    foreach ($messages as $message) {
        echo $message;
    }
    ?>
    </div>
        <?php
    }
    ?>