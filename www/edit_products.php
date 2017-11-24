<?php
    session_start(); 
    $page_title = "Admin Dashboard";
    include 'includes/funct.php';
    include 'includes/dashboard_header.php';
    include 'includes/db.php';    
    
    checkLogin();


    $error = [];


    if($_GET['book_id']) {
        $book_id = $_GET['book_id'];
    }

    $item = getProductById($conn, $book_id);

           $category =  getCategoryById($conn, $item[5]);
    
    if (array_key_exists('edit',$_POST)) {
        if (empty($_POST['book_title'])) {
            $error['book_title'] = "Please Enter a Book Title";
        } 

        if(empty($_POST['author'])) {
            $error['author'] = "Please Enter an Author Name";
        }

        if (empty($_POST['price'])) {
            $error['price'] = "Please Enter a book Price";
        }

        if (empty($_POST['year'])) {
            $error['year'] = "Please Enter a publishing year";
        }

        if(empty($_POST['cat'])) {
            $error['cat'] = "Please select a Category";
        }


        if (empty($error)) {

           $clean = array_map('trim', $_POST);
           $clean['id'] = $book_id;

           updateProduct($conn, $clean);

           redirect("view_products.php");
           
        }
    }
?>
<div class="wrapper">
        <div id="stream">
            <form id="register"  action ="" method ="POST">
                <div>
                    <?php $data = displayErrors($error, 'book_title'); ?>                               
                    <label>Book Title:</label>
                    <input type="text" name="book_title" placeholder="book title" value="<?php echo $item[1]; ?>" >
                </div>
                <div>
                    <?php $data = displayErrors($error, 'author'); ?>                                
                    <label>Author:</label>
                    <input type="text" name="author" placeholder="author" value=" <?php echo $item[2]; ?>">
                </div>
                <div>
                    <?php $data = displayErrors($error, 'price'); ?>                                
                    <label>Price:</label>
                    <input type="text" name="price" placeholder="price" value="<?php echo $item[3]; ?>">
                </div>
                <div>
                    <?php $data = displayErrors($error, 'year'); ?>                                
                    <label>Year:</label>
                    <input type="text" name="year" placeholder="year" value=" <?php echo $item[4]; ?>">
                </div>
                <div>
                    <?php $data = displayErrors($error, 'cat'); ?>                                
                    <label>Category:</label>
                    <select name = "cat">
                        <option value="<?php echo $category[0];?>"> <?php echo $category[1]; ?></option>
                        <?php
                        $data = fetchCategory($conn, $category[1]); 
                            echo $data;
                            ?>
                    </select>
                </div>
                <input type="submit" name="edit" value="edit product">
            </form>
            <h4 class="jumpto">To Edit Product Image, <a href='edit_image.php?img=<?php echo $book_id; ?>'>Click Here</a></h4>
        </div>
</div>
<?php
    include 'includes/footer.php'
?>
