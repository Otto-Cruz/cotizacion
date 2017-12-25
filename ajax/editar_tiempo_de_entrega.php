<?php
include('is_logged.php'); //Archivo verifica que el ususario que intenta acceder a la URL esta logueado
/* Inicia validacion del lado del servidor */
if (empty($_POST['mod_id'])) {
    $errors[] = "ID vacío";
} else if ($_POST['mod_descripcion'] == "") {
    $errors[] = "Descripcion vacio";
} else if (
        !empty($_POST['mod_id']) &&
        !empty($_POST['mod_descripcion'])
        
) {
    /* Connect To Database */
    require_once ("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
    require_once ("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
    // escaping, additionally removing everything that could be (html/javascript-) code
    $descripcion = mysqli_real_escape_string($con, (strip_tags($_POST["mod_descripcion"], ENT_QUOTES)));
   

    $id_tiempo_de_entrega = intval($_POST['mod_id']);
    $sql = "UPDATE tb_tiempos_de_entrega SET descripcion='" . $descripcion ."' WHERE id_tiempo_entrega='".$id_tiempo_de_entrega. "'";
    $query_update = mysqli_query($con, $sql);
    if ($query_update) {
        $messages[] = "Tiempo de Entrega ha sido actualizado satisfactoriamente.";
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