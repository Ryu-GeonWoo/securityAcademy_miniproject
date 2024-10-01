<?php
$pageTitle = "Ping - Web Vulnerability Lab";
include '../../../layout/header.php';
?>

<!-- ping.css를 페이지에 포함 -->
<link rel="stylesheet" type="text/css" href="../../../assets/css/ping.css">

<div class="container">
    <h1 class="main-title">Ping Utility</h1>
    <p>Enter an IP address to check its connectivity:</p>
    
    <form method="post" class="ping-form">
        <input type="text" size="30" name="ipaddress" placeholder="8.8.8.8" required><br><br>
        <input type="submit" value="Check" class="submit-button">
        <button type="button" class="submit-button" onclick="location.href='../ping2/ping-2.php'">Go to Ping-2 Page</button>
    </form>

    <?php
    if (isset($_POST['ipaddress'])) {
        $ipaddress = ($_POST["ipaddress"]); 
        $cmd = "ping -c 4 " . $ipaddress;
        echo "<h3>Command: $cmd</h3>";
        $output = shell_exec($cmd);
        echo "<pre class='result-output'>$output</pre>";
    }
    // Ping-2 페이지로 이동
    if (isset($_POST['go_to_ping2'])) {
        header("Location: ../ping2/ping-2.php");
        exit;
    }
    ?>
</div>

<?php
include '../../../layout/footer.php';
?>
