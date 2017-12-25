<?php
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id = session_id();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
if (isset($_POST['cantidad'])) {
    $cantidad = $_POST['cantidad'];
}
if (isset($_POST['precio_venta'])) {
    $precio_venta = $_POST['precio_venta'];
}

/* Connect To Database */
require_once ("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php"); //Contiene funcion que conecta a la base de datos

if (!empty($id) and ! empty($cantidad) and ! empty($precio_venta)) {
    $insert_tmp = mysqli_query($con, "INSERT INTO tmp (id_producto,cantidad_tmp,precio_tmp,session_id) VALUES ('$id','$cantidad','$precio_venta','$session_id')");
}
if (isset($_GET['id'])) {//codigo elimina un elemento del array
    $id_tmp = intval($_GET['id']);
    $delete = mysqli_query($con, "DELETE FROM tmp WHERE id_tmp='" . $id_tmp . "'");
}
?>
<table class="table">
    <tr>
        <th class='text-center'>ITEM</th>
        <th class='text-center'>CANT.</th>
        <th class='text-center'>UND.</th>
        <th class='text-center'>CODIGO</th>
        <th class='text-center'>DESCRIPCION</th>
        <th class='text-center'>FOTO</th>
        <th class='text-right'>TIEMPO ENTREGA</th>
        <th class='text-right'>PRECIO UNIT.</th>
        <th class='text-right'>% DSCTO.</th>
        <th class='text-right'>PRECIO UNIT.</th>
        <th class='text-right'>PRECIO TOTAL</th>

    </tr>
    <?php
    $sumador_total = 0;
    $nro_item = 0;
    $sql = mysqli_query($con, "select * from tb_productos, tmp where tb_productos.id_producto=tmp.id_producto and tmp.session_id='" . $session_id . "'");
    while ($row = mysqli_fetch_array($sql)) {
        $nro_item++;
        $id_tmp = $row["id_tmp"];
        $codigo_producto = $row['codigo_producto'];
        $cantidad = $row['cantidad_tmp'];
        $nombre_producto = $row['nombre_producto'];
        $descripcion_producto = $row['descripcion_producto'];
        $n_foto=$row['foto_producto'];
        $precio_venta = $row['precio_tmp'];
        $id_unidad = $row['unidad_medida_id'];
        $sql_unidad = mysqli_query($con, "select * from tb_unidad_de_medida where id_unidad_medida='" . $id_unidad . "'");
        $row2 = mysqli_fetch_array($sql_unidad);
        $unidad_de_medida=$row2['nombre_unidad'];

        
        $precio_venta_f = number_format($precio_venta, 2); //Formateo variables
        $precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
        $precio_total = $precio_venta_r * $cantidad;
        $precio_total_f = number_format($precio_total, 2); //Precio total formateado
        $precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
        $sumador_total += $precio_total_r; //Sumador
        ?>
        <tr>
            <td class='text-center'><?php echo $nro_item; ?></td>
            <td class='text-center'><?php echo $cantidad; ?></td>
            <td class='text-center'><?php echo $unidad_de_medida; ?></td>
            <td class='text-center'><?php echo $codigo_producto; ?></td>
            <td><?php echo $nombre_producto; ?><br><?php echo $descripcion_producto; ?></td>
            <td class='text-center'><a target='_blank' href="fotos/<?php echo $n_foto ?>" ><img src="fotos/<?php echo $n_foto ?>" alt="<?php echo $n_foto ?>" height="30" width="30"/></a></td>
            <td class='text-center'><?php echo $codigo_producto; ?></td>
            <td class='text-center'><?php echo $codigo_producto; ?></td>
            <td class='text-center'><?php echo $codigo_producto; ?></td>

            <td class='text-right'><?php echo $precio_venta_f; ?></td>
            <td class='text-right'><?php echo $precio_total_f; ?></td>
            <td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
        </tr>		
        <?php
    }
    $subtotal = number_format($sumador_total, 2, '.', '');
    $total_iva = ($subtotal * TAX ) / 100;
    $total_iva = number_format($total_iva, 2, '.', '');
    $total_factura = $subtotal + $total_iva;
    ?>
    <tr>
        <td class='text-right' colspan=4>SUBTOTAL $</td>
        <td class='text-right'><?php echo number_format($subtotal, 2); ?></td>
        <td></td>
    </tr>
    <tr>
        <td class='text-right' colspan=4>IGV (<?php echo TAX ?>)% $</td>
        <td class='text-right'><?php echo number_format($total_iva, 2); ?></td>
        <td></td>
    </tr>
    <tr>
        <td class='text-right' colspan=4>TOTAL $</td>
        <td class='text-right'><?php echo number_format($total_factura, 2); ?></td>
        <td></td>
    </tr>

</table>
