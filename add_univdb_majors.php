<?php
// DB 연결
include 'univdb_config.php';

$conn = new mysqli('localhost', $user, $pass, 'UnivDB');
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

// 폼에서 전송된 경우
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $major_name = $_POST['major_name'];
    $dept_id = $_POST['dept_id'];

    $stmt = $conn->prepare("INSERT INTO Majors (major_name, dept_id) VALUES (?, ?)");
    $stmt->bind_param("si", $major_name, $dept_id);

    if ($stmt->execute()) {
        echo "<p style='color:green; text-align:center;'>학과 추가 완료!</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>오류 발생: " . $conn->error . "</p>";
    }
    $stmt->close();
}

// 단과대 목록 불러오기
$departments = $conn->query("SELECT dept_id, dept_name FROM Departments");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>학과 추가</title>
</head>
<body>
    <h2 style="text-align:center;">새로운 학과 추가</h2>
    <form method="post" action="add_univdb_majors.php" style="width:300px; margin:auto;">
        <label>학과명:</label><br>
        <input type="text" name="major_name" required><br><br>

        <label>단과대 선택:</label><br>
        <select name="dept_id" required>
            <?php while ($row = $departments->fetch_assoc()): ?>
                <option value="<?= $row['dept_id'] ?>"><?= htmlspecialchars($row['dept_name']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit">추가</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
