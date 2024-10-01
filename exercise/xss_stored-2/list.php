<?php
include '../../layout/header.php';

$conn = mysqli_connect('localhost', 'security', 'security', 'mini_project') or die('DB connection failed');



// 게시글 삭제 기능
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM memo2 WHERE id = '$id'";
    $ret = mysqli_query($conn, $sql);

    if ($ret) {
        echo "Post deleted successfully!";
    } else {
        echo "Error deleting post: " . mysqli_error($conn);
    }
}
?>

<head>

    <link rel="stylesheet" href="/assets/css/xss.css">    
    <link rel="stylesheet" href="/assets/css/xss_stored.css">

</head>

<body>
    <h1>MEMO - 2 LIST</h1>
    <a href="create.php" class="button">Create New Memo</a>

    <table border=1>
        <tr>
            <th>No.</th><th>Title</th><th>Author</th><th>Created At</th><th>Actions</th>
        </tr>

        <?php
        // 데이터베이스에 있는 메모 출력
        $sql = "SELECT * FROM memo2 ORDER BY id DESC";
        $ret = mysqli_query($conn, $sql);
        
        while ($row = mysqli_fetch_array($ret)) {
            echo "<tr>";
            echo "<td>", $row["id"], "</td>";
            echo "<td><a href='detail.php?id=".$row["id"]."'>", $row["title"], "</a></td>";
            echo "<td>", $row["author"], "</td>";
            echo "<td>", $row["created_at"], "</td>";
            echo "<td>
                    <form action='' method='POST'>
                    <input type='hidden' name='id' value='".$row["id"]."'>
                    <input type='submit' name='delete' value='Delete'>
                </form>
                  </td>";
            echo "</tr>";
        }
        mysqli_close($conn);
        ?>
    </table>

</body>

<?php include '../../layout/footer.php'; ?>

