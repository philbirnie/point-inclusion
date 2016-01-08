<?php

/*
|--------------------------------------------------------------------------
| Point
|--------------------------------------------------------------------------
|
|
*/

namespace AEP;

class Point
{

	public $x;
	public $y;

	private $delimiter = ' ';

	public function __construct($x = null, $y = null)
	{
		if ($x && $y) {
			$this->x = $x;
			$this->y = $y;
		}
	}

	public function setPointFromString($pointValue)
	{
		$pointCoordinates = explode($this->delimiter, $pointValue);

		try {
			$this->x = $pointCoordinates[0];
			$this->y = $pointCoordinates[1];
		} catch (\Exception $e) {
			throw new \Exception("Invalid Point: " . $pointValue);
		}
	}
}
