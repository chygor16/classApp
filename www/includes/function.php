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

		function doAdminRegister($dbconn, $input) {

			$hash = password_hash($input['password'], PASSWORD_BCRYPT);
			$stmt = $dbconn->prepare("INSERT INTO admin(firstname, lastname, email, hash) VALUES(:f, :l, :e, :h)");

			$data = [
					":f" => $input['fname'],
					":l" => $input['lname'],
					":e" => $input['email'],
					":h" => $hash
				];

				$stmt->execute($data);
		}

		function doesEmailExist($dbconn,$email){
			$result = false;

			$stmt = $dbconn->prepare("SELECT email FROM admin WHERE :e=email");

			$stmt->bindParam(":e", $email);
			$stmt->execute();

			$count = $stmt->rowCount();

			if($count > 0) {
				$result = true;
			}

			return $result;
		}

		function displayErrors($err, $name) {
			$result = "";

			if(isset($err[$name])) {
				$result = '<span class=err>'.$err[$name].'</span>';
			}

			return $result;
		}

		function doAdminLogin($dbconn, $input) {
			$hash = password_hash($input['password'], PASSWORD_BCRYPT);

			$stmt = $dbconn->prepare("SELECT * FROM admin WHERE 
						:e = email and :h = password");

			$data = [

				":e" => $input['email'],
				":h" => $hash
			];

			$stmt->execute($data);
		}

		/*function adminLogin($dbconn, $input){
			$result = [];

			$stmt = $dbconn->prepare("SELECT * FROM admin WHERE email = :e");

			$*/
		

		function addCategory($dbconn, $input) {
			$stmt = $dbconn->prepare("INSERT INTO category(category_name) VALUES(:catName)");
			$stmt->bindParam(':catName', $input['cat_name']);

			$stmt->execute();
		}
?>


