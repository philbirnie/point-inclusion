<?php

class PolygonTest extends PHPUnit_Framework_TestCase
{
	public function testAddGoodPoint() {
		$pointA = array('x' => 15, 'y' => 20);
		$pointB = array('x' => 25, 'y' => 30);

		$poly = new \AEP\Polygon();
		$poly->addVertex($pointA);
		$poly->addVertex($pointB);

		$verticies = $poly->getVerticies();

		$this->assertEquals(2, count($verticies));
	}
}
