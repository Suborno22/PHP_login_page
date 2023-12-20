
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
                echo '<script>';
                echo '$(document).ready(function() {';
                echo '  alert("Successfully Logged in");';
                echo '  setTimeout(function() {';
                echo '    window.location.href = "index.html";';
                echo '  }, 1000);';
                echo '});';
                echo '</script>';
            }else {
                echo '<script>';
                echo '$(document).ready(function() {';
                echo '  setTimeout(function() {';
                echo '    alert("Wrong password");';
                echo '  }, 1000);';
                echo '});';
                echo '</script>';
            }
        } else {
            header("Location: Connection_Error.html");
        }
    
        mysqli_close($conn);
    }
}
?>