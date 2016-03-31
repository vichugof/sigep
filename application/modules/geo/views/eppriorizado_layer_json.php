<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<html>
    <head>
        <!-- <meta charset="utf-8"> -->
        <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
        <title>Welcome</title>
        <script type="text/javascript" src="https://api.mapbox.com/mapbox.js/v2.2.4/mapbox.js?ver=4.3.1"></script>
        <!-- <script type="text/javascript" src="https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js?ver=4.3.1"></script> -->
        <link href='https://api.mapbox.com/mapbox.js/v2.2.4/mapbox.css' rel='stylesheet' />
        <!-- <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.css' rel='stylesheet' />
        <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.Default.css' rel='stylesheet' /> -->
        <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

        <style type="text/css">
            html, body{
                height: 100%;
            }
            #spacepublic {
                height: 100%;
                width: 80%;
                float: left;
            }
            #streetview {
                height: 100%;
                width: 20%;
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

        </style>
    </head>

    <body>
        <div>
            <div id='spacepublic'></div>
            <div id='streetview'>
                <div id="map_streetview"></div>
                <div id="pano_streetview"></div>
            </div>
        </div>

        <script type="text/javascript">
            var geojsonEpriorizado;
            var geojsonBarrio;
            var geojsonEp;
            var featureLayer = L.mapbox.featureLayer();
            var panorama;
            var mapGoogleMaps;

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
            }

            function onEachFeature(feature, layer) {
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                    click: zoomToFeature
                });
            }

            var spacepublic = {
                barrio: '<?php echo json_encode($geojsonbarrio); ?>',
                epriorizado : '<?php echo json_encode($geojsonepriorizado); ?>'/*,
                ep : '<?php //echo json_encode($geojsonep); ?>'*/
            };

            // //Add map
            L.mapbox.accessToken = 'pk.eyJ1IjoieWVyb3Rhem1hMDMiLCJhIjoiY2lqMW4wNWl5MDBic3VhbHo0ZmMyZzQxOSJ9.zMzfDxxgOHUEDSV58s7o1Q';

            // var map = L.mapbox.map('spacepublic', 'mapbox.streets',{maxZoom:12, minZoom:4})
            //     .setView([31.783300, 35.216700], 3);
            var map = L.mapbox.map('spacepublic', 'mapbox.streets')
                 // .setView([3.4424557822539, -76.484385061106], 13);
                 .setView([3.4266, -76.5198], 12);

            // control that shows state info on hover
            var info = L.control();

            info.onAdd = function(map) {
                this._div = L.DomUtil.create('div', 'spacePublic');
                this.update();
                return this._div;
            };

            info.update = function(props) {
                //this._div.innerHTML = '<h4>Number of space public</h4>' + (props ? '<b>' + props.name + '</b><br />' + props.numberOfStudies + ' Studies' : 'Hover over a layer');
                //this._div.innerHTML = '<h4>Espacio Público</h4>'+ (props ? '<b>' + props.nombre + '</b><br /><br /> Cod. Barrio: ' + props.cod_barrio : 'Hover over a layer');
                this._div.innerHTML = '<h4>Espacio Público</h4>'+ (props ? '<b>' + props.nombre + '</b><br />' : 'Hover over a layer');
                console.log(props);
            };

            info.addTo(map);

            //geojsonEp = L.geoJson( JSON.parse(spacepublic.ep) ).addTo(map);

            //geoJson = L.geoJson(countriesData, {style: style}).addTo(map);
            // geojsonEpriorizado = L.geoJson( JSON.parse(spacepublic.epriorizado), 
            //                                 {
            //                                     style: style, 
            //                                     onEachFeature: onEachFeature
            //                                 } 
            //                     ).addTo(map);

            geojsonBarrio = L.geoJson( JSON.parse(spacepublic.barrio), 
                                    {
                                        style: style, 
                                        onEachFeature: onEachFeature
                                    } 
                                ).addTo(map);

            map.on('move', function() {
                // retrieveEp();
            });
            
            map.on('click', function(e) {
                //window[e.type].innerHTML = e.containerPoint.toString() + ', ' + e.latlng.toString();
                // console.log(e.containerPoint.toString() + ', ' + e.latlng.toString(), e.latlng.lat, e.latlng.lng);
                // var astorPlace = {lat: e.latlng.lat, lng: e.latlng.lng};
                // panorama.setPosition(astorPlace);
                // panorama.setPov(/** @type {google.maps.StreetViewPov} */({
                //     heading: 34,
                //     pitch: 10
                // }));
                // panorama.setVisible(true);

                // var fenway = {lat: e.latlng.lat, lng: e.latlng.lng};
                // mapGoogleMaps.setCenter(fenway);

                // mapGoogleMaps.setZoom(map.getZoom());
                updateStreetView(e);

            });

            map.on('zoomend', function() {
                // here's where you decided what zoom levels the layer should and should
                // not be available for: use javascript comparisons like < and > if
                // you want something other than just one zoom level, like
                // (map.getZoom > 10)
                if (map.getZoom() > 15) {
                    retrieveEp();
                } else {
                    map.featureLayer.setFilter(function() { return false; });
                    map.removeLayer(featureLayer);
                    //map.removeLayer(geojsonEp);
                }

                //console.log('center', map.getCenter());
            });     
            
            function retrieveEp(){
                // setFilter is available on L.mapbox.featureLayers only. Here
                // we're hiding and showing the default marker layer that's attached
                // to the map - change the reference if you want to hide or show a
                // different featureLayer.
                // If you want to hide or show a different kind of layer, you can use
                // similar methods like .setOpacity(0) and .setOpacity(1)
                // to hide or show it.

                //map.featureLayer.setFilter(function() { return true; });
                //geojsonEp = L.geoJson( JSON.parse(spacepublic.ep) ).addTo(map);
                var coordinates_center = map.getCenter();
                var dataRequest = {coor: {lat: coordinates_center.lat, lng: coordinates_center.lng}};

                console.log('Bounds', map.getBounds().getSouthWest());
                console.log('Bounds', map.getBounds().getNorthEast());
                console.log('Bounds', map.getBounds().getNorthWest());
                console.log('Bounds', map.getBounds().getSouthEast());

                $.ajax({
                    url: 'http://sigep.dev/index.php/geo/get_ep',    
                    type: "POST",
                    cache: false,
                    data: dataRequest
                })
                .done(function( result ) {

                    if(result.success == true && result.data.success == 'success'){

                        //geojsonEp = L.geoJson( result.data.supplemental ).addTo(map);
                        featureLayer.setGeoJSON( result.data.supplemental );
                        map.addLayer(featureLayer);
                        //console.log('enter if',result.success ,result.data.success , result, map.getCenter());
                    }
                    //console.log('global',result.success ,result.data.success , result);
                    
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

        </script>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfb2MlpqmJHgBEuF2hBG6AwNYARw_72d8&signed_in=true&callback=initialize">
        </script>

    </body>
</html> 
