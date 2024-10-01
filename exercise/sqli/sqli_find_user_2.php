<?php
$pageTitle = "Sqli - Web Vulnerability Lab";
include '../../layout/header.php';

$mysqli = new mysqli("localhost", "security", "security", "mini_project");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
    <link rel="stylesheet" type="text/css" href="../../assets/css/find_user.css">

    <h1 class="main-title">Find User 2</h1>
    <p>Enter Username to find.<br> Filtering admin</p>

    <form method="post" class="find-form">
        <input type="text" size="30" name="name" placeholder="username" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"><br><br>
        <input type="submit" value="Search" class="submit-button">
    </form>

    <?php
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $nameLower = strtolower($name);

        // "admin" 문자열이 포함되어 있는지 검사
        if (strpos($nameLower, 'admin') !== false) {
            echo "<pre class='result-output'><strong>You can't search admin</strong></pre>";
        } else {
            $query = "SELECT * FROM users WHERE name = '$name'";

            // SQL 쿼리 실행
            $result = $mysqli->query($query);

            if ($result->num_rows > 0) {
                $output = "";
                while ($row = $result->fetch_assoc()) {
                    $output .= "ID: " . $row["id"] . "\t\tName: " . $row["name"] . "\t\tEmail: " . $row["email"] . "\n";
                }
                echo "<pre class='result-output'>$output</pre>";
            } else {
                echo "<pre class='result-output'><strong>No User...</strong></pre>";
            }
        }
    }
    $mysqli->close();
    ?>

<?php
include '../../layout/footer.php';
?>
