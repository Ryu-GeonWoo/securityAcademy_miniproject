<?php
// MySQL 연결 정보
$servername = "localhost"; #서버의 실제주소
$db_username = "security"; #mysql ID
$password = "security"; # mysql password
$dbname = "mini_project"; #사용할 데이터베이스 이름
// MySQL 연결
$conn = new mysqli($servername, $db_username, $password, $dbname);
$conn->set_charset("utf8");
// 연결 확인
if ($conn->connect_error) {
die("MySQL 연결 실패: " . $conn->connect_error);
}
?>