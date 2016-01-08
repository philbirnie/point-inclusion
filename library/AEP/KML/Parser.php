<?php
/*
|--------------------------------------------------------------------------
| Parser
|--------------------------------------------------------------------------
|
| Handles Parsing of Keyhole Markup Files to determine if point is within
| polygon.
*/

namespace AEP\KML;

use AEP\Point;

class Parser
{

	private $file;

	public function __construct($filename)
	{
		if (!file_exists($filename)) {
			throw new \Exception("File $filename cannot be found");
		}
		$this->file = $filename;
	}
}
