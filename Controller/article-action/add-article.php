<?php
include_once __DIR__ . '/../../model/database.php';
include_once __DIR__ . '/../../model/article.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['userId'];
    $title = htmlspecialchars(trim($_POST['inputTitle']));
    $content = htmlspecialchars(trim($_POST['inputContent']));
    $db = database::getDB();
    $article = new article($db);
    if(isset($_POST['id'])) {
        if (!empty($_FILES['inputImg']['name'])) {
            $uploadDir = '../../View/uploads/';
            $uploadFile = $uploadDir . basename($_FILES['inputImg']['name']);
    
            if (move_uploaded_file($_FILES['inputImg']['tmp_name'], $uploadFile)) {
            } 
            else {
                $response = array('status' => 0, 'message' => 'Error uploading file.');
                echo json_encode($response);
                exit();
            }
        } 
        else{
            $uploadFile = $_POST['img'];
        }
    }
    else{
        if (isset($_FILES['inputImg']) && $_FILES['inputImg']['error'] === UPLOAD_ERR_OK && !empty($_FILES['inputImg']['name'])) {
            $uploadDir = '../../View/uploads/';
            $uploadFile = $uploadDir . basename($_FILES['inputImg']['name']);
    
            if (move_uploaded_file($_FILES['inputImg']['tmp_name'], $uploadFile)) {
            } 
            else {
                $response = array('status' => 0, 'message' => 'Error uploading file.');
                echo json_encode($response);
                exit();
            }
        } else {
            $response = array('status' => 0, 'message' => 'Error uploading file.');
            echo json_encode($response);
            exit();
        }

    }
    $img = $uploadFile;
    $currentDate = date('Y-m-d');
    
    $article->setUserId($_SESSION['userId']);
    $article->setTitle($title);
    $article->setContent($content);
    $article->setImg($img);
    $article->setDatePosted($currentDate);

    if (isset($_POST['id'])) {
        $articleId = $_POST['id'];
        $article->saveToDatabase($_SESSION['role'], $articleId);
    }
    else{
        $article->saveToDatabase($_SESSION['role']);
    }    
    if (isset($_POST['id'])) {
        $response = array('status' => 1, 'message' => 'Article update successfully.');
        echo json_encode($response);
    }
    else{
        $response = array('status' => 1, 'message' => 'Article added successfully.');
        echo json_encode($response);
    }
} else {
    $response = array('status' => 0, 'message' => 'Invalid request.');
    echo json_encode($response);
}
?>