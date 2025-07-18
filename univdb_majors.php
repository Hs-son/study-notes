<?php
include 'univdb_config.php';

$conn = new mysqli('localhost', $user, $pass, 'UnivDB');

if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

$sql = "SELECT major_id, major_name, dept_id FROM Majors";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Majors 목록</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>학과명</th><th>학부ID</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['major_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['major_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['dept_id']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "데이터가 없습니다.";
}

$conn->close();
?>
