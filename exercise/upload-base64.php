<?php
$pageTitle = "File Upload - Web Vulnerability Lab";
include '../layout/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="/assets/css/upload.css">

<body>
    <div>
        <h2>File upload Vulnerability</h2>
        <!-- 파일 업로드 폼 -->
        <form action="upload-base64.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" />
            <input type="submit" value="Upload" />
        </form>
    </div>
    

    <?php
    $uploadDir = 'uploads-base64/';

    // 파일 업로드 처리
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $fileName = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME); // 파일 이름만 가져옴
            $fileExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // 파일 확장자 가져옴
            
            $encodedFileName = base64_encode($fileName);
            $uploadFile = $uploadDir . $encodedFileName . '.' . $fileExtension;
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

    <div class="explane">
        <p>이 페이지에는 업로드된 파일의 리스트를 출력하지 않습니다.</p>
        <h2>Hint.</h2>
        <ol>
            <li>업로드된 파일은 <span>`uploads-base64/`</span>에 저장됩니다.</li>
            <li>업로드 파일 명을 그대로 저장하지 않습니다.</li>
        </ol>
    </div>

    <!-- 업로드된 파일 리스트
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
    -->

</body>
</html>

<?php
include '../layout/footer.php';
?>
