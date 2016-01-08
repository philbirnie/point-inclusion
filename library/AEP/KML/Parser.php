<?php
/*
|--------------------------------------------------------------------------
| Parser
|--------------------------------------------------------------------------
|
| Handles Parsing of Keyhole Markup Files to determine if point is within
| polygon.
*/

namespace AEP\KML;

use AEP\Point;

class Parser
{

	private $file;

	private $xml;

	public $innerPolygons = array();

	public $outerPolygons = array();

	public function __construct($filename)
	{
		if (!file_exists($filename)) {
			throw new \Exception("File $filename cannot be found");
		}
		$this->file = $filename;
	}

	/**
	 * @param null|Point $filter
	 */
	public function extractPolygonsFromXml($filter = null)
	{
		/** @var \SimpleXMLElement xml */
		$this->xml = simplexml_load_file($this->file);
		if ($this->xml) {
			$this->xml->registerXPathNamespace('x', 'http://www.opengis.net/kml/2.2');
			$polygons = $this->xml->xpath('//x:Polygon');
			/** @var \SimpleXMLElement $p */
			foreach ($polygons as $p) {
				/** @var \SimpleXMLElement $parent */
				$p->registerXPathNamespace('p', 'http://www.opengis.net/kml/2.2');
				$outerBoundary = $p->xpath('p:outerBoundaryIs');

				if ($this->isApplicablePolygon($filter, $outerBoundary)) {
					array_push($this->outerPolygons, (string) $outerBoundary[0]->LinearRing->coordinates);
					$innerBoundaries = $p->xpath('p:innerBoundaryIs');

					/** @var \SimpleXMLElement $i */
					foreach ($innerBoundaries as $i) {
						array_push($this->innerPolygons, (string)$i->LinearRing->coordinates);
					}
				}
			}
		}
	}

	/**
	 * Checks to determine if point is within outer bounding box of polygon
	 *
	 * @param $point Point
	 * @param $outerBoundary array
	 * @return bool
	 */
	public function isApplicablePolygon($point, $outerBoundary)
	{
		if(!$point) {
			return true;
		} else {
			$path = ltrim((string) $outerBoundary[0]->LinearRing->coordinates);

			$xCoords = array();
			$yCoords = array();

			$coordinates = explode(' ', $path);
			foreach($coordinates as $c) {
				$cartesian = explode(',', $c);
				array_push($xCoords, $cartesian[0]);
				array_push($yCoords, $cartesian[1]);
			}
			return $point->x >= min($xCoords) && $point->x <= max($xCoords) && $point->y >= min($yCoords) && $point->y <= max($yCoords);
		}
	}

	public function getApplicablePolygons()
	{
		return array(
			'outer' => $this->outerPolygons,
			'inner' => $this->innerPolygons
		);
	}
}
