<?php
include 'univdb_config.php';

$conn = new mysqli('localhost', $user, $pass, 'UnivDB');

if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

$sql = "SELECT dept_id, dept_name FROM Departments";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>학과 ID</th><th>학과명</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['dept_id'] . "</td><td>" . $row['dept_name'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "데이터가 없습니다.";
}

$conn->close();
?>
