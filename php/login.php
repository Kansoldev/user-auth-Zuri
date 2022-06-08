<?php
    session_start();
    
    if (isset($_POST['submit'])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        loginUser($email, $password);
    }

    function loginUser($email, $password) {
        /*
            Finish this function to check if username and password 
            from file match that which is passed from the form
        */

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

            Get all the emails and passwords from the $usersdata array using array_column() which
            combines the respective values from a multidimensional array into a new array
            by specifying the column key or name (Which in my own case is 1 and 2).
            I can then use that new array to check if the email and password gotten from the form 
            exists in the CSV file. 
        */
        if (in_array($email, array_column($usersData, 1))) {
            // The email exists, so get the index location where the email address was found
            $index = array_search($email, array_column($usersData, 1));

            $username = $usersData[$index][0];

            // Ensure that the password entered by the user matches what they registered with
            if ($password === $usersData[$index][2]) {
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
                header("Location: ../dashboard.php");
            } else {
                header("Location: ../forms/login.html");
            }
        } else {
            header("Location: ../forms/login.html");
        }
    }