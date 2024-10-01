<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>로그인</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f5f5f5;
        }

        h1 {
            color: #333;
        }

        .message {
            margin-bottom: 20px;
            font-size: 18px;
            color: #777;
        }

        .button-container {
            margin-top: 20px;
        }

        .button-container button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button-container button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php
    include "db_conn.php";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];


        $sql = "SELECT * FROM users WHERE name='$username' AND password='$password'";
        $result = $conn->query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            
            $row = $result->fetch_assoc();
            $username = $row['username'];
            $password=$row['password'];
            $email=$row['email'];

            if (!isset($_SESSION['username'])) { 
                ?>
                            <h1>반갑습니다, <?php echo $email; ?> 님! &#128075;</h1>
                            <div class="message">
                                Login 되었습니다!
                            </div>
                            <?php
                            $_SESSION['username']  = $username ;
                            $_SESSION['email'] =$email;?>
                            <div class="button-container">
                                <button onclick="logout()">Logout</button>
                            </div>
                <?php
                        } 
                        else {     
            
                                $username= $_SESSION['username'] ;
                                $password= $_SESSION['password'];                  
                ?>          
                            <h1><?php echo $email; ?> 님! &#128075;</h1>
                            <h1>이미 로그인되었습니다. &#128064;</h1>
                            
                            <div class="message">
                                새로운 계정으로 로그인하시려면 로그아웃 후 진행해주세요.</div>
                            <div class="button-container">    
                                <button onclick="logout()">Logout</button>
                            </div>
                <?php
                        }
        }


    else{

        ?> 
        
        <h1> 로그인에 실패 하였습니다 </h1>
        
        <?php
        include "access_failed.html";


    }
    
    }
         
    
    ?>
    <script>
        function logout() {
            window.location.href = "logout.php";
        }
    </script>
</body>
</html>