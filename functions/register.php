<?php

// Function to register a new user
function registerUser($username, $email, $password) {
    global $link; // Assume $link is the database connection
    $username_err = $email_err = $password_err = "";

    // Validate username
    if(empty(trim($username))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($username);
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    // Validate email
    if(empty(trim($email))){
        $email_err = "Please enter an email.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
    }

    // Validate password
    if(empty(trim($password))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($password)) < 6){
        $password_err = "Password must have at least 6 characters.";
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($password_err)){
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    return [$username_err, $email_err, $password_err];
}

?> 