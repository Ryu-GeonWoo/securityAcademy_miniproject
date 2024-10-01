<?php
include '../../layout/header.php';

$conn = mysqli_connect('localhost', 'security', 'security', 'mini_project') or die('DB connection failed');

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $create_at = date("Y-m-d H:i:s");

    // SQL 쿼리 (author 및 created_at 필드 추가)
    $sql = "INSERT INTO memo (title, content, author, created_at) VALUES ('$title', '$content', '$author', '$create_at')";
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
    <h1>Create New Memo</h1>

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

