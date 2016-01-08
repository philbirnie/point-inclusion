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

		if(count($this->polygon->getVerticies()) < 3) {
			throw new \Exception("Insufficient number of verticies on polygon");
		}
	}


	/**
	 * Determine if point is within Polygon.
	 *
	 * @return boolean
	 */
	public function isWithinPolygon()
	{

		/** @var array $verticies */
		$verticies = $this->polygon->getVerticies();

		/** @var bool $isWithinPoly */
		$isWithinPoly = false;

		//Check if the point sits exactly on a vertex
		if ($this->containsPointOnVertex()) {
			if ($this->includeBoundaries) {
				return true;
			}
			return false;
		}

		for ($i = 1; $i < count($verticies); $i++) {
			/** @var Point $vertex1 */
			$vertex1 = $verticies[$i - 1];

			/** @var Point $vertex2 */
			$vertex2 = $verticies[$i];

			//Checks for point on a horizontal boundary
			if ((($vertex1->y == $vertex2->y) && ($this->point->y == $vertex1->y))
				&& ($this->point->x > min($vertex1->x, $vertex2->x))
				&& ($this->point->x < max($vertex1->x, $vertex2->x))
			) {
				return true;
			}

			//Otherwise, check for inclusion.
			if ((
				(($vertex1->y <= $this->point->y) && ($this->point->y < $vertex2->y))
				|| (($vertex2->y <= $this->point->y) && ($this->point->y < $vertex1->y))
				&& ($this->point->x < ($vertex2->x - $vertex1->x) * ($this->point->y - $vertex1->y) / ($vertex2->y - $vertex1->y) + $vertex1->x)
			)
			) {
				$isWithinPoly = !$isWithinPoly;
			}
		}
		return $isWithinPoly;
	}

	/**
	 * Checks to see if point contains vertex
	 *
	 * @return bool
	 */
	public function containsPointOnVertex()
	{
		foreach ($this->polygon->getVerticies() as $vertex) {
			if ($this->point == $vertex) {
				return true;
			}
		}
		return false;
	}
}
