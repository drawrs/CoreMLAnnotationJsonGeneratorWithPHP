<?php
// if ($handle = opendir('./xmls')) {
// 	while (false !== ($entry = readdir($handle))) {
// 		if ($entry != "." && $entry != "..") {
// 			echo "$entry\n";
// 		}
// 	}

// 	closedir($handle);
// }

$path    = './xmls';
$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..'));


$jsonOutputFilename = "annotations.json";

$report = []; 
$datas = [];
foreach ($files as $file) {
	$xml = $path . "/".$file;
	$ext = pathinfo($xml, PATHINFO_EXTENSION);

	if ($ext == "xml") {
		$xmldata = json_decode(json_encode(simplexml_load_file($xml)));
		$filename = $xmldata->filename;
		//print_r($xmldata->object);

		$annotations = [];
		if (is_array($xmldata->object)) {
			if (count($xmldata->object) > 1) {
				foreach ($xmldata->object as $object) {

					if (!is_null($object->name)) {
						// print_r($object);
						$tmp_coordinate = $object->bndbox;

						$xmin = (int) $tmp_coordinate->xmin;
						$ymin = (int) $tmp_coordinate->ymin;
						$xmax = (int) $tmp_coordinate->xmax;
						$ymax = (int) $tmp_coordinate->ymax;

						$width = $xmax - $xmin;
						$height = $ymax - $ymin;
						$x = round($xmin + ($width / 2));
						$y = round($ymin + ($height / 2));

						$coordinates = ["x" => $x,
										"y" => $y,
										"width" => $width,
										"height" => $height];
						$annotation = ["label" => $object->name, "coordinates" => $coordinates];
						$annotations[] = $annotation;

						$report[$object->name] += 1;
					}
					
				}
			} else {
				$object = $xmldata->object;

				if (!is_null($object->name)) {
					$tmp_coordinate = $object->bndbox;

					// $coordinates = ["x" => (int) $tmp_coordinate->xmin,
					// 				"y" => (int) $tmp_coordinate->ymin,
					// 				"width" => (int) $tmp_coordinate->xmax,
					// 				"height" => (int) $tmp_coordinate->ymax];
					// $annotation = ["label" => $object->name, "coordinates" => $coordinates];
					$xmin = (int) $tmp_coordinate->xmin;
					$ymin = (int) $tmp_coordinate->ymin;
					$xmax = (int) $tmp_coordinate->xmax;
					$ymax = (int) $tmp_coordinate->ymax;

					$width = $xmax - $xmin;
					$height = $ymax - $ymin;
					$x = round($xmin + ($width / 2));
					$y = round($ymin + ($height / 2));

					$coordinates = ["x" => $x,
									"y" => $y,
									"width" => $width,
									"height" => $height];
					$annotation = ["label" => $object->name, "coordinates" => $coordinates];

					$annotations[] = $annotation;
				}
				
			}
		} else {
			$object = $xmldata->object;
			if (!is_null($object->name)) {
				// print_r($object);
				$tmp_coordinate = $object->bndbox;
				// $coordinates = ["x" => (int) $tmp_coordinate->xmin,
				// 				"y" => (int) $tmp_coordinate->ymin,
				// 				"width" => (int) $tmp_coordinate->xmax,
				// 				"height" => (int) $tmp_coordinate->ymax];
				// $annotation = ["label" => $object->name, "coordinates" => $coordinates];
				$xmin = (int) $tmp_coordinate->xmin;
				$ymin = (int) $tmp_coordinate->ymin;
				$xmax = (int) $tmp_coordinate->xmax;
				$ymax = (int) $tmp_coordinate->ymax;

				$width = $xmax - $xmin;
				$height = $ymax - $ymin;
				$x = round($xmin + ($width / 2));
				$y = round($ymin + ($height / 2));

				$coordinates = ["x" => $x,
								"y" => $y,
								"width" => $width,
								"height" => $height];
				$annotation = ["label" => $object->name, "coordinates" => $coordinates];

				$annotations[] = $annotation;

				$report[$object->name] += 1;
			}
		}
		
		$data = ["imagefilename" => $xmldata->filename, "annotation" => $annotations];
		$datas[] = $data;
	}
	
}

$json_data = json_encode($datas, JSON_PRETTY_PRINT);

// echo "<textarea>$json_data</textarea>";
// return;
$fp = fopen($jsonOutputFilename, 'w');
fwrite($fp, $json_data);
fclose($fp);

echo "<b>$jsonOutputFilename</b> successfully generated! <br><br>";
?>

<textarea rows="10" cols="100"><?= $json_data; ?></textarea>
<hr>
<?php

foreach ($report as $key => $value) {
	echo "$key : $value";
	echo "<br>";
}

?>