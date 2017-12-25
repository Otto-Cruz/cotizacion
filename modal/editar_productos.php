<?php
if (isset($con)) {
   
    ?>
    <!-- Modal -->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar producto</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" id="editar_producto" name="editar_producto">
                        <div id="resultados_ajax2"></div>
                        <div class="form-group">
                            <label for="mod_codigo" class="col-sm-3 control-label">Código</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="mod_codigo" name="mod_codigo" placeholder="Código del producto" required>
                                <input type="hidden" name="mod_id" id="mod_id">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mod_nombre" class="col-sm-3 control-label">Nombre</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="mod_nombre" name="mod_nombre" placeholder="Nombre del producto" required>				</div>
                        </div>
                        <div class="form-group">
                            <label for="mod_descripcion" class="col-sm-3 control-label">Descripci&oacute;n</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="mod_descripcion" name="mod_descripcion" placeholder="Descripción del producto" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mod_unidad" class="col-sm-3 control-label">Unidad de Medida</label>
                            <div class="col-sm-8">
                              <!--- <input type="text" class="form-control" id="unidad" name="unidad" placeholder="Tipo de unidad" required> --->
                                <select class="form-control" id="mod_unidad" name="mod_unidad" required>
                                    <?php
                                        $sql_tunidad = mysqli_query($con, "select * from tb_unidad_de_medida order by id_unidad_medida");
                                        while ($rw1 = mysqli_fetch_array($sql_tunidad)) {
                                            $id_tunidad = $rw1["id_unidad_medida"];
                                            $nombre_tunidad = $rw1["nombre_unidad"];
                                            echo '<option value="' . $id_tunidad . '">' . $nombre_tunidad . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mod_cantidad" class="col-sm-3 control-label">Cantidad</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="mod_cantidad" name="mod_cantidad" placeholder="Cantidad" required min="1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mod_tentrega" class="col-sm-3 control-label">Tiempo de Entrega</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="mod_tentrega" name="mod_tentrega" required>
                                    <?php
                                    $sql_tentrega = mysqli_query($con, "select * from tb_tiempos_de_entrega order by id_tiempo_entrega");
                                    while ($rw2 = mysqli_fetch_array($sql_tentrega)) {
                                        $id_tentrega = $rw2["id_tiempo_entrega"];
                                        $descripcion_tentrega = $rw2["descripcion"];
                                        echo '<option value="' . $id_tentrega . '">' . $descripcion_tentrega . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mod_descuento" class="col-sm-3 control-label">Porcentaje de Descuento</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="mod_descuento" name="mod_descuento" placeholder="Porcentaje de Descuento" required min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mod_precio" class="col-sm-3 control-label">Precio</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="mod_precio" name="mod_precio" placeholder="Precio de venta del producto" required min="0">
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <label for="mod_foto" class="col-sm-3 control-label">Foto (JPG, JPEG, PNG) </label>
                            <div class="col-sm-8">
                                <input type="file" name="mod_foto" id="mod_foto" class="btn-default" required>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="mod_proveedor" class="col-sm-3 control-label">Proveedor</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="mod_proveedor" name="mod_proveedor" required>
                                   <?php
                                    $sql_proveedor = mysqli_query($con, "select * from tb_proveedores order by id_proveedor");
                                    while ($rw3 = mysqli_fetch_array($sql_proveedor)) {
                                        $id_proveedor = $rw3["id_proveedor"];
                                        $n_proveedor = $rw3["nombre_proveedor"];
                                        echo '<option value="' . $id_proveedor . '">' . $n_proveedor . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>