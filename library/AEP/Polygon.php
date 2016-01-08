<?php

/*
|--------------------------------------------------------------------------
| Polygon
|--------------------------------------------------------------------------
|
|
*/

namespace AEP;

class Polygon {

	private $verticies = array();

	/**
	 * @param $vertex array
	 */
	public function addVertex($vertex) {
		if(isset($vertex['x']) && isset($vertex['y'])) {
			$p = new Point($vertex['x'], $vertex['y']);
			array_push($this->verticies, $p);
		}
	}

	/**
	 * Returns Verticies
	 *
	 * @return array
	 */
	public function getVerticies() {
		return $this->verticies;
	}
}
