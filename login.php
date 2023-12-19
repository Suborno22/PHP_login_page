<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        $u = "ucyug1o0s8d2gupy";
        $pwd = "Xd0MHrMMM8C2YqbvhNP2";
        $host = "bx4tzgrjfpptbqjg7uyr-mysql.services.clever-cloud.com";
        $port = 3306;
        $database = "bx4tzgrjfpptbqjg7uyr";
        $conn = mysqli_connect($host, $u, $pwd, $database);
        if ($conn == false) {
            echo "Connection error: " . $conn->error;
        }
    
        // Prepare a query to retrieve user information based on the provided username
        $query = "SELECT * FROM `User` WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
    
            if (password_verify($password, $user['password'])) {
                echo"Successfully logged in";
            } else {
                echo"Invalid username or password";
            }
        } else {
            echo"Invalid username or password";
        }
    
        mysqli_close($conn);
    }
}
?>