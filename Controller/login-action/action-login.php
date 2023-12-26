<?php
    include_once __DIR__ . '/../../model/database.php';
    include_once __DIR__ . '/../../model/user.php';
    session_start();
    if(isset($_POST['inputUsername']) && isset($_POST['inputPassword'])) {
        $username = $_POST['inputUsername'];
        $password = $_POST['inputPassword'];
        $db = database::getDB();
        $u = new user($db);
        $role = $u->checkUser($username, $password);
        if($role == 1 || $role == 0) {
            $_SESSION['role'] = $role;
            $_SESSION['username'] = $username;
            $_SESSION['action'] = 'view'; 
            $_SESSION['userId'] = $u->getUserIdFromData($username);
            echo json_encode(array(
                'status' => 1,
                'message' => 'Đăng nhập thành công'
            ));
            exit;
        }
        else{
            echo json_encode(array(
                'status' => 0,
                'message' => 'Thông tin đăng nhập không đúng'
            ));
            exit;
        }
    }
    else {
        echo json_encode(array(
            'status' => 0,
            'message' => 'Thông tin đăng nhập không đúng'
        ));
        exit;
    }
?>