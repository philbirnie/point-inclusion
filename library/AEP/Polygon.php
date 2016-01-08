<?php

/*
|--------------------------------------------------------------------------
| Polygon
|--------------------------------------------------------------------------
|
|
*/

namespace AEP;

class Polygon
{

	private $vertices = array();

	public static function createPolyFromCoordinateString($rawCoordinateString) {
		$coordinateString = ltrim(trim($rawCoordinateString));

		$coordinates = explode(' ', $coordinateString);

		$poly = new Polygon();
		/** @var array $c */
		foreach($coordinates as $c) {
			$cartesian = explode(',', $c);
			$point = new Point($cartesian[0], $cartesian[1]);
			$poly->addVertex($point);
		}
		return $poly;
	}

	/**
	 * @param $vertex Point
	 */
	public function addVertex($vertex)
	{
		array_push($this->vertices, $vertex);
	}

	/**
	 * @param array $verticies
	 */
	public function addMultipleVertices($vertices) {
		foreach($vertices as $vertex) {
			array_push($this->vertices, $vertex);
		}
	}

	/**
	 * Returns Verticies
	 *
	 * @return array
	 */
	public function getVertices()
	{
		return $this->vertices;
	}
}
