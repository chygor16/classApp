<?php

/*function picture($a)
{
	if(empty($_FILES['pics'] ['name'])){
		$error[] = "Please select a file";
	}
	return $a;
}*/


	function uploadFile($file, $name, $loc){
		$result = [];

		$rnd = rand(0000000000, 9999999999);
		$strip_name = str_replace(' ', '_', $file[$name]['name']);

		$fileName = $rnd.$strip_name;
		$destination = $loc.$fileName;

		if(move_uploaded_file($file[$name]['tmp_name'],$destination)) {
			$result[] = true; 
		} else {
			$result[] = false;
		}

		return $result;
	}

?>


