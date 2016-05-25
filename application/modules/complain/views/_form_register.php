
<style type="text/css">
.thumbnail{
    height: 80px;
    width: 80px;
}

.thumbnail img{
    max-height: 100%;
}

</style>
<div class="modal fade" id="complainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Queja</h4>
            </div>
            <div class="modal-body">
                <!-- <form id="formComplain" action="http://sigep.dev/index.php/complain/create" method="post" enctype="multipart/form-data"> -->
                <form id="formComplain" action="<?php echo base_url('/complain/create'); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="recipient-queja-id" class="form-control" id="recipient_queja_id" value="">
                    <input type="hidden" name="recipient-ref-ep-id" class="form-control" id="recipient_ref_ep_id" value="">
                    <input type="hidden" name="recipient-tipoep-id" class="form-control" id="recipient_tipoep_id" value="">
                     <div class="form-group info-add-ep hidden">
                        <label class="control-label">Escala:</label>
                        <span id="info_escala"></span>
                    </div>
                    <div class="form-group info-add-ep hidden">
                        <label  class="control-label">Fuente EP:</label>
                        <span id="info_fuente"></span>
                    </div>
                    <div class="form-group info-add-ep hidden">
                        <label  class="control-label">Nombre EP:</label>
                        <span id="info_nombre"></span>
                    </div>
                    <div class="form-group info-add-ep hidden">
                        <label class="control-label">Categoria EP:</label>
                        <span id="info_categoria"></span>
                    </div>
                    <div class="form-group info-add-ep hidden">
                        <label class="control-label">Área EP:</label>
                        <span id="info_shape_area"></span>
                    </div>
                    <div class="form-group info-add-ep hidden">
                        <label  class="control-label">Estado Queja:</label>
                        <span id="info_estado"></span>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Nombre:</label>
                        <input type="text" required name="recipient-name" class="form-control" id="recipient_name" value="">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Correo Electrónico:</label>
                        <input type="text" required name="recipient-email" class="form-control" id="recipient_email" value="">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Mensaje:</label>
                        <textarea class="form-control" name="recipient-message-text" id="recipient_message_text" value="" required></textarea>
                    </div>
                    <?php if($is_logged): ?>
                        <div class="form-group">
                            <label for="message-text" class="control-label">Estado:</label>
                            <select class="form-control" name="recipient-estado-id" id="recipient_estado" value="" required>
                                <option value="1"> SIN PROCESAR</option>
                                <option value="2"> EN TRÁMITE</option>
                                <option value="3"> FINALIZADO</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">Respuesta:</label>
                            <textarea class="form-control" name="recipient-respuesta-text" id="recipient_respuesta_text" value="" required></textarea>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Documentos:</label>
                        <input type="file" name="recipient-uploadedimages[]" id="recipient_uploadedimages" multiple/>
                        <span id="helpBlock" class="help-block">Nota: Suportado formatos como: .jpeg, .jpg, .png, .gif y .pdf</span>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" id="buttonSendMessage" class="btn btn-primary">Enviar Queja</button>
                    </div>
                    
                </form>
                <div class="row container-anexos-complain hidden">
                    <div class="col-xs-12">
                        <h5> Anexos </h5>
                    </div>
                    <div class="attachments-complain">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="panel panel-default container-other-complains hidden">
                  
                    <div class="panel-heading">Otras Quejas</div>
                  
                    <div class="list-group">
                      <!-- <a href="#" class="list-group-item">
                        <h4 class="list-group-item-heading">List group item heading</h4>
                        <p class="list-group-item-text">...</p>
                      </a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var setDataFormComplain = function(data, idx_complain_view){
        var is_logged = <?php if($is_logged): echo 1; else: echo 0; endif ?>;

        if(idx_complain_view == undefined){
            idx_complain_view = 0;
        }
        var titleModal = 'Queja - Radicado:';

        if($('#recipient_tipoep_id').val() == 4){
            var titleModal = 'Queja EP Nuevo - Radicado:';
        }
        if( data.quejas != undefined ){

            $('#complainModal .modal-title').html('Queja - Radicado: '+data.quejas[idx_complain_view].radicado+' - Fecha: '+data.quejas[idx_complain_view].fecha)
            $('#recipient_queja_id').val(data.quejas[idx_complain_view].id);
            $('#recipient_name').val(data.quejas[idx_complain_view].solicitante);
            $('#recipient_email').val(data.quejas[idx_complain_view].solicitante_email);
            $('#recipient_message_text').val(data.quejas[idx_complain_view].comentario);
            $('#recipient_estado').val(data.quejas[idx_complain_view].estado_id);
            $('#recipient_respuesta_text').val(data.quejas[idx_complain_view].respuesta);

            var $footer      = $('#complainModal .modal-footer .list-group');
            var $attachments = $('#complainModal .attachments-complain');

            var htmlFooter = '';
            var htmlAttachments = '';
            console.log(data.quejas, idx_complain_view);
            for(var idx_complain = 0; idx_complain < data.quejas.length; idx_complain++){
                
                if(idx_complain == idx_complain_view){
                    continue;
                }
                $('.container-other-complains').removeClass('hidden');
                htmlFooter += '\
                <a href="#" class="list-group-item list-complain-inside-modal" data-frips="'+data.quejas[idx_complain].id+'" data-position="'+idx_complain+'">\
                    <h4 class="list-group-item-heading">'+data.quejas[idx_complain].solicitante+'</h4>\
                    <h4 class="list-group-item-heading">Email: '+data.quejas[idx_complain].solicitante_email+' | Radicado: '+data.quejas[idx_complain].radicado+'</h4>\
                    <p class="list-group-item-text">'+data.quejas[idx_complain].fecha+'</p>\
                </a>';

                console.log(' Anexos ', data.quejas[idx_complain].anexos);
            }

            if(data.quejas[idx_complain_view].anexos != false && data.quejas[idx_complain_view].anexos.length > 0){
                $('.container-anexos-complain').removeClass('hidden');
                for(var idx_attach = 0; idx_attach < data.quejas[idx_complain_view].anexos.length; idx_attach++){
                    htmlAttachments += '\
                    <div class="col-xs-3 col-md-2">\
                        <a href="'+base_url_uploads+'/'+data.quejas[idx_complain_view].anexos[idx_attach].file_path+'" class="thumbnail" target="_blank">\
                          <img src="'+base_url_uploads+'/thumbnails/'+data.quejas[idx_complain_view].anexos[idx_attach].file_path+'" alt="'+data.quejas[idx_complain_view].anexos[idx_attach].fechacreacion+'">\
                        </a>\
                    </div>';
                }
            }
            
            $footer.html(htmlFooter);
            $attachments.html(htmlAttachments);
            $("#buttonSendMessage").html('Modificar Queja');

            $(".list-complain-inside-modal").each(function(){
                $(this).click(function(e){
                    e.preventDefault();
                    console.log(".list-complain-inside-modal");
                    setDataFormComplain(layerSelectedProccessed, $(this).data('position'));
                });
            });
        }else{
            $('.container-anexos-complain').addClass('hidden');
        }
        if(!is_logged)
            $("#buttonSendMessage").addClass('hidden');

        if(data.categoria != undefined){
            $("#info_categoria").parent('div').removeClass('hidden');
            $("#info_categoria").text(data.categoria);
        }

        if(data.escala != undefined){
            $("#info_escala").parent('div').removeClass('hidden');
            $("#info_escala").text(data.escala);
        }

        if(data.fuente != undefined){
            $("#info_fuente").parent('div').removeClass('hidden');
            $("#info_fuente").text(data.fuente);
        }

        if(data.nombre != undefined){
            $("#info_nombre").parent('div').removeClass('hidden');
            $("#info_nombre").text(data.nombre);
        }

        if(data.shape_area != undefined){
            $("#info_shape_area").parent('div').removeClass('hidden');
            $("#info_shape_area").text(data.shape_area);
        }

        if(  data.quejas != undefined && data.quejas[idx_complain_view].estado_nombre != undefined){
            $("#info_estado").parent('div').removeClass('hidden');
            $("#info_estado").text(data.quejas[idx_complain_view].estado_nombre);
        }
    };
</script>