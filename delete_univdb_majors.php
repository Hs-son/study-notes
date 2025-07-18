<?php
include 'univdb_config.php';

$conn = new mysqli('localhost', $user, $pass, 'UnivDB');
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

if (isset($_GET['major_id'])) {
    $major_id = intval($_GET['major_id']);
    $sql = "DELETE FROM Majors WHERE major_id = $major_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: univdb_majors.php"); // 삭제 후 목록 페이지로 이동
        exit();
    } else {
        echo "삭제 실패: " . $conn->error;
    }
} else {
    echo "major_id가 없습니다.";
}

$conn->close();
?>
