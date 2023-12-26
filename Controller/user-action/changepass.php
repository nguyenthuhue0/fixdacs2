<?php
include_once __DIR__ . '/../../model/database.php';
include_once __DIR__ . '/../../model/user.php';

session_start();
$db = database::getDB();
$user = new user($db);

if (
    isset($_POST['inputNowPassword'])
    && isset($_POST['inputPassword'])
    && isset($_POST['inputComPassword'])
) {
    $nowPass = $_POST['inputNowPassword'];
    $password = $_POST['inputPassword'];
    $comPassword = $_POST['inputComPassword'];

    $wrongNowPass = $user->isPasswordCorrect($nowPass, $_SESSION['userId']);
    $wrongComPass = $password === $comPassword;

    if (!$wrongNowPass) {
        echo json_encode(array(
            'status' => 0,
            'message' => 'Wrong current password'
        ));
        exit;
    }
    elseif (!$wrongComPass) {
        echo json_encode(array(
            'status' => 0,
            'message' => 'Password and Confirm Password dont match'
        ));
        exit;
    }

    $user->setUserId($_SESSION['userId']);
    try {
        $user->changePassword($comPassword);
        echo json_encode(array(
            'status' => 1,
            'message' => 'Change password succesfully'
        ));
    } catch (PDOException $e) {
        echo json_encode(array(
            'status' => 0,
            'message' => 'Error when saving information. Please try again later.'
        ));
    }
} else {
    echo json_encode(array(
        'status' => 0,
        'message' => 'Wrong information'
    ));
    exit;
}
?>
