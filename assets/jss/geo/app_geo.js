 
            var geojsonEpriorizado;
            var geojsonEp;
            var featureLayer = L.mapbox.featureLayer();

            function style(feature) {
                return {
                    fillColor: '#df65b0',
                    weight: 2,
                    opacity: 1,
                    color: 'white',
                    dashArray: '3',
                    fillOpacity: 0.8
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
                geojsonEpriorizado.resetStyle(e.target);
                info.update();
            }

            function zoomToFeature(e) {
                map.fitBounds(e.target.getBounds());
                countryClicked = true;
            }

            function onEachFeature(feature, layer) {
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                    click: zoomToFeature
                });
            }

            var spacepublic = {
                epriorizado : '<?php echo json_encode($geojsonepriorizado); ?>'/*,
                ep : '<?php echo json_encode($geojsonep); ?>'*/
            };

            // //Add map
            L.mapbox.accessToken = 'pk.eyJ1IjoieWVyb3Rhem1hMDMiLCJhIjoiY2lqMW4wNWl5MDBic3VhbHo0ZmMyZzQxOSJ9.zMzfDxxgOHUEDSV58s7o1Q';

            // var map = L.mapbox.map('spacepublic', 'mapbox.streets',{maxZoom:12, minZoom:4})
            //     .setView([31.783300, 35.216700], 3);
            var map = L.mapbox.map('spacepublic', 'mapbox.streets')
                 .setView([3.4424557822539, -76.484385061106], 13);

            // control that shows state info on hover
            var info = L.control();

            info.onAdd = function(map) {
                this._div = L.DomUtil.create('div', 'spacePublic');
                this.update();
                return this._div;
            };

            info.update = function(props) {
                //this._div.innerHTML = '<h4>Number of space public</h4>' + (props ? '<b>' + props.name + '</b><br />' + props.numberOfStudies + ' Studies' : 'Hover over a layer');
                this._div.innerHTML = '<h4>Espacio Público</h4>'+ (props ? '<b>' + props.nombre + '</b><br /><br /> Cod. Barrio: ' + props.cod_barrio : 'Hover over a layer');
                console.log(props);
            };

            info.addTo(map);

            //geojsonEp = L.geoJson( JSON.parse(spacepublic.ep) ).addTo(map);

            //geoJson = L.geoJson(countriesData, {style: style}).addTo(map);
            geojsonEpriorizado = L.geoJson( JSON.parse(spacepublic.epriorizado), 
                                            {
                                                style: style, 
                                                onEachFeature: onEachFeature
                                            } 
                                ).addTo(map);
            map.on('move', function() {
                // retrieveEp();
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
                $.ajax({
                    //url: 'http://sigep.dev/index.php/geo/get_ep',
					url: 'http://localhost/sigep/public/index.php/geo/get_ep',
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
