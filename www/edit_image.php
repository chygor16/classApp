	<?php

		session_start();

		include 'includes/db.php';

		include 'includes/funct.php';

		include 'includes/dashboard_header.php';

		checkLogin();

		if($_GET['img']) {
			$book_id = $_GET['img'];
		}

		$error = [];

		define('MAX_FILE_SIZE', 2097152);

		$ext = ['image/jpg', 'image/jpeg', 'image/png'];

		if(array_key_exists('pic', $_POST)){

			if(empty($_FILES['image']['name'])) {
				$error['image'] = "Please select a book image";
			}

        	if($_FILES['image']['size'] > MAX_FILE_SIZE) {
           	 	$error['image'] = "Image size too Large";
        	}

        	if(!in_array($_FILES['image']['type'], $ext)){
            	$error['image'] = "Image type not Supported";
        	}

        	if(empty($error)) {
        		$img = uploadFile($_FILES, 'image', 'uploads/');

        		if($img[0]) {
        			$dest = $img[1];
        		}

        		updateImage($conn, $book_id, $dest);

        		redirect("view_products.php");
        	}  
		}

	?>		
		<div class="wrapper">
			<form id="register" action="" method="POST" enctype="multipart/form-data">
				<div>
                    <?php
                        $err = displayErrors($error, 'image');
                        echo $err;
                        ?>
                        <label>Image:</label>
                        <input type="file" name="image">
                </div>
                <input type="submit" name="pic">
            </form>
        </div>