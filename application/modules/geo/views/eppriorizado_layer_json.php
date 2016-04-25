<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<html>
    <head>
        <!-- <meta charset="utf-8"> -->
        <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
        <title>SIG - EP</title>
        <script type="text/javascript" src="https://api.mapbox.com/mapbox.js/v2.2.4/mapbox.js?ver=4.3.1"></script>
        <!-- <script type="text/javascript" src="https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js?ver=4.3.1"></script> -->
        <link href='https://api.mapbox.com/mapbox.js/v2.2.4/mapbox.css' rel='stylesheet' />
        <!-- <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.css' rel='stylesheet' />
        <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.Default.css' rel='stylesheet' /> -->
        <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>


        <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-label/v0.2.1/leaflet.label.js'></script>
        <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-label/v0.2.1/leaflet.label.css' rel='stylesheet'/> 


        <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/css/font-awesome.min.css' rel='stylesheet' />
        <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.min.js'></script>
        <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.mapbox.css' rel='stylesheet' />


        <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-draw/v0.2.3/leaflet.draw.css' rel='stylesheet' />
        <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-draw/v0.2.3/leaflet.draw.js'></script>


        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>



        <style type="text/css">
            html, body{
                height: 100%;
                background-color: #BDB76B;
            }


            #encabezado {
                height: 15%;
                width: 90%;
                align: center;
                float: top;
            }  

            #div_pop_click
            {
                height: 500px;
                width: 600px;
                
            }

            #espizq {
                height: 85%;
                width: 25%;
                float: left;
                margin: auto;
                font-family: Arial, Helvetica, sans-serif;  
                font-size: 20;              
            }  

            ul, ol
            {
                list-style: none;
            }
            

            .herramienta li  {
                background-color: #80FF00
                color: #000000;
                text-decoration:none;
                padding:8px 12px;
                display:block;
            }

            /*.herramienta li a {
                background-color: #80FF00
                color: #000000;
                text-decoration:none;
                padding:8px 12px;
                display:block;
            }*/

            .herramienta li a:hover {
                background-color: #E0E0E0;                
            }

            .herramienta li ul {
                display:none;
                position:30%;
                min-width:50px;
            }

            .herramienta li:hover > ul {
                display:block;
            }
            

            #spacepublic {
                height: 85%;
                width: 50%;
                float: left;
            }

            #espint {
                height: 85%;
                width: 1%;
                float: left;
            }  

            #streetview {
                height: 85%;
                width: 20%;
                float: left;
            }

            #espder {
                height: 85%;
                width: 4%;
                float: left;
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

            /*Creacion menu*/   
            .menu-ui{
            position:absolute;
            top:212px;left:1228px;
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
        
        

    </head>


    <body>


        <div>

            <div id='encabezado'>
               
                <body>

                    <div style="text-align: center;"><big><span
                         style="color: rgb(0, 128, 0);"><span
                         style="font-weight: bold;"><big
                         style="font-family: AR CHRISTY;"><big><big>&nbsp;&nbsp;Sistema
                        de Informaci&oacute;n Geogr&aacute;fica de Control de Espacio P&uacute;blico <br>
                        Santiago de Cali



                    </div>

                  <!-- <img src="img/AlcaldiaCali.jpg" alt="Logo Alcaldia" width="280" height="51">   -->




                  <!--   <div style="text-align: left;"><img style="width: 129px; height: 95px;" alt="Logo Alcaldia"
                    src="C:\xampp\htdocs\sigep\application\modules\geo\views\AlcaldiaCali.jpg">
                    </div>



                    <div style="text-align: left;"><img style="width: 129px; height: 95px;" alt="Logo Alcaldia"
                    src="file:///D:/proyectoSIG/img/LogoCalida.jpg">
                    </div>

                    <div style="text-align: left;"><img style="width: 129px; height: 95px;" alt="Logo Alcaldia"
                    src="file:///D:/proyectoSIG/img/UManizales.jpg">
                    </div> -->

                </body>


            </div>



            <div id='espizq' >
            <body>

                    <h2><b>  Control de Espacio Público </b></h2> 
                        <ul class= "herramienta">                          

                            <div>  <button class="btn btn-success btn-md">Inicio</button> </div>

                            <div>   <button onclick="saveLayers()">Guardar EpNuevo</button>
                            </div>

                        

                            <li> <a href="">Enlaces de Interés</a>
                                <ul>    <li> <a href="http://www.cali.gov.co/gobierno/publicaciones/rea_espacio_pblico_pub"> ¿Qué es EP? </a></li>        <li> <a href="http://www.cali.gov.co/loader.php?lServicio=FAQ&lFuncion=viewPreguntas&id=83"> Reglamentación en EP </a></li>
                                        <li> <a href="http://idesc.cali.gov.co/download/guias/manual_mecep.pdf"> Manual de Elementos Constitutivos del EP </a></li> 
                                        <li> <a href="https://www.minambiente.gov.co/images/AsuntosambientalesySectorialyUrbana/pdf/Gestion_urbana/espacio_publico/CONPES_3718_de_2012_-_Pol%C3%ADtica_Nacional_de_Espacio_P%C3%BAblico.pdf"> Política Nacional de Espacio Público </a></li> 
                                        <li> <a href="http://www.cali.gov.co/publicaciones/documentos_de_la_propuesta_de_revisin_y_ajuste_del_pot_de_cali_2013_pub"> POT 2014 </a></li>
                                        <li> <a href="http://www.cali.gov.co/publicaciones/propuestas_tematicas_del_pot_pub"> Propuesta Mejoramiento EP </a></li>        
                                        
                                </ul>
                            </li>

                            <li><a href=""> Contáctos</a>
                                    <ul>
                                        <p> <b> Dependencias</b></p>
                                        <li><a href="http://www.cali.gov.co/planeacion/"> Planeación </a></li>
                                        <li><a href="http://www.cali.gov.co/dagma/"> DAGMA </a></li>
                                        <p> <b>Entidades Asociadas</b></p>
                                        <li><a href="http://www.emcali.com.co/"> EMCALI</a></li>
                                        <li><a href="http://www.metrocali.gov.co/cms/"> MetroCali</a></li>
                                        <li><a href="http://www.emru.gov.co/"> EMRU</a></li>

                                    </ul>
                            </li>

                            <h3> <b>Radique su solicitud </b></h3>
                            <li><a href=""> Formulario solicitud</a></li>
                            <li><a href=""> Estado en trámite</a></li>


                            <h3><b> Ingresar al Sistema </b></h3>       
                            <p>   Usuario: <br> Contraseña: </p>  

                        </ul>    

                   
                 
                <div id="div_pop_click" class="hidden">
                    <div>
                        <h5>
                        <p style="text-align: justify;">
                        En la ciudad de Cali, dentro del proceso de radicación del actual Plan de Ordenamiento Territorial (POT2014), se entrega el plan de revisión y ajuste del POT con la socialización del proyecto a partir de las “Charlas Temáticas del POT” (Planeación Municipal A. d., 2013) en el cual se da a conocer la problemática actual de la ciudad bajo el análisis de las distintas secretarias incluida la Secretaria de Ordenamiento Urbanístico (SOU) con su dependencia de ordenamiento del espacio público. En esta se revelan los factores  que no permiten el correcto ejercicio y mantenimiento de los espacios públicos, como una de los causas desequilibrantes en el correcto ejercicio de la planificación del espacio, factores a los que se suma la falta de personal que realice las labores pertinentes como miembro oficial de la administración municipal, así como la desactualización del inventario  de espacio público en Cali y regularización de la norma de uso a partir de la divulgación de la misma. Algunos de los factores adversos son los que se mencionan a continuación:
                        <br>  <br>   
                        •   Expansión urbana descontrolada y en zonas expuestas.<br> <br>
                        •   Explotación económica desordenada con invasión de espacio público.<br> <br>
                        •   Dificultades institucionales en financiamiento, asistencia técnica, gestión, información, planeación y control.<br> <br>
                        •   Imprecisión en conceptos, normas y clasificación de componentes de EP.<br> <br>
                        •   Falta de apropiación colectiva de los espacios públicos y dificultades para conciliar los intereses públicos y privados.<br> <br>

                        Estas limitantes van en contraparte del cumplimiento de la meta que tiene Santiago de Cali para el 2020, en miras de establecer un índice de Espacio Público Efectivo alrededor de los 6 m2 por ciudadano. Por lo cual, el Sistema de Información Geográfica de Control de Espacio Público, provee un inventario de áreas de espacio público actualizado para ciudad de Santiago de Cali con información actual, propuesta y priorizada, esto como una medida de inclusión de las partes involucradas estado – ciudadanía en la identificación, mantenimiento y regulación de los espacios de aprovechamiento colectivo. Viéndose a su vez como una plataforma que impulse a la concientización ciudadana en el conocimiento de los espacios concebidos como públicos en acompañamiento de las normas que lo regulan, esto en la medida de garantizar el restablecimiento de los derechos a quienes se encuentren afectados por el mal uso de los mismos y la preservación y apersonamiento de dichos espacios promoviendo el uso justo y transparente de los recursos.
                        </p>
                        </h5>

                    </div>
                    <!-- <div>
                      <img width="100px" src="https://lh6.googleusercontent.com/-JI0IA4lmboM/U-76Cn5L9GI/AAAAAAAACYg/H_vymb4pV_0DJ3AFyhdaX12ue9fqcZLkgCL0B/w822-h819-no/IMG_20140617_135914.jpg">
                    </div> -->
    
                </div>

            </body>

            </div>

            <div id='spacepublic'> </div>
            <div id='espint'></div>
            <div id='streetview'>
                <div id="map_streetview"></div>
                <div id="pano_streetview"></div>
            </div>
            <div id='espder'></div>


            <nav id='menu-ui' class='menu-ui'></nav>

        </div>

        <script type="text/javascript">
            var geojsonEpriorizado;
            var geojsonEpropuesto;
            var geojsonComuna;
            var geojsonBarrio;
            var geojsonNuevo;
            var geojsonEp;
            var featureLayer = L.mapbox.featureLayer();
            var featureLayerEp = L.mapbox.featureLayer();
            var featureLayerEprio = L.mapbox.featureLayer();
            var featureLayerEprop = L.mapbox.featureLayer();
            var featureLayerComuna = L.mapbox.featureLayer();
            var featureLayerEpnuevo = L.mapbox.featureLayer();
            var panorama;
            var mapGoogleMaps;

            function style(feature) {                
                return {
                   
                    fillColor: feature.properties.color,
                    weight: 1,
                    opacity: 0.8,
                    //color: 'black',
                    color: feature.properties.color,
                    dashArray: '1',
                    //fillOpacity: 0
                };
            }

            //ESTILO BARRIO
            function highlightFeature(e) {
                var layerBarrio = e.target;

                layerBarrio.setStyle({
                    weight: 3,
                    color: '#6C706F',
                    dashArray: '',
                    Opacity: 0.2,
                    fillOpacity: 0.2
                });

                if (!L.Browser.ie && !L.Browser.opera) {
                    layerBarrio.bringToFront();
                }
                
                info.update(layerBarrio.feature.properties);
            }

            function resetHighlight(e) {
                
                geojsonBarrio.resetStyle(e.target);
                
                info.update();
            }

            function zoomToFeature(e) {
                //console.log(e.containerPoint.toString() + ', ' + e.latlng.toString(), e.latlng.lat, e.latlng.lng);
                //map.fitBounds(e.target.getBounds());
                countryClicked = true;
                updateStreetView(e);
            }

            function onEachFeature(feature, layer) {
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                    click: zoomToFeature
                });
            }


            //ESTILO COMUNA
            function highlightFeatureComuna(e) {
                var layerComuna = e.target;
                
                layerComuna.setStyle({
                    weight: 4,
                    color: '#006633',
                    dashArray: '',
                    Opacity: 1.0,
                    //fillOpacity: 0.1

                });

                if (!L.Browser.ie && !L.Browser.opera) {
                    layerComuna.bringToFront();
                }
                
                info.update(layerComuna.feature.properties);
            }

            function resetHighlightComuna(e) {
                
                geojsonComuna.resetStyle(e.target);
                info.update();
            }

            function zoomToFeatureComuna(e) {
                
                //map.fitBounds(e.target.getBounds());
                countryClicked = true;
                updateStreetView(e);
            }

            function onEachFeatureComuna(feature, layer) {
                layer.on({
                    mouseover: highlightFeatureComuna,
                    mouseout: resetHighlightComuna,
                    click: zoomToFeatureComuna
                });
            }


            //ESTILO EPRIORIZADO
            function highlightFeatureEpriorizado(e) {
                var layerEpriorizado = e.target;
                
                layerEpriorizado.setStyle({
                    weight: 3,
                    color: '#CC0000',
                    dashArray: '',
                    Opacity: 1.0,
                    fillOpacity: 0.1

                });

                if (!L.Browser.ie && !L.Browser.opera) {
                    layerEpriorizado.bringToFront();
                }
                
                info.update(layerEpriorizado.feature.properties);

            }

            function resetHighlightEpriorizado(e) {
                
                geojsonEpriorizado.resetStyle(e.target);
                
                info.update();
            }

            function zoomToFeatureEpriorizado(e) {
                
                countryClicked = true;
                updateStreetView(e);
            }

            function onEachFeatureEpriorizado(feature, layer) {
                layer.on({
                    mouseover: highlightFeatureEpriorizado,
                    mouseout: resetHighlightEpriorizado,
                    click: zoomToFeatureEpriorizado
                });
            }

            //ESTILO EPROPUESTO
            function highlightFeatureEpropuesto(e) {
                var layerEpropuesto = e.target;
                
                layerEpropuesto.setStyle({
                    weight: 3,
                    color: '#A87000',
                    dashArray: '',
                    Opacity: 1.0,
                    fillOpacity: 0.1

                });

                if (!L.Browser.ie && !L.Browser.opera) {
                    layerEpropuesto.bringToFront();
                }
                
                info.update(layerEpropuesto.feature.properties);

            }

            function resetHighlightEpropuesto(e) {
                
                geojsonEpropuesto.resetStyle(e.target);
                
                info.update();
            }

            function zoomToFeatureEpropuesto(e) {
                
                countryClicked = true;
                updateStreetView(e);
            }

            function onEachFeatureEpropuesto(feature, layer) {
                layer.on({
                    mouseover: highlightFeatureEpropuesto,
                    mouseout: resetHighlightEpropuesto,
                    click: zoomToFeatureEpropuesto
                });
            }


            //ESTILO EPNUEVO
            function highlightFeatureEpnuevo(e) {
                var layerEpnuevo = e.target;
                
                layerEpnuevo.setStyle({
                    weight: 3,
                    color: '#7F00FF',
                    dashArray: '',
                    Opacity: 1.0,
                    fillOpacity: 0.1

                });

                if (!L.Browser.ie && !L.Browser.opera) {
                    layerEpnuevo.bringToFront();
                }
                
                info.update(layerEpnuevo.feature.properties);

            }

            function resetHighlightEpnuevo(e) {
                
                geojsonNuevo.resetStyle(e.target);
                
                info.update();
            }

            function zoomToFeatureEpnuevo(e) {
                
                countryClicked = true;
                updateStreetView(e);
            }

            function onEachFeatureEpnuevo(feature, layer) {
                layer.on({
                    mouseover: highlightFeatureEpnuevo,
                    mouseout: resetHighlightEpnuevo,
                    click: zoomToFeatureEpnuevo
                });
            }



            var spacepublic = {
                barrio: '<?php echo json_encode($geojsonbarrio); ?>',
                comuna : '<?php echo json_encode($geojsoncomuna); ?>',               
                epropuesto : '<?php echo json_encode($geojsonepropuesto); ?>',
                epriorizado : '<?php echo json_encode($geojsonepriorizado); ?>',
                epnuevo : '<?php echo json_encode($geojsonepnuevo); ?>'
                                
            };

            // //Add map
            L.mapbox.accessToken = 'pk.eyJ1IjoieWVyb3Rhem1hMDMiLCJhIjoiY2lqMW4wNWl5MDBic3VhbHo0ZmMyZzQxOSJ9.zMzfDxxgOHUEDSV58s7o1Q';

            // var map = L.mapbox.map('spacepublic', 'mapbox.streets',{maxZoom:12, minZoom:4})
            //     .setView([31.783300, 35.216700], 3);
            // var map = L.mapbox.map('spacepublic', 'mapbox.streets', {zoomControl: false})
            var map = L.mapbox.map('spacepublic', 'mapbox.streets')
                 
                 .setView([3.4266, -76.5198], 12);

            //OBTENER POSICION ACTUAL        
            L.control.locate({position: 'topright'}).addTo(map);
            L.control.scale().addTo(map);
            // L.control.Zoom({position: 'topright'}).addTo(map);
            


           
            //ACTIVAR LABEL                 

            //MENU UI -- CARGA CAPAS
            var layers = document.getElementById('menu-ui');
                                         
            // control that shows state info on hover
            var info = L.control();

            info.onAdd = function(map) {
                this._div = L.DomUtil.create('div', 'spacePublic');
                this.update();
                return this._div;
            };

            info.update = function(props) {
                
                this._div.innerHTML = '<h4>Barrio/Comuna :</h4>'+ (props ? '<b>' + props.id  + '</b><br />' :  'Mueva el cursor sobre </b><br />la capa ');
                console.log(props);

            };

            info.addTo(map);

            geojsonBarrio = L.geoJson( JSON.parse(spacepublic.barrio), 
                                    {
                                        style: style, 
                                        onEachFeature: onEachFeature
                                    } 
                                )
            addLayer(geojsonBarrio, 'Barrio',  1);
            //map.addLayer(geojsonBarrio);

            geojsonComuna = L.geoJson( JSON.parse(spacepublic.comuna), 
                                    {
                                        style: style, 
                                        onEachFeature: onEachFeatureComuna
                                    } 
                                )
            addLayer(geojsonComuna, 'Comuna', 2);

            geojsonEpriorizado = L.geoJson( JSON.parse(spacepublic.epriorizado), 
                                    {
                                        style: style, 
                                        onEachFeature: onEachFeatureEpriorizado
                                    } 
                                )
            addLayer(geojsonEpriorizado, 'EP priorizado', 3);

            geojsonEpropuesto = L.geoJson( JSON.parse(spacepublic.epropuesto), 
                                    {
                                        style: style, 
                                        onEachFeature: onEachFeatureEpropuesto
                                    } 
                                )
            addLayer(geojsonEpropuesto, 'EP propuesto', 4);

            geojsonNuevo = L.geoJson( JSON.parse(spacepublic.epnuevo), 
                                    {
                                        style: style, 
                                        onEachFeature: onEachFeatureEpnuevo
                                    } 
                                )
            addLayer(geojsonNuevo, 'EP nuevo', 5);

            
            map.on('moveend', function() {
                
                if (map.getZoom() > 14) {
                    retrieveEp();
                    
                } 
               
                else {
                    map.featureLayer.setFilter(function() { return false; });

                    map.removeLayer(featureLayer);
                    map.removeLayer(featureLayerEp);
                    
                }
            });
            
            map.on('click', function(e) {
                
                updateStreetView(e);

            });

            /*map.on('zoomend', function() {
              
                // (map.getZoom > 10)
                if (map.getZoom() > 13) {
                    retrieveEp();
                    
                } 
               
                else {
                    map.featureLayer.setFilter(function() { return false; });

                    map.removeLayer(featureLayer);
                    map.removeLayer(featureLayerEp);
                    
                }

                //console.log('center', map.getCenter());
            });    */ 

            /*------*/
            function addLayer(layer, name, zIndex) {
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
                        map.addLayer(layer);
                        this.className = 'active';                
                    }

                };

                layers.appendChild(link);

            }

            /*------*/
            function retrieveEp(){
                
            
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
                    url: 'http://localhost/sigep/public/index.php/geo/get_ep',    
                    type: "POST",
                    cache: false,
                    data: dataRequest
                })
                .done(function( result ) {

                    if(result.success == true && result.data.success == 'success'){

                        
                        featureLayerEp.setGeoJSON( result.data.supplemental );
                        map.addLayer(featureLayerEp);
                    }
                })
                .fail(function( jqXHR, textStatus ) {
                  console.log('fail');
                });

                

            }

            /*
            * Google maps
            */

            function initialize() {
             
                console.log('lat ' + map.getCenter().lat, 'lng ' + map.getCenter().lng);
               
                var fenway = {lat: map.getCenter().lat, lng: map.getCenter().lng};
               

                mapGoogleMaps = new google.maps.Map(document.getElementById('map_streetview'), {
                    center: fenway,
                    // zoom: 14,
                    zoom: map.getZoom(),
                    mapTypeId: google.maps.MapTypeId.SATELLITE
                });
                //mapGoogleMaps.setMapTypeId(google.maps.MapTypeId.SATELLITE);


                panorama = new google.maps.StreetViewPanorama(
                    document.getElementById('pano_streetview'), {
                        position: fenway,
                        pov: {
                            heading: 34,
                            pitch: 10
                        }
                    }
                );

                mapGoogleMaps.setStreetView(panorama);
            }

            function updateStreetView(e){
                console.log(e.containerPoint.toString() + ', ' + e.latlng.toString(), e.latlng.lat, e.latlng.lng);
                var astorPlace = {lat: e.latlng.lat, lng: e.latlng.lng};
                panorama.setPosition(astorPlace);
                panorama.setPov(/** @type {google.maps.StreetViewPov} */({
                    heading: 34,
                    pitch: 10
                }));
                panorama.setVisible(true);

                var fenway = {lat: e.latlng.lat, lng: e.latlng.lng};
                mapGoogleMaps.setCenter(fenway);

                mapGoogleMaps.setZoom(map.getZoom());
            }

            /*------*/
            //DIBUJAR SOBRE EL MAPA

            var featureGroup = L.featureGroup().addTo(map);              

            var drawControl = new L.Control.Draw({
                  edit: {
                  featureGroup: featureGroup
                    }
            }).addTo(map);

            map.on('draw:created', function(e) {
                  featureGroup.addLayer(e.layer);
                  // console.log(e.layer.toGeoJSON());

            });
            
            
            /*------*/

            function saveLayers(){
                var layers;
                var layersGeoJson = Array();

                layers = featureGroup.getLayers();

                console.log(layers);

                for(var idx in layers){
                    // layersGeoJson.push(JSON.stringify(layers[idx].toGeoJson()));
                    
                    var rect = L.polygon(layers[idx]._latlngs);

                    // layersGeoJson.push({geom: JSON.stringify(rect.toGeoJSON())});
                    layersGeoJson.push({geom: JSON.stringify(rect.toGeoJSON().geometry)});


                }

                var dataRequest = {layers: layersGeoJson};
                    console.log(dataRequest);


                $.ajax({
                    url: 'http://localhost/sigep/public/index.php/geo/create_ep',    
                    type: "POST",
                    cache: false,
                    data: dataRequest
                })
                .done(function( result ) {

                    if(result.success == true && result.data.success == 'success'){

                        // console.log(result.data);
                    }
                                        
                })
                .fail(function( jqXHR, textStatus ) {
                  console.log('fail');
                });
            }


        </script>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCy7nk1vOuAlQvWoGZXK9rqeMq23R3SP7Y&signed_in=true&callback=initialize"

            type="text/javascript">
        </script>

        <script>
            $(document).ready(function(){
            var $divDetails = $("#div_pop_click");
                
                $('.btn-success').popover({
                    title: "Información General",
                    html : true,
                    size: 20,
                    bold: true,

                    content : function() {
                        $divDetails.removeClass("hidden");
                        return $divDetails;
                    },
                    trigger: "click"
                }); 
                
            });
        </script>



    </body>
</html> 
