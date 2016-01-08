<?php

namespace AEP;


use AEP\Analysis\Inclusion;
use AEP\KML\Parser;

class AEP
{

	private $point;

	private $kml;

	/**
	 * AEP constructor.
	 * @param $point Point
	 * @param $kml KML\Parser
	 */
	public function __construct($point, $kml)
	{
		$this->point = $point;
		$this->kml = $kml;
		$this->kml->extractPolygonsFromXml($point);
	}

	public function isWithinServiceArea()
	{
		$applicablePolygons = $this->kml->getApplicablePolygons();

		if ($applicablePolygons['outer']) {
			/** @var string $coordinateString Coordinate String*/
			foreach ($applicablePolygons['outer'] as $outerCoordinateString) {
				$polygon = Polygon::createPolyFromCoordinateString($outerCoordinateString);
				$inclusion = new Inclusion($polygon, $this->point);
				if($inclusion->isWithinPolygon()) {
					//The point is within the Outer Polygon - need to check all inner polygons.
					foreach($applicablePolygons['inner'] as $innerPolygonCoordinateString) {
						$innerPolygon = Polygon::createPolyFromCoordinateString($innerPolygonCoordinateString);
						$innerInclusion = new Inclusion($innerPolygon, $this->point);
						if($innerInclusion->isWithinPolygon()) {
							return false;
						}
					}
					return true;
				}
			}
		}
		return false;
	}
}
