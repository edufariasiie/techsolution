<?php
require_once __DIR__ . '/../../functions/auth.php';
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /public/auth/login.php');
    exit;
}
require_once __DIR__ . '/../../functions/comuFunctions/criarProj.php';

// Inicializa variáveis para mensagens
$sucesso = false;
$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nomeProjeto'] ?? '';
    $descricao = $_POST['descricaoProjeto'] ?? '';
    $data_limite = $_POST['tempoLimite'] ?? '';
    $tipo_incentivo = $_POST['tipoIncentivo'] ?? '';
    $valor_financeiro = $_POST['valorFinanceiro'] ?? null;
    $descricao_permuta = $_POST['descricaoPermuta'] ?? null;
    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

    $resultado = criarProjeto($nome, $descricao, $data_limite, $tipo_incentivo, $valor_financeiro, $descricao_permuta, $user_id);
    if ($resultado === true) {
        $sucesso = true;
    } else {
        $erros = $resultado;
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
  lang="en"
  class="light-style layout-menu-fixed"
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

    <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
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

    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        <?php include_once __DIR__ . '/components/sidenav.php'; ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          <?php include_once __DIR__ . '/components/navbar.php'; ?>
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row justify-content-center">
                <div class="col-lg-8">
                  <div class="card mb-4">
                    <h5 class="card-header">Cadastrar Novo Projeto</h5>
                    <div class="card-body">
                      <?php if ($sucesso): ?>
                        <div class="alert alert-success">Projeto cadastrado com sucesso!</div>
                      <?php elseif (!empty($erros)): ?>
                        <div class="alert alert-danger">
                          <?php foreach ($erros as $erro): ?>
                            <div><?php echo htmlspecialchars($erro); ?></div>
                          <?php endforeach; ?>
                        </div>
                      <?php endif; ?>
                      <form id="formCadastroProjeto" method="post" action="">
                        <div class="mb-3">
                          <label for="nomeProjeto" class="form-label">Nome do Projeto</label>
                          <input type="text" class="form-control" id="nomeProjeto" name="nomeProjeto" placeholder="Digite o nome do projeto" required />
                        </div>
                        <div class="mb-3">
                          <label for="descricaoProjeto" class="form-label">Descrição Básica</label>
                          <textarea class="form-control" id="descricaoProjeto" name="descricaoProjeto" rows="3" placeholder="Descreva brevemente o projeto" required></textarea>
                        </div>
                        <div class="mb-3">
                          <label for="tempoLimite" class="form-label">Tempo Limite para Entrega</label>
                          <input type="date" class="form-control" id="tempoLimite" name="tempoLimite" required />
                        </div>
                        <div class="mb-3">
                          <label for="tipoIncentivo" class="form-label">Tipo de Incentivo</label>
                          <select class="form-select" id="tipoIncentivo" name="tipoIncentivo" required>
                            <option value="" selected disabled>Selecione o tipo de incentivo</option>
                            <option value="financeiro">Financeiro</option>
                            <option value="permuta">Permuta</option>
                          </select>
                        </div>
                        <div class="mb-3" id="campoFinanceiro" style="display:none;">
                          <label for="valorFinanceiro" class="form-label">Valor do Incentivo (R$)</label>
                          <input type="number" min="0" step="0.01" class="form-control" id="valorFinanceiro" name="valorFinanceiro" placeholder="Ex: 100.00" />
                        </div>
                        <div class="mb-3" id="campoPermuta" style="display:none;">
                          <label for="descricaoPermuta" class="form-label">Descreva a Permuta</label>
                          <input type="text" class="form-control" id="descricaoPermuta" name="descricaoPermuta" placeholder="Ex: Troca por serviço, produto, etc." />
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar Projeto</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  © 2025, feito com ❤️ por <a href="https://www.techsolution.com.br" target="_blank" class="footer-link fw-bolder">TechSolution</a>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <div class="buy-now">
      <a
        href="#"
        target="_blank"
        class="btn btn-danger btn-buy-now"
        >Quero ser para Pro</a>
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
      // Exibe o campo correto de incentivo
      document.addEventListener('DOMContentLoaded', function() {
        var tipoIncentivo = document.getElementById('tipoIncentivo');
        var campoFinanceiro = document.getElementById('campoFinanceiro');
        var campoPermuta = document.getElementById('campoPermuta');
        tipoIncentivo.addEventListener('change', function() {
          if (this.value === 'financeiro') {
            campoFinanceiro.style.display = 'block';
            campoPermuta.style.display = 'none';
          } else if (this.value === 'permuta') {
            campoFinanceiro.style.display = 'none';
            campoPermuta.style.display = 'block';
          } else {
            campoFinanceiro.style.display = 'none';
            campoPermuta.style.display = 'none';
          }
        });
      });
    </script>
  </body>
</html>
