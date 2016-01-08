<?php

/*
|--------------------------------------------------------------------------
| Inclusion Class Unit Test
|--------------------------------------------------------------------------
|
|
*/
use \AEP\Point;
use \AEP\Polygon;
use \AEP\Analysis\Inclusion;

class InclusionTest extends PHPUnit_Framework_TestCase
{
	private $polygon;

	private function initialize()
	{
		$this->polygon = new Polygon();

		$ll = new Point(-83, 39);
		$lr = new Point(-82, 39);
		$ur = new Point(-82, 40);
		$ul = new Point(-83, 40);
		$cl = new Point(-83, 39);

		$this->polygon->addMultipleVerticies(array($ll, $lr, $ur, $ul, $cl));
	}

	public function testSimpleInclusion()
	{
		$this->initialize();

		$point = new Point(-82.5, 39.5);

		$inclusion = new Inclusion($this->polygon, $point);

		$this->assertTrue($inclusion->isWithinPolygon());
	}

	public function testSimpleExclusion()
	{
		$this->initialize();

		$point = new Point(-82.5, 40.5);

		$inclusion = new Inclusion($this->polygon, $point);

		$this->assertFalse($inclusion->isWithinPolygon());
	}

	public function testSimpleBoundary()
	{
		$this->initialize();

		$point = new Point(-82, 39.5);

		$inclusion = new Inclusion($this->polygon, $point);

		$this->assertTrue($inclusion->isWithinPolygon());
	}

	public function testVertex()
	{
		$this->initialize();

		$point = new Point(-82, 39);

		$inclusion = new Inclusion($this->polygon, $point);

		$this->assertTrue($inclusion->isWithinPolygon());
	}

	/**
	 * @expectedException Exception
	 */
	public function testInsufficientPoly() {
		$point = new Point(50, 50);
		$polygon = new Polygon();
		$polygon->addVertex($point);

		new Inclusion($polygon, $point);
	}
}
