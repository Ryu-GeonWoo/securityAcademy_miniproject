<?php
include '../../layout/header.php';

$conn = mysqli_connect('localhost', 'security', 'security', 'mini_project') or die('DB connection failed');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM memo WHERE id = '$id'";
    $ret = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($ret);
} else {
    echo "No ID provided!";
    exit;
}
?>

<head>
    <link rel="stylesheet" href="/assets/css/xss.css">
    <link rel="stylesheet" href="/assets/css/xss_stored.css">
</head>

<body>
    <h1>Memo Details</h1>

    <h2>Title: <?php echo $row['title']; ?></h2>
    <p><strong>Author:</strong> <?php echo $row['author']; ?></p>
    <p><strong>Content:</strong></p>
    <p><?php echo nl2br($row['content']); ?></p>
    <p><strong>Created At:</strong> <?php echo $row['created_at']; ?></p>

    <a href="list.php" class="button">Back to Memo List</a>

</body>

<?php
mysqli_close($conn);
include '../../layout/footer.php';
?>

