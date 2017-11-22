<?php
	session_start(); 
    $page_title = "Admin Dashboard";
    include 'includes/funct.php';
    include 'includes/dashboard_header.php';
    include 'includes/db.php'; 

    checklogin();

    if($_GET['cat_id']){
    	$cat_id = $_GET['cat_id'];
    }

    $clean['id'] = $cat_id;

    deleteCategory($conn, $clean);

    /*$stmt = $conn->prepare("DELETE FROM category WHERE category_id = :catId");
        //$stmt->bindParam(':catId', $id);
        $data = [
        ":catId" => $clean['id'] 
        ];

        $stmt->execute($data);*/

    redirect("view_category.php");
?>