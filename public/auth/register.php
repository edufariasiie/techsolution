<?php

// Include the registration functions
require_once '../../functions/register.php';

// Start the session
session_start();

// Se o usuário já estiver logado, redireciona para o dashboard
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: dashboard.php");
    exit;
}

// Define variables and initialize with empty values
$username = $email = $password = $confirm_password = $role = $business_name = $business_type = "";
$username_err = $email_err = $password_err = $confirm_password_err = $role_err = $business_name_err = $business_type_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    if(empty(trim($_POST["username"]))) {
        $username_err = "Por favor, informe o nome.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate email
    if(empty(trim($_POST["email"]))) {
        $email_err = "Por favor, informe o email.";
    } elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Formato de email inválido.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if(empty(trim($_POST["password"]))) {
        $password_err = "Por favor, informe a senha.";
    } elseif(strlen(trim($_POST["password"])) < 6) {
        $password_err = "A senha deve ter pelo menos 6 caracteres.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Por favor, confirme a senha.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if($password != $confirm_password) {
            $confirm_password_err = "As senhas não coincidem.";
        }
    }

    // Role (dropdown, só tem uma opção)
    if (isset($_POST["role"]) && $_POST["role"] !== "") {
        $role = $_POST["role"];
    } else {
        $role = "";
    }

    if ($role === "") {
        $role_err = "Por favor, escolha o tipo de usuário.";
    } else if ($role !== "membro_comunidade") {
        $role_err = "Tipo de usuário inválido.";
    } else {
        $role_err = "";
    }

    // Se for membro da comunidade, validar campos extras
    if ($role === 'membro_comunidade') {
        if (empty(trim($_POST['business_name'] ?? ''))) {
            $business_name_err = 'Por favor, informe o nome do negócio.';
        } else {
            $business_name = trim($_POST['business_name']);
        }
        if (empty($_POST['business_type'] ?? '')) {
            $business_type_err = 'Por favor, selecione o tipo de negócio.';
        } else {
            $business_type = $_POST['business_type'];
        }
    }

    // Se não houver erros, registra o usuário
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($role_err) && ($role !== 'membro_comunidade' || (empty($business_name_err) && empty($business_type_err)))) {
        list($username_err, $email_err, $password_err, $confirm_password_err, $role_err, $business_name_err, $business_type_err) = registerUser($username, $email, $password, $role, $business_name, $business_type, $confirm_password);
        // Se não houver erro, o registerUser redireciona para login.php
    }
}

?>

<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="pt-br"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Cadastro - TechSolution</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <img src="../assets/img/logo.png" alt="Logo" class="app-brand-logo demo" style="max-width: 100%;">
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2">Crie sua conta 🚀</h4>
              <p class="mb-4">Preencha os dados para se cadastrar.</p>

              <form id="formAuthentication" class="mb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="mb-3">
                  <label for="username" class="form-label">Nome</label>
                  <input
                    type="text"
                    class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                    id="username"
                    name="username"
                    placeholder="Digite seu nome"
                    value="<?php echo htmlspecialchars($username); ?>"
                    autofocus
                  />
                  <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="text"
                    class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                    id="email"
                    name="email"
                    placeholder="Digite seu email"
                    value="<?php echo htmlspecialchars($email); ?>"
                  />
                  <span class="invalid-feedback"><?php echo $email_err; ?></span>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Senha</label>
                  <input
                    type="password"
                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                    id="password"
                    name="password"
                    placeholder="Digite sua senha"
                  />
                  <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="mb-3">
                  <label for="confirm_password" class="form-label">Confirmar Senha</label>
                  <input
                    type="password"
                    class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                    id="confirm_password"
                    name="confirm_password"
                    placeholder="Digite novamente sua senha"
                  />
                  <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="mb-3">
                  <label for="role" class="form-label">Tipo de Usuário</label>
                  <select name="role" id="role" class="form-select <?php echo (!empty($role_err)) ? 'is-invalid' : ''; ?>">
                    <option value="" <?php echo ($role === "") ? 'selected' : ''; ?>>Clique para escolher!</option>
                    <option value="membro_comunidade" <?php echo ($role === "membro_comunidade") ? 'selected' : ''; ?>>Membro da Comunidade</option>
                  </select>
                  <span class="invalid-feedback"><?php echo isset($role_err) ? $role_err : ''; ?></span>
                </div>
                <!-- Campos extras para Membro da Comunidade -->
                <div id="community-fields" style="display: <?php echo ($role === 'membro_comunidade') ? 'block' : 'none'; ?>;">
                  <div class="mb-3">
                    <label for="business_name" class="form-label">Nome do Negócio</label>
                    <input type="text" name="business_name" id="business_name" class="form-control <?php echo (!empty($business_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($business_name); ?>">
                    <span class="invalid-feedback"><?php echo $business_name_err; ?></span>
                  </div>
                  <div class="mb-3">
                    <label for="business_type" class="form-label">Tipo de negócio</label>
                    <select name="business_type" id="business_type" class="form-select <?php echo (!empty($business_type_err)) ? 'is-invalid' : ''; ?>">
                      <option value="" <?php echo ($business_type === "") ? 'selected' : ''; ?>>Selecione o tipo</option>
                      <option value="Ong" <?php echo ($business_type === "Ong") ? 'selected' : ''; ?>>Ong</option>
                      <option value="projeto social" <?php echo ($business_type === "projeto social") ? 'selected' : ''; ?>>Projeto social</option>
                      <option value="MEI" <?php echo ($business_type === "MEI") ? 'selected' : ''; ?>>MEI</option>
                      <option value="pequeno negócio" <?php echo ($business_type === "pequeno negócio") ? 'selected' : ''; ?>>Pequeno negócio</option>
                    </select>
                    <span class="invalid-feedback"><?php echo $business_type_err; ?></span>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Cadastrar</button>
                </div>
              </form>

              <p class="text-center">
                <span>Já tem uma conta?</span>
                <a href="login.php">
                  <span>Faça login</span>
                </a>
              </p>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
    // Exibe/esconde campos extras conforme seleção do tipo de usuário
    document.addEventListener('DOMContentLoaded', function() {
      var roleSelect = document.getElementById('role');
      var communityFields = document.getElementById('community-fields');
      roleSelect.addEventListener('change', function() {
        if (roleSelect.value === 'membro_comunidade') {
          communityFields.style.display = 'block';
        } else {
          communityFields.style.display = 'none';
        }
      });
    });
    </script>
  </body>
</html>
