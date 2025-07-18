<?php
include 'univdb_config.php';

$conn = new mysqli('localhost', $user, $pass , 'UnivDB');
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

$sql = "SELECT m.major_name, d.dept_name 
        FROM Majors m 
        JOIN Departments d ON m.dept_id = d.dept_id";
$result = $conn->query($sql);

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>학과-단과대 리스트</title>
    <style>
        table {
            border-collapse: collapse;
            width: 60%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
        }
        tr:hover {
            background-color: #e0f7fa;
        }
    </style>
</head>
<body>
    <h2 style='text-align:center;'>학과별 단과대 리스트</h2>";

if ($result->num_rows > 0) {
    echo "<table><tr><th>학과명</th><th>소속 단과대</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . htmlspecialchars($row['major_name']) . "</td><td>" . htmlspecialchars($row['dept_name']) . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align:center;'>데이터가 없습니다.</p>";
}

echo "</body></html>";

$conn->close();
?>
