<?php
    session_start();

    if (isset($_POST['submit'])) {
        $username = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        registerUser($username, $email, $password);
    }

    function registerUser($username, $email, $password) {
        $filename = "../storage/users.csv";

        // Open the file for writing
        $handle = fopen($filename, "a");

        if (fputcsv($handle, array($username, $email, $password))) {
            header("refresh:0.5, url=../dashboard.php");
            echo "<script>alert(('User Successfully registered'))</script>";
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;
        } else {
            echo "Registration failed";
        }
    }