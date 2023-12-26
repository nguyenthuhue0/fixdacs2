<?php
    include_once __DIR__ . '/../../model/database.php';
    include_once __DIR__ . '/../../model/user.php';

    if (isset($_GET['id'])) {
        $userId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        $db = database::getDB();
        $user = new User($db);
        $result = $user->deleteUser($userId);

        if ($result) {
            header("Location: ../../View/admin/edit-user.php");
            exit();
        } else {
            echo "Error deleting user.";
        }
    } else {
        echo "Invalid user ID.";
    }
?>
