<?php

class PointTest extends PHPUnit_Framework_TestCase
{
	public function testInitializationIsNull() {
		$p = new \AEP\Point();

		$this->assertNull($p->x);
		$this->assertNull($p->y);
	}


	public function testInitialization() {
		$p = new \AEP\Point(50, 60);

		$this->assertEquals(50, $p->x);
		$this->assertEquals(60, $p->y);
	}


	public function testCanSetTextPoint() {
		$samplePoint = "50 40";

		$p = new \AEP\Point();
		$p->setPointFromString($samplePoint);

		$this->assertEquals(50, $p->x);
		$this->assertEquals(40, $p->y);
	}

	/**
	 * @expectedException Exception
	 */
	public function testBadPointThrowsException() {
		$samplePoint = "50";

		$p = new \AEP\Point();
		$p->setPointFromString($samplePoint);
	}
}
