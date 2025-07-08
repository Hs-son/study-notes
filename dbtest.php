<?php
$conn = new mysqli('localhost', 'TestAdmin', 'test123', 'testdb');

if ($conn->connect_error) {
	die("연결 실패: ". $conn->connect_error);
}
echo "testdb MySQL 연결 성공!!!";
$conn->close();
?>
