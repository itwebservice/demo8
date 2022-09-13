<?php
define('BASE_URL_API', 'https://demo8.itourscloud.com/frontendAPI/public/api');
$base_url = BASE_URL_API;
$Apipackage = json_decode(file_get_contents($base_url.'/package/popular'));
$Apiactivity = json_decode(file_get_contents($base_url.'/activity/popular'));
$Apigeneral = json_decode(file_get_contents($base_url.'/general'));
$Apisocial = json_decode(file_get_contents($base_url.'/social'))[0];
$Apidestination = json_decode(file_get_contents($base_url.'/destination'));
$Apibanner = json_decode(file_get_contents($base_url.'/banner'));
$Apigallery = json_decode(file_get_contents($base_url.'/gallery'));
$Apifooter = json_decode(file_get_contents($base_url.'/footer'));
$Apitestimonial = json_decode(file_get_contents($base_url.'/testimonial'));
$Apihotel = json_decode(file_get_contents($base_url.'/hotel/popular'));
$Apiassoc = json_decode(file_get_contents($base_url.'/association'));
$Apitransport = json_decode(file_get_contents($base_url.'/transport'));


?>