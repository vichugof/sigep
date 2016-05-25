

<div class="modal fade" id="newEPModal" tabindex="-1" role="dialog" aria-labelledby="passFromNewEPToEPModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="passFromNewEPToEPModal">EP NUEVO</h4>
            </div>
            <div class="modal-body">
                <!-- <form id="formNewEP" class="form-horizontal" action="/geo/passtoep" method="post" enctype="multipart/form-data"> -->
                <form id="formNewEP" class="form-horizontal" action="<?php echo base_url('/geo/passtoep'); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="recipient[ref-ep-id]" class="form-control" id="recipient_ref_ep_id" value="">
                    <input type="hidden" name="recipient[tipoep-id]" class="form-control" id="recipient_tipoep_id" value="">
                    <div class="form-group">
                        <label for="recipient_area" class="col-sm-2 control-label">Área:</label>
                        <div class="col-sm-10">
                            <span id="recipient_area" class="form-control"> </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient_comuna" class="col-sm-2 control-label">Comuna:</label>
                        <div class="col-sm-10">
                            <span id="recipient_comuna" class="form-control"> </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient_barrio" class="col-sm-2 control-label">Barrio:</label>
                        <div class="col-sm-10">
                            <span id="recipient_barrio" class="form-control"> </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient_barrio" class="col-sm-2 control-label">Fecha de Creación:</label>
                        <div class="col-sm-10">
                            <span id="recipient_creacion" class="form-control"> </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient_barrio" class="col-sm-2 control-label">Fecha de Actualización:</label>
                        <div class="col-sm-10">
                            <span id="recipient_actualizacion" class="form-control"> </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient_escala" class="col-sm-2 control-label">Escala:</label>
                        <div class="col-sm-10">
                            <input type="text" required name="recipient[escala]" class="form-control" id="recipient_escala" value="">
                            <span id="helpBlock2" class="help-block">Referente a la escala geográfica de la información obtenida. Ej: Local, regional.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient_categoria" class="col-sm-2 control-label">Categoria:</label>
                        <div class="col-sm-10">
                            <input type="text" required name="recipient[categoria]" class="form-control" id="recipient_categoria" value="">
                            <span id="helpBlock2" class="help-block">Referente al uso del predio. Ej: Zona verde, parque.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2"> 
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" id="buttonSendMessage" class="btn btn-primary">Transformar</button>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    setDataFormNewEp = function(data){

        $('#newEPModal').find('#recipient_ref_ep_id').val(data.properties.id);
        $('#newEPModal').find('#recipient_tipoep_id').val(data.properties.id_tipo);
        $('#newEPModal').find('#recipient_area').text(data.properties.shape_area);
        $('#newEPModal').find('#recipient_comuna').text(data.properties.comuna_nombre);
        $('#newEPModal').find('#recipient_barrio').text(data.properties.barrio_nombre);
        $('#newEPModal').find('#recipient_creacion').text(data.properties.creacion);
        $('#newEPModal').find('#recipient_actualizacion').text(data.properties.actualizacion);

        console.log(data);

    };

    $(function() {
        var $form = $('#formNewEP');
        var $modal = $('#newEPModal');
        $form.on('submit', function(event){
            event.preventDefault();
            $.ajax({
                //url: base_url+'index.php/geo/passtoep',    
                url: base_url+'geo/passtoep',    
                type: "POST",
                cache: false,
                data: $(this).serialize()
            })
            .done(function( result ) {

                if(result.success == true && result.data.success == 'success'){
                    console.log(result.data.supplemental);
                    var centroid = result.data.supplemental.features[0].properties.centroid.coordinates;
                    map.setView([centroid[1], centroid[0]], 17);
                    $modal.modal('toggle');
                }
            })
            .fail(function( jqXHR, textStatus ) {
                console.log('fail');
            });
            return false;
        });
    });
</script>