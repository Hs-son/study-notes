<?php
// DB 연결 정보
$conn = new mysqli("localhost", "UnivAdmin", "kook1946", "UnivDB");
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

$action = $_GET['action'] ?? 'read';

function sanitize($data) {
    return htmlspecialchars($data, ENT_QUOTES);
}

if ($action == 'create') {
    // 새 학과 추가 처리
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $major_name = $conn->real_escape_string($_POST['major_name']);
        $dept_id = (int)$_POST['dept_id'];

        $sql = "INSERT INTO Majors (major_name, dept_id) VALUES ('$major_name', $dept_id)";
        if ($conn->query($sql) === TRUE) {
            echo "학과가 성공적으로 추가되었습니다.<br>";
            echo "<a href='?action=read'>목록으로 돌아가기</a>";
        } else {
            echo "오류: " . $conn->error;
        }
    } else {
        // 입력 폼 출력
        $dept_result = $conn->query("SELECT dept_id, dept_name FROM Departments");
        echo "<h2>새 학과 추가</h2>";
        echo "<form method='post' action='?action=create'>";
        echo "학과명: <input type='text' name='major_name' required><br>";
        echo "단과대: <select name='dept_id'>";
        while ($row = $dept_result->fetch_assoc()) {
            echo "<option value='".sanitize($row['dept_id'])."'>".sanitize($row['dept_name'])."</option>";
        }
        echo "</select><br>";
        echo "<input type='submit' value='추가'>";
        echo "</form>";
        echo "<a href='?action=read'>목록으로 돌아가기</a>";
    }
} elseif ($action == 'update') {
    // 학과 수정 처리
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $major_id = (int)$_POST['major_id'];
        $major_name = $conn->real_escape_string($_POST['major_name']);
        $dept_id = (int)$_POST['dept_id'];

        $sql = "UPDATE Majors SET major_name='$major_name', dept_id=$dept_id WHERE major_id=$major_id";
        if ($conn->query($sql) === TRUE) {
            echo "학과 정보가 성공적으로 수정되었습니다.<br>";
            echo "<a href='?action=read'>목록으로 돌아가기</a>";
        } else {
            echo "오류: " . $conn->error;
        }
    } else {
        $major_id = (int)$_GET['id'];
        $result = $conn->query("SELECT * FROM Majors WHERE major_id=$major_id");
        $major = $result->fetch_assoc();

        if (!$major) {
            echo "학과를 찾을 수 없습니다.";
            exit;
        }

        $dept_result = $conn->query("SELECT dept_id, dept_name FROM Departments");

        echo "<h2>학과 수정</h2>";
        echo "<form method='post' action='?action=update'>";
        echo "<input type='hidden' name='major_id' value='".sanitize($major['major_id'])."'>";
        echo "학과명: <input type='text' name='major_name' value='".sanitize($major['major_name'])."' required><br>";
        echo "단과대: <select name='dept_id'>";
        while ($row = $dept_result->fetch_assoc()) {
            $selected = ($row['dept_id'] == $major['dept_id']) ? "selected" : "";
            echo "<option value='".sanitize($row['dept_id'])."' $selected>".sanitize($row['dept_name'])."</option>";
        }
        echo "</select><br>";
        echo "<input type='submit' value='수정'>";
        echo "</form>";
        echo "<a href='?action=read'>목록으로 돌아가기</a>";
    }
} elseif ($action == 'delete') {
    // 학과 삭제 처리
    $major_id = (int)$_GET['id'];
    $sql = "DELETE FROM Majors WHERE major_id=$major_id";

    if ($conn->query($sql) === TRUE) {
        echo "학과가 삭제되었습니다.<br>";
    } else {
        echo "오류: " . $conn->error;
    }
    echo "<a href='?action=read'>목록으로 돌아가기</a>";
} else {
    // 목록 보여주기 (Read)
    $sql = "SELECT m.major_id, m.major_name, d.dept_name FROM Majors m JOIN Departments d ON m.dept_id = d.dept_id ORDER BY m.major_id";
    $result = $conn->query($sql);

    echo "<h2>학과 목록</h2>";
    echo "<a href='?action=create'>새 학과 추가</a><br><br>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>ID</th><th>학과명</th><th>단과대</th><th>수정</th><th>삭제</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . sanitize($row['major_id']) . "</td>";
        echo "<td>" . sanitize($row['major_name']) . "</td>";
        echo "<td>" . sanitize($row['dept_name']) . "</td>";
        echo "<td><a href='?action=update&id=" . sanitize($row['major_id']) . "'>수정</a></td>";
        echo "<td><a href='?action=delete&id=" . sanitize($row['major_id']) . "' onclick=\"return confirm('정말 삭제할까요?');\">삭제</a></td>";
        echo "</tr>";
    }

    echo "</table>";
}

$conn->close();
?>
