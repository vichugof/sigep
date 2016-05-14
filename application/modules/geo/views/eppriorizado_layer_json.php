<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<html>
    <head>
        <!-- <meta charset="utf-8"> -->
        <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
        <title>Welcome</title>
        <script type="text/javascript" src="https://api.mapbox.com/mapbox.js/v2.2.4/mapbox.js?ver=4.3.1"></script>
        <link href='https://api.mapbox.com/mapbox.js/v2.2.4/mapbox.css' rel='stylesheet' />
        <!-- <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">-->
        <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">

        <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
         <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
        <!-- <script src="http://localhost/~vichugof/sigep/assets/bootstrap/js/bootstrap.min.js"></script> -->

        <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/css/font-awesome.min.css' rel='stylesheet' />
        <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.min.js'></script>
        <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.mapbox.css' rel='stylesheet' />


        <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-draw/v0.2.3/leaflet.draw.css' rel='stylesheet' />
        <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-draw/v0.2.3/leaflet.draw.js'></script>

    </head>

    <body>
        <?php echo Modules::run('geo/Public_Space/get_main_view', array()); ?>
        <script type="text/javascript">
            var geojsonEpriorizado;
            var geojsonEpropuesto;
            var geojsonComuna;
            var geojsonBarrio;
            var geojsonNuevo;
            var geojsonEp;
            var featureLayer = L.mapbox.featureLayer();
            var featureLayerEpnuevo = L.mapbox.featureLayer();
            var panorama;
            var mapGoogleMaps;
            var layerSelectedProccessed;
            var base_url_uploads = '<?php echo $base_url_uploads; ?>';
            var base_url = '<?php echo $base_url; ?>';

            function style(feature) {
                return {
                    // fillColor: '#df65b0',
                    fillColor: feature.properties.color,
                    weight: 2,
                    opacity: 1,
                    //color: 'white',
                    color: 'black',
                    dashArray: '3',
                    // fillOpacity: 0.8
                    fillOpacity: 0.1
                };
            }

            function highlightFeature(e) {
                var layer = e.target;

                layer.setStyle({
                    weight: 3,
                    color: '#5D4C59',
                    dashArray: '',
                    fillOpacity: 0.7
                });

                if (!L.Browser.ie && !L.Browser.opera) {
                    layer.bringToFront();
                }
                
                info.update(layer.feature.properties);
            }

            function resetHighlight(e) {
                // geojsonEpriorizado.resetStyle(e.target);
                geojsonBarrio.resetStyle(e.target);
                //geojsonbarrio.resetStyle(e.target);
                info.update();
            }

            function zoomToFeature(e) {
                //console.log(e.containerPoint.toString() + ', ' + e.latlng.toString(), e.latlng.lat, e.latlng.lng);
                map.fitBounds(e.target.getBounds());
                countryClicked = true;
                updateStreetView(e);
            };

            function onEachFeature(feature, layer) {
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                    click: zoomToFeature
                });
            };

             /*
            * ---------------------------------------------------------
            * Comuna
            * ---------------------------------------------------------
            */
            function zoomToFeatureComuna(e) {
                
                countryClicked = true;
                updateStreetView(e);
            };

            function onEachFeatureComuna(feature, layer) {
                layer.on({
                    mouseover: highlightFeatureComuna,
                    mouseout: resetHighlightComuna,
                    click: zoomToFeatureComuna
                });
            };

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
            };

            function resetHighlightComuna(e) {
                
                geojsonComuna.resetStyle(e.target);
                info.update();
            };

            /*
            * ---------------------------------------------------------
            * Eppriorizado
            * ---------------------------------------------------------
            */

            function onEachFeatureEpriorizado(feature, layer) {
                layer.on({
                    mouseover: highlightFeatureEpriorizado,
                    mouseout: resetHighlightEpriorizado,
                    click: zoomToFeatureEpriorizado
                });
            };

            function zoomToFeatureEpriorizado(e) {
                
                countryClicked = true;
                updateStreetView(e);
            };

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

            };

            function resetHighlightEpriorizado(e) {
                
                geojsonEpriorizado.resetStyle(e.target);
                
                info.update();
            };


            
            // // //Add map
            // L.mapbox.accessToken = 'pk.eyJ1IjoieWVyb3Rhem1hMDMiLCJhIjoiY2lqMW4wNWl5MDBic3VhbHo0ZmMyZzQxOSJ9.zMzfDxxgOHUEDSV58s7o1Q';

            // var map = L.mapbox.map('spacepublic', 'mapbox.streets', { zoomControl: false })
            //      .setView([3.4266, -76.5198], 12);

            // new L.Control.Zoom({ position: 'topright' }).addTo(map);

            // // control that shows state info on hover
            // var info = L.control();
            // var infoLayers = L.control();

            info.onAdd = function(map) {
                this._div = L.DomUtil.create('div', 'spacePublic');
                this.update();
                return this._div;
            };

            infoLayers.onAdd = function(map) {
                this._div = L.DomUtil.create('div', 'infoLayers');
                // this.update();
                return this._div;
            };

            info.update = function(props) {
                //this._div.innerHTML = '<h4>Number of space public</h4>' + (props ? '<b>' + props.name + '</b><br />' + props.numberOfStudies + ' Studies' : 'Hover over a layer');
                //this._div.innerHTML = '<h4>Espacio Público</h4>'+ (props ? '<b>' + props.nombre + '</b><br /><br /> Cod. Barrio: ' + props.cod_barrio : 'Hover over a layer');
                this._div.innerHTML = '<h4>Espacio Público</h4>'+ (props ? '<b>' + props.nombre + '</b><br />' : 'Hover over a layer');
                console.log(props);
            };

            info.addTo(map);
            infoLayers.addTo(map);

            var spacepublic = {
                barrio: '<?php echo json_encode($geojsonbarrio); ?>',
                comuna : '<?php echo json_encode($geojsoncomuna); ?>',               
                epriorizado : '<?php echo json_encode($geojsonepriorizado); ?>',
            };


            geojsonBarrio = L.geoJson( JSON.parse(spacepublic.barrio), 
                                    {
                                        style: style, 
                                        onEachFeature: onEachFeature
                                    } 
                                )
            addLayer(geojsonBarrio, 'Barrio',  1);

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

            map.on('moveend', function() {
                if (map.getZoom() > 15) {
                    retrieveEp();
                }else {
                    map.featureLayer.setFilter(function() { return false; });
                    map.removeLayer(featureLayer);
                }
            });
            
            map.on('click', function(e) {
                updateStreetView(e);

            });

            
            function retrieveEp(){
                // setFilter is available on L.mapbox.featureLayers only. Here
                // we're hiding and showing the default marker layer that's attached
                // to the map - change the reference if you want to hide or show a
                // different featureLayer.
                // If you want to hide or show a different kind of layer, you can use
                // similar methods like .setOpacity(0) and .setOpacity(1)
                // to hide or show it.

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

                console.log(dataRequest.center);

                $.ajax({
                    url: base_url+'/index.php/geo/get_ep',    
                    type: "POST",
                    cache: false,
                    data: dataRequest
                })
                .done(function( result ) {

                    if(result.success == true && result.data.success == 'success'){

                        featureLayer.clearLayers();
                        featureLayer.setGeoJSON( result.data.supplemental );
                        featureLayer.eachLayer(function (layer) {

                            layer.on('click', function(e){
                                
                                var $modal = $('#complainModal');
                                if(layerSelectedProccessed != undefined && layerSelectedProccessed.id == layer.feature.id){
                                    setDataFormComplain(layerSelectedProccessed, 0);
                                }else{
                                    $modal.find('.modal-body input').val('');
                                    $modal.find('.modal-body textarea').val('');
                                    $modal.find('.modal-title').html('Queja');
                                    $modal.find('#buttonSendMessage').html('Enviar Queja');
                                    $modal.find('.modal-footer .list-group').html('');
                                    $modal.find('.attachments-complain').html('');
                                }
                                
                                $modal.modal('toggle');
                                console.log(layer.feature);
                                $('#recipient_ref_ep_id').val(layer.feature.id);
                                $('#recipient_tipoep_id').val(1);
                            });
                        });

                        map.addLayer(featureLayer);
                        featureLayer.bringToFront();

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
                //var fenway = {lat: 42.345573, lng: -71.098326};
                console.log('lat ' + map.getCenter().lat, 'lng '+ map.getCenter().lng);
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

            function retrieveComplain(featureLayer){
                featureLayer.geometry = null;
                featureLayer.properties.geom = null;

                dataRequest = {
                    ep_id: featureLayer.id,
                    properties: featureLayer.properties
                };

                $.ajax({
                    url: base_url+'/index.php/complain/get',    
                    type: "POST",
                    cache: false,
                    data: dataRequest
                })
                .done(function( result ) {

                    if(result.success == true && result.data.success == 'success'){
                        console.log(result.data.supplemental);
                    }
                })
                .fail(function( jqXHR, textStatus ) {
                    console.log('fail');
                });
            }

            $(function() {
                $('#complainModal').modal({
                  keyboard: true,
                  show: false
                });

                $(".list-complain-sigep").each(function(){
                    $(this).click(function(e){
                        e.preventDefault();
                        var frip = $(this).data('frips');
                        var tipoepId = $(this).data('tipoepid');
                        var dataRequest = {
                            ep_id: frip,
                            tipoep_id: tipoepId,
                        };
                        $.ajax({
                            url: base_url+'/index.php/geo/get_ep/centroid',    
                            type: "POST",
                            cache: false,
                            data: dataRequest
                        })
                        .done(function( result ) {

                            if(result.success == true && result.data.success == 'success'){
                                //console.log(result.data.supplemental);

                                if(result.data.supplemental.features[0] != undefined){
                                    var centroid = result.data.supplemental.features[0].properties.centroid.coordinates;
                                    var ep_id = result.data.supplemental.features[0].id;
                                    var id_tipo = result.data.supplemental.features[0].properties.id_tipo;
                                    //console.log(result.data.supplemental.features[0].properties.centroid.coordinates);    

                                    map.setView([centroid[1], centroid[0]], 17);

                                    layerSelectedProccessed = result.data.supplemental.features[0].properties;

                                    var modified_layer = setTimeout(function(){ change_layer(); }, 700);

                                    var change_layer = function(){
                                        var layersLoaded = featureLayer.getLayers();
                                        var flagIsFeatureLayer = false;
                                        for (var idx_layer in layersLoaded){
                                            if(layersLoaded[idx_layer].feature.id == ep_id && layersLoaded[idx_layer].feature.id_tipo == id_tipo){
                                                layersLoaded[idx_layer].setStyle({fillColor: '#bd0026'});
                                                flagIsFeatureLayer = true;
                                                break;
                                            }
                                        }

                                        if(flagIsFeatureLayer)
                                            return true;

                                        

                                        var layersLoaded = featureLayerEpnuevo.getLayers();

                                        if(layersLoaded.length > 0){
                                            for (var idx_layer in layersLoaded){
                                                if(layersLoaded[idx_layer].feature.id == ep_id && layersLoaded[idx_layer].feature.id_tipo == id_tipo){
                                                    layersLoaded[idx_layer].setStyle({fillColor: '#bd0026'});
                                                    break;
                                                }
                                            }
                                        }else{
                                            featureLayerEpnuevo.setGeoJSON( result.data.supplemental );
                                            featureLayer.eachLayer(function (layer) {
                                                layer.setStyle({fillColor: '#bd0026'});
                                            });
                                        }
                                        
                                        return true;
                                    };
                                }
                            }
                        })
                        .fail(function( jqXHR, textStatus ) {
                            console.log('fail');
                        });
                    });
                });
            });
        </script>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCy7nk1vOuAlQvWoGZXK9rqeMq23R3SP7Y&signed_in=true&callback=initialize">
        </script>

        <?php echo Modules::run('complain/Complain/get_form_register', array()); ?>
    </body>
</html> 
