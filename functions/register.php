<?php

// Function to register a new user
function registerUser($username, $email, $password, $role, $business_name = null, $business_type = null, $confirm_password = null) {
    global $link; // Assume $link is the database connection
    $username_err = $email_err = $password_err = $confirm_password_err = $role_err = $business_name_err = $business_type_err = "";

    // Validação do nome
    if(empty(trim($username))){
        $username_err = "Por favor, informe o nome.";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($username);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Este nome já está em uso.";
                }
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Validação do email
    if(empty(trim($email))){
        $email_err = "Por favor, informe o email.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Formato de email inválido.";
    } else {
        $sql = "SELECT id FROM users WHERE email = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = trim($email);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "Este email já está em uso.";
                }
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Validação da senha
    if(empty(trim($password))){
        $password_err = "Por favor, informe a senha.";
    } elseif(strlen(trim($password)) < 6){
        $password_err = "A senha deve ter pelo menos 6 caracteres.";
    }

    // Validação de confirmação de senha
    if($confirm_password !== null) {
        if(empty(trim($confirm_password))) {
            $confirm_password_err = "Por favor, confirme a senha.";
        } elseif($password !== $confirm_password) {
            $confirm_password_err = "As senhas não coincidem.";
        }
    }

    // Validação do tipo de usuário
    if(empty($role)) {
        $role_err = "Por favor, escolha o tipo de usuário.";
    } elseif($role !== "membro_comunidade") {
        $role_err = "Tipo de usuário inválido.";
    }

    // Validação dos campos extras para membro da comunidade
    if($role === 'membro_comunidade') {
        if(empty(trim($business_name))) {
            $business_name_err = 'Por favor, informe o nome do negócio.';
        }
        if(empty($business_type)) {
            $business_type_err = 'Por favor, selecione o tipo de negócio.';
        }
    }

    // Se não houver erros, insere no banco
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($role_err) && empty($business_name_err) && empty($business_type_err)){
        $sql = "INSERT INTO users (username, email, password, role, business_name, business_type) VALUES (?, ?, ?, ?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_email, $param_password, $param_role, $param_business_name, $param_business_type);
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_role = $role;
            $param_business_name = $business_name;
            $param_business_type = $business_type;
            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
                exit;
            } else{
                echo "Algo deu errado. Tente novamente mais tarde.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    return [$username_err, $email_err, $password_err, $confirm_password_err, $role_err, $business_name_err, $business_type_err];
}

?> 