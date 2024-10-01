<?php
$pageTitle = "File Upload - Web Vulnerability Lab";
include '../layout/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="/assets/css/index.css">

<body>
    <div>
        <h2>File upload Vulnerability</h2>
        <!-- 파일 업로드 폼 -->
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" />
            <input type="submit" value="Upload" />
        </form>
    </div>
    

    <?php
    $uploadDir = 'uploads/';

    // 파일 업로드 처리
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $uploadFile = $uploadDir . basename($_FILES['file']['name']);

            // 파일을 업로드 디렉토리에 저장
            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
                echo "<p>File is successfully uploaded.</p>";
            } else {
                echo "<p>File upload failed!</p>";
            }
        } else {
            echo "<p>No file was uploaded or there was an upload error.</p>";
        }
    }
    ?>

    <!-- 업로드된 파일 리스트 -->
    <h3>Uploaded Files</h3>
    <ul>
        <?php
        // 업로드된 파일들 목록을 출력
        if (is_dir($uploadDir)) {
            if ($handle = opendir($uploadDir)) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != "..") {
                        echo "<li><a href='{$uploadDir}{$entry}' target='_blank'>{$entry}</a></li>";
                    }
                }
                closedir($handle);
            }
        } else {
            echo "<p>Upload directory does not exist.</p>";
        }
        ?>
    </ul>

</body>
</html>

<?php
include '../layout/footer.php';
?>
