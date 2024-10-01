<?php
$pageTitle = "File Viewer - Command Injection Lab";
include '../../../layout/header.php';
?>

<!-- cat.css를 페이지에 포함 -->
<link rel="stylesheet" type="text/css" href="../../../assets/css/ping.css">

<div class="container">
    <h1 class="main-title">File Viewer Utility</h1>
    <p>Enter a filename to view its contents:</p>
    <div class="book_list">
        <p>software.txt &emsp; database.txt &emsp; network.txt</p>
    </div>

    <form method="post" class="ping-form">
        <input type="text" size="30" name="filename" placeholder="example.txt" required><br><br>
        <input type="submit" value="View File" class="submit-button">
    </form>

    <?php
    if (isset($_POST['filename'])) {
        // 입력받은 파일명을 저장
        $filename = $_POST["filename"];

        // 취약한 명령어 구성 (사용자 입력이 검증되지 않음)
        $cmd = "cat " . $filename;

        echo "<h3>Command: $cmd</h3>";

        // shell_exec로 명령어 실행
        $output = shell_exec($cmd);

        // 명령어 실행 결과 출력
        echo "<pre class='result-output'>$output</pre>";
    }
    ?>
</div>

<?php
include '../../../layout/footer.php';
?>
