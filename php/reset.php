<?php
    session_start();
    
    if (isset($_POST['submit'])) {
        $email = $_POST["email"];
        $newpassword = $_POST["password"];

        resetPassword($email, $newpassword);
    }

    function resetPassword($email, $password){
        $usersData = array();
        $filename = "../storage/users.csv";

        // Open the file for writing
        $handle = fopen($filename, "r");

        while ($info = fgetcsv($handle, 1000)) {
            array_push($usersData, $info);
        }

        /*
            0 - Represents full names
            1 - Represents emails
            2 - Represents passwords 
        */
        if (in_array($email, array_column($usersData, 1))) {
            $index = array_search($email, array_column($usersData, 1));
            $content = file_get_contents($filename);
            $new_content = str_replace($usersData[$index][2], $password, $content);
            file_put_contents($filename, $new_content);

            $_SESSION["username"] = $usersData[$index][0];
            $_SESSION["password"] = $password;

            header("Location: ../dashboard.php?message=password reset successful");
        } else {
            header("refresh:0.2, url=../forms/resetpassword.html");
            echo "<script>alert('user does not exists')</script>";
        }
    }