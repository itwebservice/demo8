  <?php
include('config.php');
$base_url = BASE_URL_API;

$Apipackage = getData($base_url.'/package/popular');
$Apiactivity = getData($base_url.'/activity/popular');
$Apigeneral = getData($base_url.'/general');
$Apisocial = getData($base_url.'/social')[0];
$Apidestination = getData($base_url.'/destination');
$Apibanner = getData($base_url.'/banner');
$Apigallery = getData($base_url.'/gallery');
$Apifooter = getData($base_url.'/footer');
$Apitestimonial = getData($base_url.'/testimonial');
$Apihotel = getData($base_url.'/hotel/popular');
$Apiassoc = getData($base_url.'/association');




function getData($url)
{
  $ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);
// Will dump a beauty json <3
$fr=json_decode($result);
  return $fr;
}
?>