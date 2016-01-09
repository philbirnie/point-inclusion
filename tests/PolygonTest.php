<?php

class PolygonTest extends PHPUnit_Framework_TestCase
{
	public function testAddGoodPoint() {
		$pointA = new \AEP\Point(50, 40);
		$pointB = new \AEP\Point(40, 30);
		$pointC = new \AEP\Point(30, 20);

		$poly = new \AEP\Polygon();
		$poly->addVertex($pointA);
		$poly->addVertex($pointB);

		$verticies = $poly->getVertices();

		$this->assertEquals(2, count($verticies));

		$poly->addMultipleVertices(array($pointA, $pointB, $pointC));

		$verticies = $poly->getVertices();

		$this->assertEquals(5, count($verticies));
	}
}
