<style type="text/css">


/*
 * Base structure
 */

/* Move down content because we have a fixed navbar that is 50px tall */
body {
  padding-top: 50px;
}


/*
 * Global add-ons
 */

.sub-header {
  padding-bottom: 10px;
  border-bottom: 1px solid #eee;
}

/*
 * Top navigation
 * Hide default border to remove 1px line.
 */
.navbar-fixed-top {
  border: 0;
}

/*
 * Sidebar
 */

/* Hide for mobile, show later */
.sidebar {
  display: none;
}

.sidebar-toggle {
    display: none !important;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}
/*
@media (max-width: 767px) {
    .sidebar-toggle {
        display: none;
    }
}*/

@media (min-width: 768px) {
    .sidebar {
        position: fixed;
        top: 51px;
        bottom: 0;
        left: 0;
        z-index: 1000;
        display: block;
        padding: 20px;
        overflow-x: hidden;
        overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
        background-color: #f5f5f5;
        border-right: 1px solid #eee;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }
}

/* Sidebar navigation */
.nav-sidebar {
    margin-right: -21px; /* 20px padding + 1px border */
    margin-bottom: 20px;
    margin-left: -20px;
}
.nav-sidebar > li > a {
    padding-right: 20px;
    padding-left: 20px;
}
.nav-sidebar > .active > a,
.nav-sidebar > .active > a:hover,
.nav-sidebar > .active > a:focus {
    color: #fff;
    background-color: #428bca;
}

/*
 * Main content
 */

.main {
    padding: 20px;
}
@media (min-width: 768px) {
    .main {
        padding-right: 40px;
        padding-left: 40px;
    }
}
.main .page-header {
    margin-top: 0;
}


/*
 * Placeholder dashboard ideas
 */

.placeholders {
    margin-bottom: 30px;
    text-align: center;
}
.placeholders h4 {
    margin-bottom: 0;
}
.placeholder {
    margin-bottom: 20px;
}
.placeholder img {
    display: inline-block;
    border-radius: 50%;
}


#spacepublic {
    height: 100%;
}

.spacePublic {
    padding: 6px 8px;
    font: 14px/16px Arial, Helvetica, sans-serif;
    background: white;
    background: rgba(255,255,255,0.8);
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    border-radius: 5px;
}

#map_streetview, #pano_streetview {
    float: left;
    height: 50%;
    width: 100%;
}

#menu_tootle_nav {
    font-size: 14px;
}

/*Creacion menu*/   
.menu-ui{
    position:initial;
    /*top:212px;left:1228px;*/
    font: 15px/17px Arial, Helvetica, sans-serif;
    background:#fff;
    z-index:1;
    border-radius:3px;
    width:129px;
    border:1px solid rgba(0,0,0,0.2);
}

.menu-ui a {
    font-size:15px;
    color:#006600;
    display:block;
    margin:0;padding:0;
    padding:10px;
    text-decoration:none;
    border-bottom:1px solid rgba(0,0,0,0.25);
    text-align:center;
}
.menu-ui a:first-child {
    border-radius:3px 3px 0 0;
}
.menu-ui a:last-child {
    border:none;
    border-radius:0 0 3px 3px;
}
.menu-ui a:hover {
    background:#f8f8f8; /*blanco*/
    color:#02080D; /*negro*/
}
.menu-ui a.active {
    background:#3BB922; /*verde*/
    color:#02080D; /*negro*/
}
.menu-ui a.active:hover {
    background:#CCCCCC; /*gris claro*/
}

.flashdata{
    position: absolute;
    top: 50px;
    right: 20%;
    z-index: 1205;
}

.nav.nav-sidebar{
    padding-left: 12px;
    padding-right: 10px;
}

/*Fin creacion menu*/  

