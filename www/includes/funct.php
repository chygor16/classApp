<?php
    //function generating serial number
    function uploadFile($file, $name, $loc){
        $result = [];

        $rnd = rand(0000000000, 9999999999);
        $strip_name = str_replace(' ', '_', $file[$name]['name']);

        $fileName = $rnd.$strip_name;
        $destination = $loc.$fileName;

        if(move_uploaded_file($file[$name]['tmp_name'],$destination)) {
            $result[] = true; 
            $result[] = $destination;
            
        } else {
            $result[] = false;
        }

        return $result;
    }


    function doAdminRegister($dbconn, $input){
            //encrypting password
			$hash = password_hash($input['password'], PASSWORD_BCRYPT);
			
			//prepare is used in communicating with the db
			//:f,:l,:e,:h are all placeholders for values we want to pass into the db
			$stmt = $dbconn->prepare("INSERT INTO admin(firstName,lastName,email,hash) VALUES(:f, :l, :e, :h)"); //or ("INSERT INTO admin VALUES(null,:f, :l, :e, :h)")

			//binding placeholders and values
			$data = [
				":f" => $input['fname'],
				":l" => $input['lname'],
				":e" => $input['email'],
				":h" => $hash
			];
			
			$stmt->execute($data);
    }

    function loginAdmin($dbconn){

            $result = [];
            $stmt = $dbconn->prepare("SELECT * FROM admin WHERE email=:e");
			$stmt->bindParam(":e", $_POST['email']);

			$stmt->execute();

			if($stmt->rowCount() == 1){

			$row = $stmt->fetch(PDO::FETCH_ASSOC);									
				
			if (!password_verify($_POST['password'],$row['hash'])) {
				return false;
            }else{
                $result[] = true;
                $result[] = $row;
            }
            }
            return $result;
    }

    function doesEmailExists($dbconn,$email){
        $result = false;

        $stmt = $dbconn->prepare("SELECT email FROM admin WHERE :e=email");

        //binding placeholder :e, with value $email
        $stmt->bindParam(":e", $email);
        $stmt->execute();

        $count = $stmt->rowCount();

        if($count > 0){
            $result = true;
        }
        return $result;
    }

    //refactoring error messages
    function displayErrors($errors,$name){
        $result = "";
        if (isset($errors[$name])) { 
            echo '<span class=err >'.$errors[$name].'</span>';
         }	
         return $result;
    }

    //add category
    function addCategory($dbconn,$input){
        $stmt = $dbconn->prepare("INSERT INTO category(category_name) VALUES(:catName)");
        $stmt->bindParam(":catName",$input['cat_name']);
        $stmt->execute();
    }

    //add product
    function addProduct($dbconn,$input){
        $stmt = $dbconn->prepare("INSERT INTO books (title,author, price,publication_date, category, flag, image_path) VALUES(:book_title, :author, :price, :pub_date, :cat, :flag, :img)");
        $data = [
                ":book_title" => $input['book_title'],
                ":author" => $input['author'],
                ":price" => $input['price'],
                ":pub_date" => $input['year'],
                ":cat" => $input['cat'],
                ":flag" => $input ['flag'],
                ":img" => $input ['dest']
            ];
            
            $stmt->execute($data);
    }

    //validate login
    function checkLogin(){
        if(!isset($_SESSION['admin_id'])){
            redirect("login.php");
            //header("location:login.php");
        }
    }

    //redirect
    function redirect($location,$msg){
        header("location:".$location.$msg);
    }

    function viewCategory($dbconn) {
        $result = "";

        $stmt = $dbconn->prepare("SELECT * FROM category");

        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_BOTH)) {
            $result .= '<tr><td>'.$row[0].'</td>';
            $result .= '<td>'.$row[1].'</td>';
            $result .= '<td><a href = "edit_category.php?cat_id='.$row[0].'">edit</a></td>';
            $result .= '<td><a href = "delete_category.php?cat_id='.$row[0].'">delete</a></td>';
        }

        return $result;
    }

    function getCategoryById($dbconn, $id){
    $stmt = $dbconn->prepare("SELECT * FROM category WHERE category_id= :catId");
    $stmt->bindParam(':catId', $id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_BOTH);

    return $row;
    }

    function getProductById($dbconn, $id){
        $result = "";
    $stmt = $dbconn->prepare("SELECT * FROM books WHERE book_id= :bookId");
    $stmt->bindParam(':bookId', $id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_BOTH);

    return $result;
    }

    function updateCategory($dbconn, $input) {

        $stmt = $dbconn->prepare("UPDATE category SET category_name = :catName WHERE category_id = :catId");
        $data = [
            ":catName" =>$input['cat_name'],
            ":catId" =>$input['id']
        ];

        $stmt->execute($data);
    }

    function updateProduct($dbconn, $input) {

        $stmt = $dbconn->prepare("UPDATE books SET title = :book_title, author = :author, price = :price, publication_date = :year, category = :cat, flag = :flag, image_path = :image WHERE book_id = :bookId");
        $data = [
            ":book_title" => $input['book_title'],
            ":author" => $input['author'],
            ":price" => $input['price'],
            ":year" => $input['year'],
            ":cat" => $input['cat'],
            ":bookId" => $input['id']
        ];

        $stmt->execute($data);
    }

    function curNave($page) {

        $curPage = basename($_SERVER['SCRIPT_FILENAME']);

        if($curPage == $page) {
            echo 'class ="selected"';
        }
    }


    function deleteCategory($dbconn, $input){

        $stmt = $dbconn->prepare("DELETE FROM category WHERE category_id = :catId");
        // $stmt->bindParam(':catId', $id);
        $data = [
            ":catId" => $input['id']
        ];

        $stmt->execute($data);
    }

    function deleteProduct($dbconn, $input) {

        $stmt = $dbconn->prepare("DELETE FROM books WHERE book_id = :bookId");
        $data = [
            ":bookId" => $input['id']
        ];

        $stmt->execute($data);
    }

    function fetchCategory($dbconn, $val=null){
        $result = "";

        $stmt = $dbconn->prepare("SELECT * FROM category");

        $stmt -> execute();

        while($row = $stmt->fetch(PDO::FETCH_BOTH)) {

            if($val == $row[1]) {
                continue;
            }
            $result .= '<option value="'.$row[0].'">'.$row[1].'</option>';
        }
        return $result;
    }

        function viewProduct($dbconn) {
            $result = "";

            $stmt = $dbconn->prepare("SELECT * FROM books");

            $stmt -> execute();

            while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {

                $result .= '<tr><td>'.$row[1].'</td>';
                $result .= '<td>'.$row[2].'</td>';
                $result .= '<td>'.$row[3].'</td>';
                $result .= '<td>'.$row[5].'</td>'; 
                $result .= '<td><img src="'.$row[7].'" height="50" width = "50"></td>';
                $result .= '<td><a href ="edit_products.php?book_id='.$row[0].'">edit</a></td>';
                 $result .= '<td><a href ="delete_products.php?book_id='.$row[0].'">delete</a></td></tr>';
            }
                return $result;
        }

        function updateImage($dbconn, $id, $location) {

            $stmt = $dbconn->prepare("UPDATE books SET image_path = :img WHERE book_id = :bookId");

            $data = [
                ":img" => $location,
                ":bookId" => $id
            ];

            $stmt->execute($data);
        }
?>
