<?php


class pointLocation
{

	public function pointInPolygon($point, $polygon, $includePointOnVertex = true)
	{
		$isWithinPoly = false;

		$verticies = array();

		//Transform String Coordinates into arrays with x and y values
		try {
			$point = $this->pointStringToCoordinates($point);
		} catch (Exception $e) {
			echo $e->getMessage();
			die;
		}

		//Add polygon points to verticies array
		foreach ($polygon as $vertex) {
			array_push($verticies, $this->pointStringToCoordinates($vertex));
		}

		//Check if the point sits exactly on a vertex
		if ($this->pointOnVertex($point, $verticies)) {
			if($includePointOnVertex) {
				return true;
			}
			return false;
		}

		$vertex_count = count($verticies);

		for ($i = 1; $i < $vertex_count; $i++) {
			$vertex1 = $verticies[$i - 1];
			$vertex2 = $verticies[$i];

			//Checks for point on a horizontal boundary
			if ((($vertex1['y'] == $vertex2['y']) && ($point['y'] == $vertex1['y']))
				&& ($point['x'] > min($vertex1['x'], $vertex2['x']))
				&& ($point['x'] < max($vertex1['x'], $vertex2['x']))) {
				return true;
			}

			//Otherwise, check for inclusion.
			if ((
			(($vertex1['y'] <= $point['y']) && ($point['y'] < $vertex2['y']))
			|| (($vertex2['y']) <= $point['y']) && ($point['y'] < $vertex1['y']))
			&& ($point['x'] < ($vertex2['x'] - $vertex1['x']) * ($point['y'] - $vertex1['y']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']
			)) {
				$isWithinPoly = !$isWithinPoly;
			}

		}

		return $isWithinPoly;
	}

	public function pointStringToCoordinates($pointString)
	{
		$coordinates = explode(" ", $pointString);
		if (count($coordinates) !== 2) {
			throw new Exception("Invalid Point");
		}

		return array(
			'x' => $coordinates[0],
			'y' => $coordinates[1],
		);
	}

	public function pointOnVertex($point, $verticies)
	{
		foreach ($verticies as $vertex) {
			if ($point == $vertex) {
				return true;
			}
		}
		return false;
	}
}


//TEST

$pointLocation = new pointLocation();

$polygon = array("-83.5 39.5", "-83.5 40.0", "-83.0 40.0", "83.0 39.5", "-83.5 39.5");
$point = "-83.25 39.75";



echo "Point ${point} within polygon? ";

echo $pointLocation->pointInPolygon($point, $polygon) ? "Yes" : "No";
