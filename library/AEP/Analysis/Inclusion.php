<?php

/*
|--------------------------------------------------------------------------
| Checks for inclusion of point within polygon
|--------------------------------------------------------------------------
|
|
*/

namespace AEP\Analysis;

use AEP\Point;
use AEP\Polygon;

class Inclusion
{

	private $polygon;

	private $point;

	private $includeBoundaries;

	/**
	 * Inclusion constructor.
	 * @param $polygon Polygon
	 * @param $point Point
	 * @param $includeBoundaries bool
	 */
	public function __construct($polygon, $point, $includeBoundaries = true)
	{
		$this->polygon = $polygon;
		$this->point = $point;
		$this->includeBoundaries = $includeBoundaries;

		if(count($this->polygon->getVertices()) < 3) {
			throw new \Exception("Insufficient number of vertices on polygon");
		}
	}


	/**
	 * Determine if point is within Polygon.
	 *
	 * @return boolean
	 */
	public function isWithinPolygon()
	{
		/** @var int $intersections */
		$intersections = 0;

		/** @var array $vertices */
		$vertices = $this->polygon->getVertices();

		/** @var bool $isWithinPoly */
		$isWithinPoly = false;

		//Check if the point sits exactly on a vertex
		if ($this->containsPointOnVertex()) {
			if ($this->includeBoundaries) {
				return true;
			}
			return false;
		}


		for ($i = 1; $i < count($vertices); $i++) {
			/** @var Point $vertex1 */
			$vertex1 = $vertices[$i - 1];

			/** @var Point $vertex2 */
			$vertex2 = $vertices[$i];

			//Checks for point on a horizontal boundary
			if ((($vertex1->y == $vertex2->y) && ($this->point->y == $vertex1->y))
				&& ($this->point->x > min($vertex1->x, $vertex2->x))
				&& ($this->point->x < max($vertex1->x, $vertex2->x))
			) {
				return true;
			}
			if ($this->point->y > min($vertex1->y, $vertex2->y)
				&& $this->point->y <= max($vertex1->y, $vertex2->y)
				&& $this->point->x <= max($vertex1->x, $vertex2->x)
				&& $vertex1->y != $vertex2->y) {
				$xinters =
					($this->point->y - $vertex1->y) * ($vertex2->x - $vertex1->x)
					/ ($vertex2->y - $vertex1->y)
					+ $vertex1->x;
				if ($xinters == $this->point->x) {
					// Check if point is on the polygon boundary (other than horizontal)
					return $this->includeBoundaries ? TRUE : FALSE;
				}
				if ($vertex1->x == $vertex2->x || $this->point->x <= $xinters) {
					$intersections++;
				}
			}
		}
		return $intersections % 2 != 0;
	}

	/**
	 * Checks to see if point contains vertex
	 *
	 * @return bool
	 */
	public function containsPointOnVertex()
	{
		foreach ($this->polygon->getVertices() as $vertex) {
			if ($this->point == $vertex) {
				return true;
			}
		}
		return false;
	}
}
