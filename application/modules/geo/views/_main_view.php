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
            <a class="navbar-brand" id="menu_tootle_nav" href="#">Cerrar/Abrir Panel Izquierdo</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Perfil</a></li>
                <li><a href="#">Ayuda</a></li>
            </ul>
            <form class="navbar-form navbar-right">
                <input class="form-control" placeholder="Search..." type="text">
            </form>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div id="wrapper_sidebar" class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <!-- <li class="active" id="menu_tootle"><a href="#">Cerrar Panel <span class="sr-only">(current)</span></a></li> -->
                <li><a href="#" id="create_new_ep"> Crear Nuevo Espacio </a></li>
                <li><a href="#" id="view_new_ep"> Ver Nuevo Espacio </a></li>
                <!-- <li><a href="#">Reports</a></li>
                <li><a href="#">Analytics</a></li>
                <li><a href="#">Export</a></li> -->
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="#" id="view_new_ep"> Listado Quejas Recientes </a></li>
                <?php echo Modules::run('complain/Complain/get_list', $quejas); ?>
            </ul>
        </div>
        <div class="col-sm-9 col-md-10" id='spacepublic'>
            <nav id='menu-ui' class='menu-ui'></nav>
        </div>
        <div class="col-sm-3 col-md-2" id='streetview'>
            <div id="map_streetview"></div>
            <div id="pano_streetview"></div>
        </div>
    </div>
</div>

<script>
    // Add map
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
    var link = document.createElement('a');
            link.href = '#';
            link.className = '';
            link.innerHTML = 'EP Propuesto';

    layers.appendChild(link);

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
                url: base_url+'/index.php/geo/create_ep',    
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
            url: base_url+'/index.php/geo/get_new_eps',
            type: "POST",
            cache: false,
            data: dataRequest
        })
        .done(function( result ) {

            if(result.success == true && result.data.success == 'success'){

                featureLayerEpnuevo.setGeoJSON( result.data.supplemental );

                var layers = featureLayerEpnuevo.getLayers();
                for(var idxLayer in layers){
                    var layer = layers[idxLayer];
                    layer.setStyle({fillColor: '#5B99CE'});
                    layer.on('click', function(e){
                                
                        var $modal = $('#complainModal');
                        if(layerSelectedProccessed != undefined && layerSelectedProccessed.id == layer.feature.id){
                            setDataFormComplain(layerSelectedProccessed, 0);
                        }else{
                            $modal.find('.modal-body input').val('');
                            $modal.find('.modal-body textarea').val('');
                            $modal.find('.modal-title').html('Queja EP Nuevo');
                            $modal.find('#buttonSendMessage').html('Enviar Queja');
                            $modal.find('.modal-footer .list-group').html('');
                            $modal.find('.attachments-complain').html('');
                        }
                        
                        $modal.modal('toggle');
                        console.log(layer.feature);
                        $('#recipient_ref_ep_id').val(layer.feature.id);
                        $('#recipient_tipoep_id').val(4);
                    });
                }
                
                map.addLayer(featureLayerEpnuevo);
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