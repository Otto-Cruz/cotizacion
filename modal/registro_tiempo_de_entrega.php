<?php
if (isset($con)) {
    ?>
    <!-- Modal -->
    <div class="modal fade" id="nuevoTiempo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo Tiempo de Entrega</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" id="guardar_tiempo" name="guardar_tiempo">
                        <div id="resultados_ajax"></div>
                        <div class="form-group">
                            <label for="descripcion" class="col-sm-3 control-label">Descripci&oacute;n</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripción de Tiempo de Entrega" required>
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