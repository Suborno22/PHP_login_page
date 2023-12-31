<?php

    require __DIR__."/conn.php";
    
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
                echo '<script>';
                echo '$(document).ready(function() {';
                echo '  alert("Username already exists. Please choose a different username.");';
                echo '});';
                echo '</script>';
            } else {
                $query = "INSERT INTO User(name, username, password) values (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, 'sss', $name, $username, $hpassword);
            
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    header("Location: login.php");
                    exit;
                } else {
                    echo "Error: " . $conn->error;
                }
            
                mysqli_stmt_close($stmt); 
            }
            mysqli_stmt_close($checkStmt);        
    
        }
    }
    mysqli_close($conn);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="form.css">
    <title>Register Page</title>
</head>
<body>
    <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">
        <h1>Register</h1>

        <span>Name</span><input type="text" id="name" name="name" placeholder="Name">
        <br>
        <span>Username</span><input type="text" id="username" name="username" placeholder="Username">
        <br>
        <span>Password</span><input type="password" name="password" id="password" placeholder="Password">
        <br>
        <input type="submit" name="submit" id="submit" value="Register">
    </form>
    <span>Already have an account? return</span><button onclick="GoToLoginPage()">Log in</button>

    <script>
            function GoToLoginPage(){
            var a = 'login.php';
            window.location.href = a;
    }
    </script>
</body>
</html>
