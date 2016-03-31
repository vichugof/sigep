SELECT id_ep AS id, ST_AsGeoJSON(the_geom) AS geom, fuente, nombre, categoria, ST_Distance_Sphere(the_geom, ST_MakePoint(3.4296219634265697,-76.49338781833649)), 500 *1609.34
FROM "ep" 
--WHERE ST_Distance_Sphere(the_geom, ST_MakePoint(3.4296219634265697,-76.49338781833649)) <= 500 *1609.34;
--ORDER BY ST_Distance_Sphere(the_geom, ST_MakePoint(3.4296219634265697,-76.49338781833649)) DESC
;

SELECT id_ep AS id, ST_AsGeoJSON(the_geom) AS geom, fuente, nombre, categoria, ST_Distance_Sphere(the_geom, ST_SetSRID(ST_Point(3.4296219634265697,-76.49338781833649) , 4326)), 500 *1609.34
FROM "ep" ;

SELECT *, ST_Distance("ep".the_geom, ST_SetSRID(ST_MakePoint(3.4296219634265697,-76.49338781833649), 4326)) 
FROM "ep" WHERE ST_DWithin("ep".the_geom, ST_SetSRID(ST_MakePoint(3.4296219634265697,-76.49338781833649), 4326), 3000) = true
order by ST_Distance("ep".the_geom,  ST_SetSRID(ST_MakePoint(3.4296219634265697,-76.49338781833649), 4326));



SELECT id_ep AS id, ST_AsGeoJSON(the_geom) AS geom, fuente, nombre, categoria, ST_Distance(ST_SetSRID(ST_Point(3.4296219634265697,-76.49338781833649) , 4326), the_geom)
FROM "ep" 
ORDER BY  ST_Distance(ST_SetSRID(ST_Point(3.4296219634265697,-76.49338781833649) , 4326), the_geom) DESC;

SELECT ST_DWithin(the_geom, ST_SetSRID(ST_Point(6.9333, 46.8167), 4326), 30000) FROM "ep" ;

SELECT "ep".*, ST_Distance(
	ST_Transform("ep".the_geom, 26986), 
	ST_Transform(ST_GeomFromText('POINT(-76.49338781833649 3.42962)',  4326), 26986)
	)  
FROM "ep"
WHERE ST_DWithin( ST_Transform(ST_GeomFromText('POINT(-76.49338781833649 3.42962)',  4326), 26986) ,ST_Transform("ep".the_geom, 26986), 500) 
ORDER BY ST_Distance(
	ST_Transform("ep".the_geom, 26986), 
	ST_Transform(ST_GeomFromText('POINT(-76.49338781833649 3.42962)',  4326), 26986)
	)  
;

SELECT ST_Distance(
		ST_GeomFromText('POINT(-72.1235 42.3521)',4326),
		ST_GeomFromText('LINESTRING(-72.1260 42.45, -72.123 42.1546)', 4326)
	);
