<?php
$conn = new mysqli('localhost', 'UnivAdmin', 'kook1946', 'UnivDB');
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

// POST 데이터 받기
$major_id = isset($_POST['major_id']) ? (int)$_POST['major_id'] : 0;
$major_name = isset($_POST['major_name']) ? $conn->real_escape_string($_POST['major_name']) : '';
$dept_id = isset($_POST['dept_id']) ? (int)$_POST['dept_id'] : 0;

if ($major_id <= 0 || empty($major_name) || $dept_id <= 0) {
    die("잘못된 입력입니다.");
}

// 업데이트 쿼리
$sql = "UPDATE Majors SET major_name = '$major_name', dept_id = $dept_id WHERE major_id = $major_id";

if ($conn->query($sql) === TRUE) {
    // 성공 시 목록 페이지로 이동
    header("Location: univdb_majors.php");
    exit;
} else {
    echo "수정 실패: " . $conn->error;
}

$conn->close();
?>
