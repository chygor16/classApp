<?php
	
	$page_title = "Register";
	include 'includes/header.php';

		$errors = [];

		if(array_key_exists('register', $_POST)) {
			

			if(empty($_POST['fname'])){
				$errors['fname'] = "Please enter your firstname";
			}

			if(empty($_POST['lname'])){
				$errors['lname'] = "Please enter your lastname";
			}

			if(empty($_POST['email'])){
				$errors['email'] = "Please enter your email";
			}

			if(empty($_POST['password'])){
				$errors['password'] = "Please enter your password";
			}

			if(empty($_POST['pword'])){
				$errors['pword'] = "Please comfirm your password";
			}

			if(empty($errors)) {
				#do database stuff
			}
		}
	
?>

<div class="wrapper">
		<h1 id="register-label">Register</h1>
		<hr>
		<form id="register"  action ="register.php" method ="POST">
			<div>
				<?php if(isset($errors['fname'])) { echo '<span class=err>'.$errors['fname'].'</span>';}?>
				<label>first name:</label>
				<input type="text" name="fname" placeholder="first name">
			</div>
			<div>
				<?php if(isset($errors['lname'])) { echo '<span class=err>'.$errors['lname'].'</span>';}?>
				<label>last name:</label>	
				<input type="text" name="lname" placeholder="last name">
			</div>

			<div>
				<?php if(isset($errors['email'])){ echo '<span class=err>'.$errors['email'].'</span>';} ?>
				<label>email:</label>
				<input type="text" name="email" placeholder="email">
			</div>
			<div>
				<?php if(isset($errors['password'])){ echo '<span class=err>'.$errors['password'].'</span>';} ?>
				<label>password:</label>
				<input type="password" name="password" placeholder="password">
			</div>
 
			<div>
				<?php if(isset($errors['pword'])){ echo '<span class=err>'.$errors['pword'].'</span>';} ?>
				<label>confirm password:</label>	
				<input type="password" name="pword" placeholder="password">
			</div>

			<input type="submit" name="register" value="register">
		</form>

		<h4 class="jumpto">Have an account? <a href="login.php">login</a></h4>
	</div>

	<?php

		include 'includes/footer.php';
	?>