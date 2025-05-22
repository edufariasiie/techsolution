<?php

// Function to check if the user is authenticated
function checkAuthentication() {
    // Start the session if it hasn't been started yet
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the user is logged in
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        // If logged in, redirect to dashboard page
        header("location: /public/pages/dashboard.php");
        exit;
    } else {
        // If not logged in, redirect to login page
        header("location: /public/pages/login.php");
        exit;
    }
}

?> 