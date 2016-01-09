<?php

include_once('library/autoloader.php');

$point = new \AEP\Point(-83.3203125, 38.285624966683756);
$xml = new \AEP\KML\Parser(__DIR__ . '/assets/kml/east.kml');

$aep = new \AEP\AEP($point, $xml);

var_dump($aep->isWithinServiceArea());
