<?php
$shared_secret = 'GETYOURSHAREDSECRETFROMMETEOBLUE.COM';
$params = array(
  'apikey' => 'ADDYOUROWNAPIKEYFROMMETEOBLUE.COM', 
  'mac' => 'visimage',
  'type' => 'meteogram_air', 
  'tz' => 'Europe_Zurich',
  'lat' => 47.5582, 
  'lon' => 7.5881, 
  'asl' => 260,
  'city' => 'Basel',
  'paramtype' => 'imagefeed',
  'ts' => time()
);
$query_string = '/fcgi/dispatch.pl?'.http_build_query($params);
$url = 'https://my.meteoblue.com' . $query_string . "&sig=" . md5( $query_string . "&secret=" . $shared_secret);
$img = file_get_contents("$url");
//echo $url;
header('Content-type:image/png');
echo $img;
?>
