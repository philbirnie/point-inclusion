<?php

include_once('library/autoloader.php');

$point = new \AEP\Point(-82.55, 39.26);
$xml = new \AEP\KML\Parser(__DIR__ . '/assets/kml/east.kml');

$aep = new \AEP\AEP($point, $xml);

var_dump($aep->isWithinServiceArea());
