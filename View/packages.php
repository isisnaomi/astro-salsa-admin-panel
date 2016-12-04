<?php require 'segments/session-validator.php'; ?>
<!doctype html>
<html>
  <head>

    <meta charset='utf-8'>
    <title>Paquetes</title>

    <!-- Stylesheet links -->
    <?php include 'layout/layout-stylesheets-links.php'; ?>
    <link rel='stylesheet' href='assets/stylesheets/packages/layout.css' />

  </head>
  <body>

    <!-- Sidebar -->
    <?php include 'layout/sidebar.php'; ?>

    <!-- Topbar -->
    <?php include 'layout/top-bar.php'; ?>

    <!-- Students view -->
    <div class='students main-container'>
      <iframe id='students-table-frame'
        src='dashboard-packages.php'></iframe>
    </div>

    <!-- Libs -->
    <script src='http://localhost/libs/jquery.min.js'></script>

    <!-- Sidebar script -->
    <script>
      $(function() {
        $('.main-menu')
          .find('li.packages')
          .addClass('active');
      });
    </script>

  </body>
</html>
