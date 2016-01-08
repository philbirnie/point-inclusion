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

	private $verticies = array();

	/**
	 * @param $vertex Point
	 */
	public function addVertex($vertex)
	{
		array_push($this->verticies, $vertex);
	}

	/**
	 * @param array $verticies
	 */
	public function addMultipleVerticies($verticies) {
		foreach($verticies as $vertex) {
			array_push($this->verticies, $vertex);
		}
	}

	/**
	 * Returns Verticies
	 *
	 * @return array
	 */
	public function getVerticies()
	{
		return $this->verticies;
	}
}
