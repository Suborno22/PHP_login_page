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

?>