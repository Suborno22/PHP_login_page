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

            $recaptcha_secret = "6LehVDopAAAAAOBD1HYPqFae03ELKMKXl4QGz9uG";
            $recaptcha_response = $_POST['g-recaptcha-response'];

            $recaptcha_url = "https://www.google.com/recaptcha/api/siteverify";
            $recaptcha_data = [
                'secret' => $recaptcha_secret,
                'response' => $recaptcha_response,
            ];

            $recaptcha_options = [
                'http' => [
                    'method' => 'POST',
                    'content' => http_build_query($recaptcha_data),
                ],
            ];

            $recaptcha_context = stream_context_create($recaptcha_options);
            $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
            $recaptcha_data = json_decode($recaptcha_result);

            if (!$recaptcha_data->success) {
                // reCAPTCHA verification failed
                echo '<script>alert("reCAPTCHA verification failed. Please try again.");</script>';
                exit;
            }

            if (password_verify($password, $user['password'])) {
                mysqli_stmt_close($stmt);
                header("Location: success.html");
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
        <div class="g-recaptcha" data-sitekey="6LehVDopAAAAAJOgZPG_3FMu06VSuHUmifr8H3Lk"></div>
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>
