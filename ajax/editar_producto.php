<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Inicia validacion del lado del servidor */
if (empty($_POST['mod_id'])) {
    $errors[] = "ID vacío";
} else if (empty($_POST['mod_codigo'])) {
    $errors[] = "Código vacío";
} else if (empty($_POST['mod_nombre'])) {
    $errors[] = "Nombre del producto vacío";
} else if (empty($_POST['mod_precio'])) {
    $errors[] = "Precio de venta vacío";
} else if (
        !empty($_POST['mod_id']) &&
        !empty($_POST['mod_codigo']) &&
        !empty($_POST['mod_nombre']) &&
        !empty($_POST['mod_precio'])
) {
    /* Connect To Database */
    require_once ("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
    require_once ("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
    // escaping, additionally removing everything that could be (html/javascript-) code
    $codigo = mysqli_real_escape_string($con, (strip_tags($_POST["mod_codigo"], ENT_QUOTES)));
    $nombre = mysqli_real_escape_string($con, (strip_tags($_POST["mod_nombre"], ENT_QUOTES)));
    $descripcion = mysqli_real_escape_string($con, (strip_tags($_POST["mod_descripcion"], ENT_QUOTES)));
    $unidad_id = intval($_POST['mod_unidad']);
    $tentrega_id = intval($_POST['mod_tentrega']);
    $proveedor_id = intval($_POST['mod_proveedor']);
    $cantidad = floatval($_POST['mod_cantidad']);
    $precio_venta = floatval($_POST['mod_precio']);
    $descuento = floatval($_POST['mod_descuento']);
    $id_producto = $_POST['mod_id'];
    // codigo para gestionar foto
    $nombre_foto = $_FILES["mod_foto"]["name"];
    $nombre_foto_actualizado = time() . "_" . $_FILES["mod_foto"]["name"];
    //fin del codigo
    if (!empty($nombre_foto)) {
          // En primer lugar, borramos la foto anterior
        $sql_del = mysqli_query($con, "select * from tb_productos where id_producto='" . $id_producto . "'");
        $row_del = mysqli_fetch_array($sql_del);
        $foto = $row_del['foto_producto'];
        $foto_para_borrar = '../fotos/' . $foto;
        unlink($foto_para_borrar);
        //  Despues, copiamos la foto nueva.
        $location = '../fotos/' . $nombre_foto_actualizado;
        move_uploaded_file($_FILES["mod_foto"]["tmp_name"], $location);
        $sql = "UPDATE tb_productos SET codigo_producto='" . $codigo . "', nombre_producto='" . $nombre . "', descripcion_producto='" . $descripcion . "',unidad_medida_id='" . $unidad_id . "', cantidad_producto='" . $cantidad . "', tiempo_entrega_id='" . $tentrega_id . "', porcentaje_dscto_base='" . $descuento . "', foto_producto='" . $nombre_foto_actualizado . "', proveedor_id='" . $proveedor_id . "',  precio_producto='" . $precio_venta . "' WHERE id_producto='" . $id_producto . "'";
    }
    $query_update = mysqli_query($con, $sql);
    if ($query_update) {
        $messages[] = "Producto ha sido actualizado satisfactoriamente.";
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