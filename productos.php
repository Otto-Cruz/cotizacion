<?php
session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}

/* Connect To Database */
require_once ("config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php"); //Contiene funcion que conecta a la base de datos

$active_cotizaciones = "";
$active_productos = "active";
$active_proveedores = "";
$active_clientes = "";
$active_usuarios = "";
$active_unidad_medida = "";
$active_tiempo_entrega = "";
$title = "Productos | Sistema de Cotizaciones";
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include("head.php"); ?>
    </head>
    <body>
        <?php
        include("navbar.php");
        ?>

        <div class="container">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="btn-group pull-right">
                        <button type='button' class="btn btn-info" data-toggle="modal" data-target="#nuevoProducto"><span class="glyphicon glyphicon-plus" ></span> Nuevo Producto</button>
                    </div>
                    <h4><i class='glyphicon glyphicon-search'></i> Buscar Productos</h4>
                </div>
                <div class="panel-body">

                    <?php
                    include("modal/registro_productos.php");
                    include("modal/editar_productos.php");
                    ?>
                    <form class="form-horizontal" role="form" id="datos_cotizacion">

                        <div class="form-group row">
                            <label for="q" class="col-md-2 control-label">Código o nombre</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="q" placeholder="Código o nombre del producto" onkeyup='load(1);'>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-default" onclick='load(1);'>
                                    <span class="glyphicon glyphicon-search" ></span> Buscar</button>
                                <span id="loader"></span>
                            </div>

                        </div>



                    </form>
                    <div id="resultados"></div><!-- Carga los datos ajax -->
                    <div class='outer_div'></div><!-- Carga los datos ajax -->			

                </div>
            </div>

        </div>
        <hr>
        <?php
        include("footer.php");
        ?>
        <script type="text/javascript" src="js/productos.js"></script>
    </body>
</html>
<script>

                                    $("#guardar_producto").submit(function (event) {
                                        $('#guardar_datos').attr("disabled", true);
                                        //script para verificar que el archivo cargado sea una imagen
                                        var name = document.getElementById("foto").files[0].name;
                                        var form_data = new FormData(document.getElementById("guardar_producto"));
                                        var ext = name.split('.').pop().toLowerCase();
                                        if (jQuery.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
                                            alert("Archivo de imagen inválido");
                                            return false;
                                        }
                                        var oFReader = new FileReader();
                                        oFReader.readAsDataURL(document.getElementById("foto").files[0]);
                                        var f = document.getElementById("foto").files[0];
                                        var fsize = f.size || f.fileSize;
                                        if (fsize > 2000000) {  // mayor a 2MB
                                            alert("El tamaño del archivo de imagen es muy grande. No debe ser mayor a 2MB");
                                            return false;
                                        }
                                        ///// fin de la verificacion   
                                            $.ajax({
                                            type: "POST",
                                            url: "ajax/nuevo_producto.php",
                                            data: form_data,
                                            async: false,
                                            cache: false,
                                            contentType: false,
                                            processData: false,   
                                            beforeSend: function (objeto) {
                                                $("#resultados_ajax_productos").html("Mensaje: Cargando...");
                                            },
                                            success: function (datos) {
                                                $("#resultados_ajax_productos").html(datos);
                                                $('#guardar_datos').attr("disabled", false);
                                                load(1);
                                            }
                                        });
                                        event.preventDefault();
                                    });


                                    $("#editar_producto").submit(function (event) {
                                        $('#actualizar_datos').attr("disabled", true);
                                            //script para verificar que el archivo cargado sea una imagen
                                        var name = document.getElementById("mod_foto").files[0].name;
                                        var form_data = new FormData(document.getElementById("editar_producto"));
                                        var ext = name.split('.').pop().toLowerCase();
                                        if (jQuery.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
                                            alert("Archivo de imagen inválido");
                                            return false;
                                        }
                                        var oFReader = new FileReader();
                                        oFReader.readAsDataURL(document.getElementById("mod_foto").files[0]);
                                        var f = document.getElementById("mod_foto").files[0];
                                        var fsize = f.size || f.fileSize;
                                        if (fsize > 2000000) {  // mayor a 2MB
                                            alert("El tamaño del archivo de imagen es muy grande. No debe ser mayor a 2MB");
                                            return false;
                                        }
                                        ///// fin de la verificacion
                                             $.ajax({
                                            type: "POST",
                                            url: "ajax/editar_producto.php",
                                            data: form_data,
                                            async: false,
                                            cache: false,
                                            contentType: false,
                                            processData: false,
                                            //////////////////////////
                                            beforeSend: function (objeto) {
                                                $("#resultados_ajax2").html("Mensaje: Cargando...");
                                            },
                                            success: function (datos) {
                                                $("#resultados_ajax2").html(datos);
                                                $('#actualizar_datos').attr("disabled", false);
                                                load(1);
                                            }
                                        });
                                        event.preventDefault();
                                    });

                                    function obtener_datos(id) {
                                        var codigo_producto = $("#codigo_producto" + id).val();
                                        var nombre_producto = $("#nombre_producto" + id).val();
                                        var descripcion_producto = $("#descripcion_producto" + id).val();
                                        var unidad_producto = $("#unidad_producto" + id).val(); 
                                        var cantidad_producto = $("#cantidad_producto" + id).val();
                                        var tentrega_producto = $("#tentrega_producto" + id).val();
                                        var porcentaje_producto = $("#porcentaje_producto" + id).val();
                                        var precio_producto = $("#precio_producto" + id).val();
                                        var nombre_foto = $("#foto_producto" + id).val();
                                        var proveedor_id = $("#proveedor_producto" + id).val(); 

                                        $("#mod_id").val(id);
                                        $("#mod_codigo").val(codigo_producto);
                                        $("#mod_nombre").val(nombre_producto);
                                        $("#mod_descripcion").val(descripcion_producto);
                                        $("#mod_unidad").val(unidad_producto);
                                        $("#mod_cantidad").val(cantidad_producto);
                                        $("#mod_tentrega").val(tentrega_producto);
                                        $("#mod_descuento").val(porcentaje_producto);
                                        $("#mod_precio").val(precio_producto);
                                        $("#mod_proveedor").val(proveedor_id);

                                    }




</script>