</style>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Exp/No exp navegación</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Sig EP</a>
            <a class="navbar-brand" id="menu_tootle_nav" href="#">Cerrar/Abrir Menú</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php if( $is_logged ): ?>
                    <li><a href="<?php echo base_url('users/auth/logout'); ?>">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="<?php echo base_url('users/auth/login'); ?>">Ingresar al sistema</a></li>
                <?php endif; ?>
                <li><a href="#">Ayuda</a></li>
            </ul>
            <form class="navbar-form navbar-right" onsubmit="return false;">
                <input class="form-control" id="input_search_complain" placeholder="Buscar Radicado..." type="text">
            </form>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div id="wrapper_sidebar" class="col-sm-3 col-md-2 sidebar">
            <!-- <ul class="nav nav-sidebar">
                <li><a href="#" id="create_new_ep"> Crear Nuevo Espacio </a></li>
                <li><a href="#" id="view_new_ep"> Ver Nuevo Espacio </a></li>
            </ul> -->
            <?php if( $is_logged ): ?>
                 <ul class="nav nav-sidebar">
                <!-- <li><a href="#" id="create_new_ep"> Crear Nuevo Espacio </a></li> -->
                <li><a href="#" id="view_new_ep"> Ver Nuevo Espacio </a></li>
                </ul>
                <ul class="nav nav-sidebar">
                    <li><a href="#" id="view_new_ep"> Listado Quejas Recientes </a></li>
                    <?php echo Modules::run('complain/Complain/get_list', $quejas); ?>
                </ul>
            <?php else: ?>
                <ul class="nav nav-sidebar" >
                <h4><b>  Control de Espacio Público </b></h4> 
                                                
                    <h5>
                        <!-- <a href="javascript:void(0);" onclick="window.open('http://localhost/sigep/public/index.php/geo/inicio', 'popup', 'left=190, top=100, width=400, height=500, toolbar=0,  resizable=1')">Inicio</a> -->
                        <a href="javascript:void(0);" onclick="window.open('<?php echo base_url('/geo/inicio'); ?>', 'popup', 'left=190, top=100, width=400, height=500, toolbar=0,  resizable=1')">Inicio</a>
                    </h5>                                                 

                    <li> 
                        <h4><b>  Enlaces de Interés </b></h4>
                        <ul> 
                            <li> <a href="http://www.cali.gov.co/  gobierno/publicaciones/rea_espacio_pblico_pub"> ¿Qué es EP? </a></li>        
                            <li> <a href="http://www.cali.gov.co/loader.php?lServicio=FAQ&lFuncion=viewPreguntas&id=83"> Reglamentación en EP </a></li>
                            <li > <a href="http://idesc.cali.gov.co/download/guias/manual_mecep.pdf"> Manual de Elementos Constitutivos del EP </a></li> 
                            <li> <a href="https://www.minambiente.gov.co/images/AsuntosambientalesySectorialyUrbana/pdf/Gestion_urbana/espacio_publico/CONPES_3718_de_2012_-_Pol%C3%ADtica_Nacional_de_Espacio_P%C3%BAblico.pdf"> Política Nacional de Espacio Público </a></li> 
                            <li> <a href="http://www.cali.gov.co/publicaciones/documentos_de_la_propuesta_de_revisin_y_ajuste_del_pot_de_cali_2013_pub"> POT 2014 </a></li>
                            <li> <a href="http://www.cali.gov.co/publicaciones/propuestas_tematicas_del_pot_pub"> Propuesta Mejoramiento EP </a></li>
                        </ul>
                    </li>

                    <li>
                        <h4><b> Contáctos</b></h4>
                        <ul>
                            <p>  Dependencias</p>
                            <li><a href="http://www.cali.gov.co/planeacion/"> Planeación </a></li>
                            <li><a href="http://www.cali.gov.co/dagma/"> DAGMA </a></li>
                            <br>
                            <p> Entidades Asociadas</p>
                            <li><a href="http://www.emcali.com.co/"> EMCALI</a></li>
                            <li><a href="http://www.metrocali.gov.co/cms/"> MetroCali</a></li>
                            <li><a href="http://www.emru.gov.co/"> EMRU</a></li>

                        </ul>
                    </li>
                    <h4> <b>Radique su solicitud </b></h4>
                    <p style="text-align: justify; margin-right: 0.7em;">Genere su queja al dar clic sobre los polígonos de EP actuales o sobre el poligono de EP creado por usted por motivos de la queja.</p>
                    
                    <li> <a href="#" id="create_new_ep"> Crear EP Nuevo </a> </li>
                    <li> <a href="#" id="view_new_ep"> Ver Nuevo Espacio </a> </li>
                </ul>
            <?php endif; ?>
        </div>
        <div class="col-sm-9 col-md-10" id='spacepublic'>
            <nav id='menu-ui' class='menu-ui'></nav>
        </div>
        <div class="col-sm-3 col-md-2" id='streetview'>
            <div id="map_streetview"></div>
            <div id="pano_streetview"></div>
        </div>
    </div>

    <ul id="contextMenu" class="dropdown-menu" role="menu">
        <li><a tabindex="-1" data-action="trans-to-ep" href="#">Transformar a EP</a></li>
        <li class="divider"></li>
        <li><a tabindex="-1" href="#">Salir</a></li>
    </ul>
