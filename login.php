<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        require __DIR__."/conn.php";
    
        // Prepare a query to retrieve user information based on the provided username
        $query = "SELECT * FROM `User` WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
    
            if (password_verify($password, $user['password'])) {
                mysqli_stmt_close($stmt);
                header("Location: index.php");
                exit;
            }else {
                echo '<script>';
                echo '$(document).ready(()=> {';
                echo '    alert("Wrong password");';
                echo '});';
                echo '</script>';
            }
        } else {
            echo "Error: " . $conn->error;
        }
    
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="14">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="form.css">
    <title>Login Page</title>
</head>
<body>
    <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">
        <h1>Login</h1>
        
        <span>Username</span><input type="text" id="username" name="username" placeholder="Username">
        <br>
        <span>Password</span><input type="password" name="password" id="password" placeholder="Password">
        <br>
        <input type="submit" name="submit" id="submit" value="Log in">
    </form>
    <span>Dont have an account? Click to</span><button onclick="GoToPage()">register</button>
    <script>
            function GoToPage(){
            var a = 'index.php';
            window.location.href = a;
    }
    </script>
</body>
</html>
