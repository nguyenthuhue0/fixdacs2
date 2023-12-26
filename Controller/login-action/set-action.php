<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["action"])) {
        $_SESSION['action'] = $_POST["action"];
        echo json_encode(array(
            'status' => 1,
        ));
    } else {
        echo json_encode(array(
            'status' => 0,
        ));
    }
} else {
    echo json_encode(array(
        'status' => 0,
    ));
}
?>
