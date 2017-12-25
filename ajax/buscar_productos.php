<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database */
require_once ("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);
    $query = mysqli_query($con, "select * from tb_detalles_cotizaciones where id_producto='" . $id_producto . "'");
    $count = mysqli_num_rows($query);
    if ($count == 0) {
            $sql_del=mysqli_query($con, "select * from tb_productos where id_producto='" .$id_producto."'");
            $row_del = mysqli_fetch_array($sql_del);
            $foto=$row_del['foto_producto'];
            $foto_para_borrar='../fotos/' .$foto;
            unlink($foto_para_borrar);
        if ($delete1 = mysqli_query($con, "DELETE FROM tb_productos WHERE id_producto='" . $id_producto . "'")) {
            ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Aviso!</strong> Datos eliminados exitosamente.
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
            </div>
            <?php
        }
    } else {
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> No se pudo eliminar éste  producto. Existen cotizaciones vinculadas a éste producto. 
        </div>
        <?php
    }
}
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('codigo_producto', 'nombre_producto'); //Columnas de busqueda
    $sTable = "tb_productos";
    $sWhere = "";
    if ($_GET['q'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    $sWhere .= " order by id_producto desc";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = './productos.php';
    //main query to fetch the data
    $sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($con, $sql);
    //loop through fetched data
    if ($numrows > 0) {
        ?>
        <div class="table-responsive">
            <table class="table">
                <tr  class="info">
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Foto</th>
                    <th>Unidad</th>
                    <!--- <th>Agregado</th> --->
                    <th class='text-right'>Precio</th>
                    <th class='text-right'>Acciones</th>

                </tr>
        <?php
        while ($row = mysqli_fetch_array($query)) {
            $id_producto = $row['id_producto'];
            $codigo_producto = $row['codigo_producto'];
            $nombre_producto = $row['nombre_producto'];
            $foto_producto = $row['foto_producto'];
            $descripcion_producto = $row['descripcion_producto'];
            $unidad_producto = $row['unidad_medida_id'];
            $cantidad_producto =$row['cantidad_producto'];
            $tentrega_producto = $row['tiempo_entrega_id'];
            $porcentaje_producto = $row['porcentaje_dscto_base'];
            $precio_producto = $row['precio_producto'];
            $proveedor_producto= $row['proveedor_id'];
            //$date_added= date('d/m/Y', strtotime($row['date_added']));
            $sql_um = "SELECT * FROM  tb_unidad_de_medida WHERE id_unidad_medida=$unidad_producto";
            $query_um = mysqli_query($con, $sql_um);
            $row = mysqli_fetch_array($query_um);
            $unidad_medida_descripcion = $row['nombre_unidad'];
            ?>

                    <input type="hidden" value="<?php echo $codigo_producto; ?>" id="codigo_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo $nombre_producto; ?>" id="nombre_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo $foto_producto; ?>" id="foto_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo $descripcion_producto; ?>" id="descripcion_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo $unidad_producto; ?>" id="unidad_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo $cantidad_producto; ?>" id="cantidad_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo $tentrega_producto; ?>" id="tentrega_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo $porcentaje_producto; ?>" id="porcentaje_producto<?php echo $id_producto; ?>">
                    <input type="hidden" value="<?php echo $precio_producto; ?>" id="precio_producto<?php echo $id_producto; ?>">
                  <input type="hidden" value="<?php  echo $proveedor_producto;  ?>" id="proveedor_producto<?php  echo $id_producto;  ?>"> 
                    <tr>

                        <td><?php echo $codigo_producto; ?></td>
                        <td ><?php echo $nombre_producto; ?></td>
                        <td ><a target='_blank' href="fotos/<?php echo $foto_producto ?>" ><img src="fotos/<?php echo $foto_producto ?>" alt="<?php echo $foto_producto ?>" height="30" width="30"/></a></td>
                        <td ><?php echo $unidad_medida_descripcion; ?></td>

            <!--- <td><?php /* echo $date_added; */ ?></td> --->
                        <td>$<span class='pull-right'><?php echo $precio_producto; ?></span></td>
                        <td ><span class="pull-right">
                                <a href="#" class='btn btn-default' title='Editar producto' onclick="obtener_datos('<?php echo $id_producto; ?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
                                <a href="#" class='btn btn-default' title='Borrar producto' onclick="eliminar('<?php echo $id_producto; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>

                    </tr>
            <?php
        }
        ?>
                <tr>
                    <td colspan=6><span class="pull-right"><?php
        echo paginate($reload, $page, $total_pages, $adjacents);
        ?></span></td>
                </tr>
            </table>
        </div>
                <?php
            }
        }
        ?>