<?php
$u = "ucyug1o0s8d2gupy";
$pwd = "Xd0MHrMMM8C2YqbvhNP2";
$host = "bx4tzgrjfpptbqjg7uyr-mysql.services.clever-cloud.com";
$port = 3306;
$database = "bx4tzgrjfpptbqjg7uyr";
$conn = mysqli_connect($host, $u, $pwd, $database);
if ($conn == false) {
    echo "Connection error: " . $conn->error;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password'])) {
        $name = $_POST["name"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $hpassword = password_hash($password,PASSWORD_DEFAULT);

        $checkQuery = "SELECT * FROM `User` WHERE username = ?";
        $checkStmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($checkStmt, 's', $username);
        mysqli_stmt_execute($checkStmt);
        $result = mysqli_stmt_get_result($checkStmt);

        if (mysqli_num_rows($result) > 0) {
            echo 'Username already exists. Please choose a different username.';
        } else {
            $query = "INSERT INTO User(name, username, password) values (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'sss', $name, $username, $hpassword);
    
            if (mysqli_stmt_execute($stmt)) {
                echo "Registered Successfully";
            } else {
                echo "Error: " . $conn->error;
            }
    
            mysqli_stmt_close($stmt); 
        }
        mysqli_stmt_close($checkStmt);
        mysqli_close($conn);
    }
}


?>
