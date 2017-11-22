<?php
    session_start(); 
    $page_title = "Admin Dashboard";
    include 'includes/funct.php';
    include 'includes/dashboard_header.php';
    include 'includes/db.php';    
    
    checkLogin();

    $error = [];

    $flag = ['Top Selling', 'Trending', 'Recently-Viewed'];

    define('MAX_FILE_SIZE', 2097152);

    $ext = ['image/jpeg', 'image/jpg', 'image/png'];

    if (array_key_exists('add', $_POST)) {

       //print_r($_FILES); exit();
        if (empty($_POST['book_title'])) {
            $error['book_title'] = "Please Enter a Book Title";
        }

         if (empty($_POST['author'])) {
            $error['author'] = "Please Enter Author Name";
        }

        if (empty($_POST['price'])){
            $error['price'] = "Please Enter the Book Price";
        }

         if (empty($_POST['year'])) {
            $error['year'] = "Please Choose a Publication Date";
        }

         if (empty($_POST['cat'])) {
            $error['cat'] = "Please Enter a Category ID";
        }

        if (empty($_POST['flag'])) {
            $error['flag'] = "Please Select a Flag";
        }

        if(empty($_FILES['image']['name'])){
            $error['image'] = "Please Select a book Image";
        }

        if($_FILES['image']['size'] > MAX_FILE_SIZE) {
            $error['image'] = "Image size too Large";
        }

        if(!in_array($_FILES['image']['type'], $ext)){
            $error['image'] = "Image type not Supported";
        }


        if (empty($error)) {

            $img = uploadFile($_FILES, 'image', 'uploads/');

            if($img[0]) {

                $location = $img[1];
            }

            $clean = array_map('trim', $_POST);
            $clean['dest'] = $location;
            //$clean = array_map('trim',$_POST);
            addProduct($conn,$clean);
            header("location:view_products.php");

        }
    }
?>
<div class="wrapper">
		<div id="stream">
			<form id="register"  action ="add_products.php" method ="POST" enctype="multipart/form-data">
			    <div>
                    <?php $data = displayErrors($error, 'book_title'); ?>								
				    <label>Book Title:</label>
				    <input type="text" name="book_title" placeholder="book title">
                </div>
                <div>
                    <?php $data = displayErrors($error, 'author'); ?>                                
                    <label>Author:</label>
                    <input type="text" name="author" placeholder="author">
                </div>
                <div>
                    <?php $data = displayErrors($error, 'price'); ?>                                
                    <label>Price:</label>
                    <input type="text" name="price" placeholder="price">
                </div>
                <div>
                    <?php $data = displayErrors($error, 'year'); ?>                                
                    <label>Year:</label>
                    <input type="text" name="year" placeholder="year">
                </div>
                <div>
                    <?php $data = displayErrors($error, 'cat'); ?>                                
                    <label>Category:</label>
                    <select name = "cat">
                        <option name = "">Select Category</option>
                        <?php
                            $dat = fetchCategory($conn); 
                            echo $dat;
                            ?>
                    </select>
                </div>
                <div>
                    <?php
                        $err = displayErrors($error, 'flag');
                        echo $err;
                        ?>
                        <label>Flag:</label>
                        <select name ="flag">
                            <option name = "">Select Flag</option>
                            <?php foreach($flag as $f1) { ?>
                                <option value="<?php echo $f1; ?>"><?php echo $f1; ?> </option>
                                <?php } ?>
                             </select>
                </div>
                <div>
                    <?php
                        $err = displayErrors($error, 'image');
                        echo $err;
                        ?>
                        <label>Image:</label>
                        <input type="file" name="image">
                </div>
                <input type="submit" name="add" value="Add">
            </form>
		</div>
</div>
<?php
    include 'includes/footer.php'
?>
