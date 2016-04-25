<?php
// $route['home'] = 'Public_Space';
// $route['home/get_layers'] = 'Public_Space/getLayers';
$route['geo'] = 'Public_Space';
//$route['geo/get_layers'] = 'Public_Space/get_epriorizado_layers';
$route['geo/get_ep'] = 'Public_Space/get_ep_rows';
$route['geo/get_ep/centroid'] = 'Public_Space/get_ep_row';

$route['geo/get_new_eps'] = 'Public_Space/get_ep_new_rows';
$route['geo/create_ep'] = 'Public_Space/create_ep';

$route['geo'] = 'Public_Space';
$route['geo/get_layers'] = 'Public_Space/get_eptrabajo_layers';
$route['geo/get_eppriorizado    '] = 'Public_Space/get_epriorizado_rows';
$route['geo/get_eppropuesto'] = 'Public_Space/get_epropuesto_rows';