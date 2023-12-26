<?php
    session_start();
    include_once __DIR__ . '/../../model/database.php';
    include_once __DIR__ . '/../../model/user.php';

    if (isset($_POST['inputEmail']) && isset($_POST['inputPassword']) && isset($_POST['inputUsername']) && isset($_POST['inputPasswordConfirm'])) {
        $username = $_POST['inputUsername'];
        $password = $_POST['inputPassword'];
        $password1 = $_POST['inputPasswordConfirm'];
        $email = $_POST['inputEmail'];

        $db = database::getDB();
        $u = new user($db);
        $result = strcasecmp($password, $password1);

        if ($u->isUsernameTaken($username)) {
            echo json_encode(array(
                'status' => 0,
                'message' => 'Tên đăng nhập đã tồn tại'
            ));
            exit;
        }
        elseif ($result != 0) {
            echo json_encode(array(
                'status' => 0,
                'message' => 'Mật khẩu không trùng nhau'
            ));
            exit;
        }

        $success = $u->insertUser($username, $password, $email);

        if ($success) {
            $_SESSION['action'] = 'login';
            echo json_encode(array(
                'status' => 1,
                'message' => 'Đăng ký thành công'
            ));
            exit;
        } else {
            echo json_encode(array(
                'status' => 0,
                'message' => 'Có lỗi xảy ra khi đăng ký'
            ));
            exit;
        }
    } else {
        echo json_encode(array(
            'status' => 0,
            'message' => 'Thông tin đăng ký không đúng'
        ));
        exit;
    }
?>