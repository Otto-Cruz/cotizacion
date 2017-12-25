<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database */
require_once ("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
    $id_tiempo = intval($_GET['id']);
    $query = mysqli_query($con, "select * from tb_productos where tiempo_entrega_id='" . $id_tiempo . "'");
    $count = mysqli_num_rows($query);
    if ($count == 0) {
        if ($delete1 = mysqli_query($con, "DELETE FROM tb_tiempos_de_entrega WHERE id_tiempo_entrega='" . $id_tiempo . "'")) {
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
            <strong>Error!</strong> No se pudo eliminar éste  dato. Existen documentos vinculados a éste item. 
        </div>
        <?php
    }
}
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('descripcion'); //Columnas de busqueda
    $sTable = "tb_tiempos_de_entrega";
    $sWhere = "";
    if ($_GET['q'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    $sWhere .= " order by id_tiempo_entrega";
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
    $reload = './tiempo_de_entrega.php';
    //main query to fetch the data
    $sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($con, $sql);
    //loop through fetched data
    if ($numrows > 0) {
        ?>
        <div class="table-responsive">
            <table class="table">
                <tr  class="info">
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Agregado</th>
                    <th class='text-right'>Acciones</th>

                </tr>
                <?php
                while ($row = mysqli_fetch_array($query)) {
                    $id_tiempo = $row['id_tiempo_entrega'];
                    $descripcion_tiempo = $row['descripcion'];
                    $date_added = date('d/m/Y', strtotime($row['fecha_creacion']));
                    ?>

                    <input type="hidden" value="<?php echo $descripcion_tiempo; ?>" id="descripcion_tiempo<?php echo $id_tiempo; ?>">


                    <tr>


                        <td><?php echo $id_tiempo; ?></td>
                        <td><?php echo $descripcion_tiempo; ?></td>
                        <td><?php echo $date_added; ?> </td>

                        <td><span class="pull-right">
                                <a href="#" class='btn btn-default' title='Editar Tiempo de Entrega' onclick="obtener_datos('<?php echo $id_tiempo; ?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
                                <a href="#" class='btn btn-default' title='Borrar Tiempo de Entrega' onclick="eliminar('<?php echo $id_tiempo; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>

                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan=7><span class="pull-right"><?php
                            echo paginate($reload, $page, $total_pages, $adjacents);
                            ?></span></td>
                </tr>
            </table>
        </div>
        <?php
    }
}
?>