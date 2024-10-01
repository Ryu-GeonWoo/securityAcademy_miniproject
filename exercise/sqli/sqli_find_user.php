<?php
$pageTitle = "Sqli - Web Vulnerability Lab";
include '../../layout/header.php';
// 에러 표시 설정
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>

<html lang="ko">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />    
        <link rel="stylesheet" type="text/css" href="../../assets/css/find_user.css">

    </head>
    <body>
    <div>

    <div>
        <form action="#" method="GET" class="find-form">
            <p>
                <h2>Find User</h2><br>
                <input type="text" size="15" name="name">
                <input type="submit" name="Submit" value="제출" class="submit-button">
            <button type="button" class="submit-button" onclick="location.href='./sqli_find_user_2.php'">Go to Find user 2 Page</button>

            </p>
        </form>

    </div>

    <?php
    if(isset($_REQUEST['Submit'])){
        // 데이터베이스 연결 설정
        $servername = "localhost";
        $username = "security";
        $password = "security";
        $database = "mini_project";

        $conn = mysqli_connect($servername, $username, $password, $database);

        $name = $_REQUEST['name'];

        // 사용자가 입력한 값을 쿼리에 삽입
        $query  = "SELECT id, name, email FROM users WHERE name = '$name';";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            // SQL 쿼리 에러 발생 시 에러 메시지 출력
            echo "에러: " . mysqli_error($conn) . "<br>";
        } else {
            if(mysqli_num_rows($result) > 0) {
                $output = "";
                while($row = mysqli_fetch_assoc($result)){
                    $id = $row["id"];
                    $name = $row["name"];
                    $email = $row["email"];
                    $output .= "ID: {$id} \t 이름: {$name} \t 이메일: {$email}<br>";
                }
                echo "<pre class='result-output'>$output</pre>";
            } else {
                echo "이름에 해당하는 사용자가 없습니다.<br>";
            }
        }

        mysqli_close($conn);
    }
    ?>

    </div>
    </body>

</html>

<?php
include '../../layout/footer.php';
?>