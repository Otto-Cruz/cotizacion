<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database */
require_once ("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
    $id_unidad = intval($_GET['id']);
    $query = mysqli_query($con, "select * from tb_productos where unidad_medida_id='" . $id_unidad . "'");
    $count = mysqli_num_rows($query);
    if ($count == 0) {
        if ($delete1 = mysqli_query($con, "DELETE FROM tb_unidad_de_medida WHERE id_unidad_medida='" . $id_unidad . "'")) {
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
    $aColumns = array('nombre_unidad'); //Columnas de busqueda
    $sTable = "tb_unidad_de_medida";
    $sWhere = "";
    if ($_GET['q'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    $sWhere .= " order by nombre_unidad";
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
    $reload = './unidad_de_medida.php';
    //main query to fetch the data
    $sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($con, $sql);
    //loop through fetched data
    if ($numrows > 0) {
        ?>
        <div class="table-responsive">
            <table class="table">
                <tr  class="info">
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Agregado</th>
                    <th class='text-right'>Acciones</th>

                </tr>
                <?php
                while ($row = mysqli_fetch_array($query)) {
                    $id_unidad = $row['id_unidad_medida'];
                    $nombre_unidad = $row['nombre_unidad'];
                    $descripcion_unidad = $row['descripcion_unidad'];
                    $date_added = date('d/m/Y', strtotime($row['fecha_creacion']));
                    ?>

                    <input type="hidden" value="<?php echo $descripcion_unidad; ?>" id="descripcion_unidad<?php echo $id_unidad; ?>">
                    <input type="hidden" value="<?php echo $nombre_unidad; ?>" id="nombre_unidad<?php echo $id_unidad; ?>">


                    <tr>


                        <td><?php echo $nombre_unidad; ?></td>
                        <td><?php echo $descripcion_unidad; ?></td>
                        <td><?php echo $date_added; ?> </td>

                        <td><span class="pull-right">
                                <a href="#" class='btn btn-default' title='Editar Unidad de Medida' onclick="obtener_datos('<?php echo $id_unidad; ?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
                                <a href="#" class='btn btn-default' title='Borrar Unidad de Medida' onclick="eliminar('<?php echo $id_unidad; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>

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