</div>

<script>
    // Add map
    var setDataFormNewEp ;
    L.mapbox.accessToken = 'pk.eyJ1IjoieWVyb3Rhem1hMDMiLCJhIjoiY2lqMW4wNWl5MDBic3VhbHo0ZmMyZzQxOSJ9.zMzfDxxgOHUEDSV58s7o1Q';

    var map = L.mapbox.map('spacepublic', 'mapbox.streets', { zoomControl: false })
             .setView([3.4266, -76.5198], 12);

    //OBTENER POSICION ACTUAL        
    L.control.locate({position: 'topright'}).addTo(map);
    L.control.scale({position: 'bottomright'}).addTo(map);

    new L.Control.Zoom({ position: 'topright' }).addTo(map);

    // control that shows state info on hover
    var info = L.control();
    var infoLayers = L.control();

    $(function() {
        $("#menu_tootle").click(function(e){
            e.preventDefault(); toggleSidebarLeft(e);
        });

        $("#menu_tootle_nav").click(function(e){  
            e.preventDefault(); toggleSidebarLeft(e); 
        });

        var toggleSidebarLeft = function(e){
            $("#wrapper_sidebar").toggleClass("sidebar-toggle");
        };

        $('#menu-ui').appendTo('.infoLayers');

        $('#create_new_ep').click(function(e){
            e.preventDefault(); saveLayers();
        });

        $('#view_new_ep').click(function(e){
            e.preventDefault(); toggleNewEp();
        });

        $('#input_search_complain')
        .keyup(function(e){
            e.preventDefault();
            if(e.keyCode == 13 && $(this).val().trim() != ''){
                //$(this).trigger("enterKey");
                retrieveComplainByRadicado($(this).val().trim());
            }
            return false;
        })
        // .bind("enterKey",function(e){
        //     e.preventDefault();
        //     //alert("Enter");
        //     retrieveComplainByRadicado()
        //     return false;
        // });
        ;
    });

    //MENU UI -- CARGA CAPAS
    var layers = document.getElementById('menu-ui');

    var addLayer = function (layer, name, zIndex) {
        layer
        .setZIndex(zIndex)
        .addTo(map)
        map.removeLayer(layer);

        // Create a simple layer switcher that
        // toggles layers on and off.
        var link = document.createElement('a');
            link.href = '#';
            link.className = '';
            link.innerHTML = name;

        link.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();

            if (map.hasLayer(layer)) {
                map.removeLayer(layer);
                this.className = '';

            } else {
                layer.setZIndex(zIndex);
                map.addLayer(layer);
                this.className = 'active';                
            }

        };

        layers.appendChild(link);
    };

    /*
    * TEMPORAL
    */
    // var link = document.createElement('a');
    //         link.href = '#';
    //         link.className = '';
    //         link.innerHTML = 'EP Propuesto';

    // layers.appendChild(link);

    /*
    * TEMPORAL
    */

    /*
    * -----------------------------------------------------------
    * DIBUJAR SOBRE EL MAPA
    * -----------------------------------------------------------
    */
    

    var featureGroup = L.featureGroup().addTo(map);              

    var drawControl = new L.Control.Draw({
        position: 'topright',
        edit: {
          featureGroup: featureGroup
        }
    }).addTo(map);

    map.on('draw:created', function(e) {
          featureGroup.addLayer(e.layer);
          // console.log(e.layer.toGeoJSON());

    });

    var saveLayers = function (){
        var layers;
        var layersGeoJson = Array();

        layers = featureGroup.getLayers();

        console.log(layers);

        for(var idx in layers){
         
            var rect = L.polygon(layers[idx]._latlngs);

            layersGeoJson.push(
                { 
                    geom: JSON.stringify(rect.toGeoJSON().geometry)
                }
            );
        }

        var dataRequest = { layers: layersGeoJson };
        console.log(dataRequest);

        if(layersGeoJson.length > 0){

            $.ajax({
                //url: base_url+'/index.php/geo/create_ep',    
                url: base_url+'/geo/create_ep',    
                type: "POST",
                cache: false,
                data: dataRequest
            })
            .done(function( result ) {

                if(result.success == true && result.data.success == 'success'){

                    console.log(result.data.supplemental);
                    if(map.hasLayer(featureGroup)){
                        var layers = featureGroup.getLayers();
                        for(var idxLayer in layers){
                            featureGroup.removeLayer(layers[idxLayer]);
                        }
                        // map.removeLayer(featureGroup);
                    }
                    if(map.hasLayer(featureLayerEpnuevo)){
                        map.removeLayer(featureLayerEpnuevo);
                    }
                    retrieveNewEp();
                }
                                    
            })
            .fail(function( jqXHR, textStatus ) {
              console.log('fail');
            });
        }
    };

    var toggleNewEp = function(){
        if(map.hasLayer(featureLayerEpnuevo)){
            map.removeLayer(featureLayerEpnuevo);
        }else{
            retrieveNewEp();
        }
    };
    var retrieveNewEp = function(){
        
        var coordinates_center = map.getCenter();                

        var dataRequest = 
        {
            center: {
                lat: coordinates_center.lat, 
                lng: coordinates_center.lng,

            },
            bounds: {
                southwest: {lat: map.getBounds().getSouthWest().lat, lng:  map.getBounds().getSouthWest().lng},
                northeast: {lat: map.getBounds().getNorthEast().lat, lng:  map.getBounds().getNorthEast().lng},
                northwest: {lat: map.getBounds().getNorthWest().lat, lng:  map.getBounds().getNorthWest().lng},
                southeast: {lat: map.getBounds().getSouthEast().lat, lng:  map.getBounds().getSouthEast().lng},
            }
        };
   
        $.ajax({
            //url: base_url+'/index.php/geo/get_new_eps',
            url: base_url+'/geo/get_new_eps',
            type: "POST",
            cache: false,
            data: dataRequest
        })
        .done(function( result ) {

            if(result.success == true && result.data.success == 'success'){

                featureLayerEpnuevo.setGeoJSON( result.data.supplemental );

                featureLayerEpnuevo.eachLayer(function (layer) {
                
                    layer.setStyle({fillColor: '#5B99CE'});        
                    layer.on('click', addEventClickNewEPToOpenComplain);
                    layer.on('contextmenu', addEventRightClickLayerToOpenComplain);
                });
                
                map.addLayer(featureLayerEpnuevo);
            }
        })
        .fail(function( jqXHR, textStatus ) {
          console.log('fail');
        });
    }

    var addEventClickNewEPToOpenComplain = function(e){
        var $modal = $('#complainModal');
        if(layerSelectedProccessed != undefined && layerSelectedProccessed.id == this.feature.properties.id){
            console.log(this.feature.properties, layerSelectedProccessed, 'retrieveNewEp', 'load new ep');
            setDataFormComplain(layerSelectedProccessed, 0);
        }else{
            $modal.find('.modal-body input').val('');
            $modal.find('.modal-body textarea').val('');
            $modal.find('.modal-title').html('Queja EP Nuevo');
            $modal.find('#buttonSendMessage').html('Enviar Queja');
            $modal.find('.modal-footer .list-group').html('');
            $modal.find('.attachments-complain').html('');
        }
        console.log(this.feature.properties.id, 'retrieveNewEp', 'load new ep');
        $modal.modal('toggle');
        
        $('#recipient_ref_ep_id').val(this.feature.id);
        $('#recipient_tipoep_id').val(4);
    };

    var addEventRightClickLayerToOpenComplain = function(e){
        var $menu = $('#contextMenu');
        var eventOriginLayer = e;
        $menu
        .show()
        .css({
            position: "absolute",
            left: getMenuPosition(e.containerPoint.x, 'width', 'scrollLeft'),
            top: getMenuPosition(e.containerPoint.y, 'height', 'scrollTop')
        });

        $menu
        .off('click')
        .on( 'click', "a", function (e) {
            $menu.hide();
            if( 'trans-to-ep' == $(this).data('action')){
                console.log('layer feature', eventOriginLayer);
                setDataFormNewEp(eventOriginLayer.target.feature);
                var $modal = $('#newEPModal');
                $modal.modal('toggle');    
            }
        });

        console.log('right layer', e.containerPoint.x);
    };

    var getMenuPosition = function(mouse, direction, scrollDir) {
        var win = $(window)[direction](),
            scroll = $(window)[scrollDir](),
            menu = $('#contextMenu')[direction](),
            position = mouse + scroll;

        // opening menu would pass the side of the page
        if (mouse + menu > win && menu < mouse) 
            position -= menu;
        console.log(position);
        return position
    };

    var retrieveComplainByRadicado = function(radicado){
        var dataRequest = { radicado: radicado };

        $.ajax({
            //url: base_url+'/index.php/geo/get_new_eps',
            url: base_url+'/complain/get_complain/radicado',
            type: "POST",
            cache: false,
            data: dataRequest
        })
        .done(function( result ) {

            if(result.success == true && result.data.success == 'success'){
console.log(result.data);
                if(result.data.supplemental.geo.features[0] != undefined){
                    var centroid = result.data.supplemental.geo.features[0].properties.centroid.coordinates;
                    var ep_id = result.data.supplemental.geo.features[0].properties.id;
                    var id_tipo = result.data.supplemental.geo.features[0].properties.id_tipo;   

                    map.setView([centroid[1], centroid[0]], 17);

                    var featureLayerTemp;

                    layerSelectedProccessed = result.data.supplemental.geo.features[0].properties;

                   
                    var modified_layer = setTimeout(function(){ change_layer(); }, 700);
///console.log('modified_layer', id_tipo, modified_layer);
                    var change_layer = function(){
                        if(id_tipo == 1){
                            featureLayer.eachLayer(function (layer) {
                                //console.log('layer.properties featureLayer', layer);
                                if(layer.feature.properties.id == ep_id)
                                    layer.setStyle({fillColor: '#5B77DE'});
                            });

                        } else if(id_tipo == 4){
                            var layersLoaded = featureLayerEpnuevo.getLayers();
                            var layerDisplayed = false;
                            if(layersLoaded.length > 0){
                                featureLayerEpnuevo.eachLayer(function (layer) {
                                    if(ayer.feature.properties.id == ep_id)
                                        layerDisplayed = true;
                                });
                            }
//console.log('layerDisplayed', layerDisplayed);
                            if(!layerDisplayed){
                                console.log('create new layer to see the complain', result.data.supplemental.geo);
                                featureLayerTemp = featureLayerEpnuevo;
                                featureLayerTemp.setGeoJSON( result.data.supplemental.geo );

                                featureLayerTemp.eachLayer(function (layer) {
                                    layer.setStyle({fillColor: '#5B77DE'});
                                    layer.on('click', addEventClickLayerToOpenComplain);
                                });
                                map.addLayer(featureLayerTemp);
                            }
                        }
                    };
                }
            }
        })
        .fail(function( jqXHR, textStatus ) {
          console.log('fail');
        });
    }

    /*
    * -----------------------------------------------------------
    * DIBUJAR SOBRE EL MAPA
    * -----------------------------------------------------------
    */
</script>