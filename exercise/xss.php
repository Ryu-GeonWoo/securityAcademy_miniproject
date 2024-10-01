<?php
  include '../layout/header.php';

  $con = mysqli_connect('127.0.0.1', 'security', 'security', 'mini_project') or die('DB connection failed');
?>

<html>
  <head>
    <title>Memo Board</title>
    <link rel="stylesheet" href="/assets/css/xss.css">
  </head>
  <body>
    <h2>Memo Board - Search Memos</h2>
    <form action="" method="GET">
      Title:
      <input type="text" id="title" name="title">
      <input type="submit" id="search" value="Search">
    </form>

    <?php
    // 기본 SQL: 모든 게시글을 가져옴 (관리자는 제외)
    if (isset($_GET['title']) && $_GET['title'] != '') {
        // 제목을 검색할 때
        $sql = "SELECT title, content, author, created_at FROM memo WHERE title LIKE '%" . $_GET['title'] . "%'";
        echo "Search results for: '" . $_GET['title'] . "'";
    } else {
        // 검색하지 않을 때
        $sql = "SELECT title, content, author, created_at FROM memo";
    }

    // SQL 쿼리 실행
    $ret = mysqli_query($con, $sql);

    // 테이블 출력
    echo "<table border=1>";
    echo "<tr><th>Title</th><th>Content</th><th>Author</th><th>Date</th></tr>";

    // 결과 출력
    while ($row = mysqli_fetch_array($ret)) {
        echo "<tr>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['content'] . "</td>";
        echo "<td>" . $row['author'] . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";

    // 데이터베이스 연결 종료
    mysqli_close($con);
    ?>
  </body>
</html>
<?php include '../layout/footer.php'; ?>
