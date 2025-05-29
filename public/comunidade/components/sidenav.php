<?php
// Sidenav extraído de comuDash.php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="index.html" class="app-brand-link">
      <span class="app-brand-logo demo">
        <!-- Logo SVG aqui -->
      </span>
      <span class="app-brand-text demo menu-text fw-bolder ms-2">TechSolution</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>
  <div class="menu-inner-shadow"></div>
  <ul class="menu-inner py-1">
    <li class="menu-item <?php echo ($currentPage === 'comuDash.php') ? 'active' : ''; ?>">
      <a href="comuDash.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div>Início</div>
      </a>
    </li>
    <li class="menu-item <?php echo ($currentPage === 'comuCriaProj.php') ? 'active' : ''; ?>">
      <a href="comuCriaProj.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-plus-circle"></i>
        <div>Criar Projeto</div>
      </a>
    </li>
    <li class="menu-item <?php echo ($currentPage === 'meus_projetos.php') ? 'active' : ''; ?>">
      <a href="meus_projetos.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-briefcase"></i>
        <div>Meus Projetos</div>
      </a>
    </li>
  </ul>
</aside> 