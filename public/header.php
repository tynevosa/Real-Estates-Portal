<?php
require_once('../helpers/constants.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>България Естейтс</title>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: EstateAgency - v4.9.0
  * Template URL: https://bootstrapmade.com/real-estate-agency-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script defer src="assets/js/main.js"></script>
<style>
  .img-box-reset {
    max-height: 310px;
    min-height: 310px;
  }
</style>

<body>
  <?php include_once('search-form.php'); ?>

  <div class="header">
    <!-- ======= Header/Navbar ======= -->
    <nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
      <div class="container">
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span></span>
          <span></span>
          <span></span>
        </button>
        <a class="navbar-brand text-brand" href="/">България <span class="color-b">Естейтс</span></a>

        <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
          <ul class="navbar-nav">

            <li class="nav-item">
              <a class="nav-link" href="/">Начало</a>
            </li>

            <li class="nav-item">
              <a class="nav-link " href="/real-estates.php">Имоти</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="/agents.php">Брокери</a>
            </li>


            <?php if (!isset($_SESSION['loggedin'])) { ?>
              <li class="nav-item">
                <a href="/login.php" class="nav-link">Влез</a>
              </li>
              <li class="nav-item"><a href="/register.php" class="nav-link">Регистрация</a></li>
            <?php } else { ?>
              <?php if ($_SESSION['user_type'] == BROKER_ROLE) { ?>
                <li class="nav-item"><a href="/my-real-estates.php" class="nav-link">Мойте Имоти</a></li>
                <li class="nav-item"><a href="/add-real-estate.php" class="nav-link">Добави Имот</a></li>
              <?php } else { ?>
                <li class="nav-item"><a href="/favorites-real-estates.php" class="nav-link">Любими</a></li>
              <?php } ?>

              <li class="nav-item"><a href="/logout.php" class="nav-link">Изход</a></li>
            <?php } ?>
          </ul>
        </div>

        <button type="button" class="btn btn-b-n navbar-toggle-box navbar-toggle-box-collapse" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01">
          <i class="bi bi-search"></i>
        </button>

      </div>
    </nav><!-- End Header/Navbar -->