<?php
if (isset($con)) {
    ?>
    <!-- Modal -->
    <div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo producto</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" id="guardar_producto" name="guardar_producto">
                        <div id="resultados_ajax_productos"></div>
                        <div class="form-group">
                            <label for="codigo" class="col-sm-3 control-label">Código</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ingrese Código" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese Nombre" required>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="descripcion" class="col-sm-3 control-label">Descripcion</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese descripción" required maxlength="255" ></textarea>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="unidad" class="col-sm-3 control-label">Unidad de Medida</label>
                            <div class="col-sm-8">
                              <!--- <input type="text" class="form-control" id="unidad" name="unidad" placeholder="Tipo de unidad" required> --->
                                <select class="form-control" id="unidad" name="unidad" required>
                                    <option value=""> -- Seleccione Unidad -- </option>
                                    <?php
                                    $sql_unidad = mysqli_query($con, "select * from tb_unidad_de_medida order by id_unidad_medida");
                                    while ($rowsu = mysqli_fetch_array($sql_unidad)) {
                                        $id_unidad = $rowsu['id_unidad_medida'];
                                        $descripcion_unidad = $rowsu['descripcion_unidad'];
                                        echo '<option value="' . $id_unidad . '">' . $descripcion_unidad . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cantidad" class="col-sm-3 control-label">Cantidad</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Ingrese valor" required min="1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tentrega" class="col-sm-3 control-label">Tiempo de Entrega</label>
                            <div class="col-sm-8">
                            <!---	<input type="text" class="form-control" id="tentrega" name="tentrega" placeholder="Ingrese Tiempo de Entrega. Ej. Inmediata" required>  --->
                                <select class="form-control" id="tentrega" name="tentrega" required>
                                    <option value=""> -- Seleccione Tiempo de Entrega -- </option>
                                    <?php
                                    $sql_tentrega = mysqli_query($con, "select * from tb_tiempos_de_entrega order by id_tiempo_entrega");
                                    while ($rw = mysqli_fetch_array($sql_tentrega)) {
                                        $id_tentrega = $rw["id_tiempo_entrega"];
                                        $descripcion_tentrega = $rw["descripcion"];
                                        echo '<option value="' . $id_tentrega . '">' . $descripcion_tentrega . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="porcentaje" class="col-sm-3 control-label">Porcentaje de Descuento ( % )</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="porcentaje" name="porcentaje" placeholder="Ingrese Dscto. Ej. 10" required min="0" max="100">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="precio" class="col-sm-3 control-label">Precio</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="precio" name="precio" placeholder="Ingrese valor" required min="0">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="foto" class="col-sm-3 control-label">Foto (JPG, JPEG, PNG) </label>
                            <div class="col-sm-8">
                                <input type="file" name="foto" id="foto" class="btn-default">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="id_proveedor" class="col-sm-3 control-label">Proveedor</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="id_proveedor" name="id_proveedor" required>
                                    <option value=""> -- Seleccione proveedor -- </option>
                                    <?php
                                    $sql_proveedores = mysqli_query($con, "select * from tb_proveedores order by id_proveedor");
                                    while ($rows = mysqli_fetch_array($sql_proveedores)) {
                                        $id_proveedor = $rows['id_proveedor'];
                                        $nombre_proveedor = $rows['nombre_proveedor'];
                                        echo '<option value="' . $id_proveedor . '">' . $nombre_proveedor . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <?php
}
?>