<?php
	session_start(); 
    $page_title = "Admin Dashboard";
    include 'includes/funct.php';
    include 'includes/dashboard_header.php';
    include 'includes/db.php'; 

    checklogin();

    if($_GET['book_id']){
    	$book_id = $_GET['book_id'];
    }

    $clean['id'] = $book_id;

    deleteProduct($conn, $clean);

    /*$stmt = $conn->prepare("DELETE FROM books WHERE book_id = :bookId");
        //$stmt->bindParam(':bookId', $id);
        $data = [
        ":bookId" => $clean['id'] 
        ];

        $stmt->execute($data);*/

    redirect("view_products.php");
?>