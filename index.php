<?php
$pageTitle = "Home - Web Vulnerability Lab";
setcookie("Cookie", "Security_Academy", time() + 3600, "/");  
include 'layout/header.php';
?>
    <link rel="stylesheet" href="/assets/css/index.css">

    <h1 class="content_title">Welcome to the Web Vulnerability Lab</h1>
    <p>Security_Academy 4기 모의해킹 미니 프로젝트 입니다.</p>
    <p>취약점에 대한 설명과 실습을 진행해보세요</p>
    <ul>
        <li><a href="description/command_line_injection.php">Command Line Injection</a></li>
        <li><a href="description/sqli.php">SQL Injection (SQLi)</a></li>
        <li><a href="description/xss.php">Cross Site Script (XSS)</a></li>
        <li><a href="description/file_upload.php">File Upload</a></li>
        <li><a href="description/directory_indexing.php">Directory Indexing</a></li>
        <li><a href="description/file_download.php">file Download</a></li>

	<!-- 여기에 다른 링크 추가 가능 -->
    </ul>

<?php
include 'layout/footer.php';
?>

