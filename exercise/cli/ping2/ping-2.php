<?php
$pageTitle = "Ping - Web Vulnerability Lab";
include '../../../layout/header.php';
?>

<!-- ping.css를 페이지에 포함 -->
<link rel="stylesheet" type="text/css" href="../../../assets/css/ping.css">

<div class="container">
    <h1 class="main-title">Ping Utility - 2</h1>
    <p>Filtering some character</p>

    <form method="post" class="ping-form">
        <input type="text" size="30" name="ipaddress" placeholder="8.8.8.8" pattern="[0-9a-zA-Z].{5,20}" required><br><br>
        <input type="submit" value="Check" class="submit-button">
        <button type="button" class="submit-button" onclick="location.href='../ping/ping.php'">Return to ping-1</button>

    </form>

    <?php
    if (isset($_POST['ipaddress'])) {
        $ipaddress = ($_POST["ipaddress"]);
        $cmd = "ping -c 4 " . "'" . $ipaddress . "'";
        echo "<h3>Command: $cmd</h3>";
        $output = shell_exec($cmd);
        echo "<pre class='result-output'>$output</pre>";
    }
    ?>
</div>

<?php
include '../../../layout/footer.php';
?>