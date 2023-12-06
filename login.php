<?php
session_start();

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    // Define the allowed users and their corresponding passwords
    $allowedUsers = ['user1', 'user2'];
    $allowedPasswords = ['pass1', 'pass2'];

    // Check if the provided credentials are valid
    if (in_array($uname, $allowedUsers) && in_array($pass, $allowedPasswords)) {
        // Authentication successful
        $_SESSION['user_name'] = $uname;

        // Redirect to the home page
        header("Location: home.php");
        exit();
    } else {
        // Authentication failed
        header("Location: index.php?error=Incorrect User name or password");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
