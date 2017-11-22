<?php
	
	session_start();

	$page_title = "Admin Dashboard";

	include 'includes/funct.php';
	
	include 'includes/dashboard_header.php';

	include 'includes/db.php';

	

?>


<div class="wrapper">
		<div id="stream">
			<table id="tab">
				<thead>
					<tr>
						<th>title</th>
						<th>author</th>
						<th>price</th>
						<th>category</th>
						<th>image</th>
						<th>edit</th>
						<th>delete</th>
					</tr>
				</thead>
				<tbody>
					<?php

						$prod = viewProduct($conn); echo $prod
					?>
          		</tbody>
			</table>
		</div>

		<div class="paginated">
			<a href="#">1</a>
			<a href="#">2</a>
			<span>3</span>
			<a href="#">2</a>
		</div>
	</div>

	<?php

	include 'includes/footer.php';

	?>