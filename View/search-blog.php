// Kết nối cơ sở dữ liệu
<?php
include_once __DIR__ . '/../../Model/database.php';
include_once __DIR__ . '/../../Model/userInfo.php';
include_once __DIR__ . '/../../Model/article.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$db = database::getDB();
$article = new Article($db);
$userInfo = new UserInfo($db);

$articles = $article->loadAllArticleAd();


// Lấy từ khóa tìm kiếm từ form
$tu_khoa = $_GET['tu_khoa'];

// Truy vấn SQL để tìm kiếm sản phẩm
$sql = "SELECT * FROM sanpham WHERE ten_san_pham LIKE '%$tu_khoa%'";
$result = $conn->query($sql);

// Hiển thị kết quả tìm kiếm
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Tên sản phẩm: " . $row["ten_san_pham"] . "<br>";
    }
} else {
    echo "Không tìm thấy sản phẩm.";
}

// Đóng kết nối
$conn->close();
?>