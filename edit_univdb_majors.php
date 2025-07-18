<?php
include 'univdb_config.php';

// DB 연결 정보
$conn = new mysqli('localhost', $user, $pass, 'UnivDB');
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

// major_id 받기 (GET)
if (!isset($_GET['major_id'])) {
    die("major_id가 없습니다.");
}
$major_id = (int)$_GET['major_id'];

// major 정보 가져오기
$sql = "SELECT major_id, major_name, dept_id FROM Majors WHERE major_id = $major_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("해당 학과를 찾을 수 없습니다.");
}

$major = $result->fetch_assoc();

// Departments 목록 가져오기 (select 옵션용)
$sql_depts = "SELECT dept_id, dept_name FROM Departments ORDER BY dept_name";
$depts_result = $conn->query($sql_depts);

$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>학과 수정</title>
</head>
<body>
<h2>학과 수정</h2>
<form method="post" action="update_univdb_majors.php">
    <input type="hidden" name="major_id" value="<?php echo htmlspecialchars($major['major_id']); ?>">
    학과명: <input type="text" name="major_name" value="<?php echo htmlspecialchars($major['major_name']); ?>" required><br><br>
    소속 단과대학:
    <select name="dept_id" required>
        <?php
        while ($dept = $depts_result->fetch_assoc()) {
            $selected = ($dept['dept_id'] == $major['dept_id']) ? "selected" : "";
            echo "<option value=\"" . htmlspecialchars($dept['dept_id']) . "\" $selected>" . htmlspecialchars($dept['dept_name']) . "</option>";
        }
        ?>
    </select><br><br>
    <input type="submit" value="수정 완료">
</form>
<a href="univdb_majors.php">학과 목록으로 돌아가기</a>
</body>
</html>
