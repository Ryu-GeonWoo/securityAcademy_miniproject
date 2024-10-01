<?php
include '../../layout/header.php';

$conn = mysqli_connect('localhost', 'security', 'security', 'mini_project') or die('DB connection failed');

function filter_html_tags($string) {
    // Remove script and other dangerous tags
    $string = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $string);
    $string = preg_replace('/<iframe\b[^>]*>(.*?)<\/iframe>/is', '', $string);
    $string = preg_replace('/<object\b[^>]*>(.*?)<\/object>/is', '', $string);
    $string = preg_replace('/<embed\b[^>]*>(.*?)<\/embed>/is', '', $string);
    $string = preg_replace('/<form\b[^>]*>(.*?)<\/form>/is', '', $string);
    return $string;
}

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $create_at = date("Y-m-d H:i:s");

    // 필터링: 'script'와 같은 문자열을 제거
    $filtered_content = filter_html_tags($content);
    

    // SQL 쿼리 (author 및 created_at 필드 추가)
    $sql = "INSERT INTO memo2 (title, content, author, created_at) VALUES ('$title', '$filtered_content', '$author', '$create_at')";
    $ret = mysqli_query($conn, $sql);

    if ($ret) {
        header('Location: list.php');

        exit();
    } else {
        echo "Error adding post: " . mysqli_error($conn);
    }
}

?>

<head>
    <link rel="stylesheet" href="/assets/css/xss.css">
    <link rel="stylesheet" href="/assets/css/xss_stored.css">
</head>

<body>
    <h1>Create New Memo 2</h1>

    <form action="" method="POST">
        <div class="input-container">
            <input type="text" class="input-title" size="20" name="title" pattern=".{1,50}" placeholder="Title"><br><br>
            <input type="text" class="input-author" name="author" placeholder="Author">
        </div><br>
        <textarea name="content" cols="60" rows="5" placeholder="Content"></textarea><br>
        <input type="submit" name="submit" value="Submit"><br>
    </form>
    <br>
    <a href="list.php" class="button">Back to Memo List</a>

</body>

<?php include '../../layout/footer.php'; ?>

