<?php $style = "styles/logged_in.css"; ?>
<?php $title = "Dashboard"; ?>
<?php require_once('includes/header.php'); ?>

    <div class="wrapper">
      <?php require_once('includes/nav.php'); ?>

      <div class="main_content">
        <div class="header">Blood Analysis App 1.0</div>
        <div class="info">
          <?php
            $link = $_GET['link'];
            
            if ($link == null){ ?>
              <img class="logo" src="styles/logo.png" />
              
            <?php

            } 
            if ($link == 'sample'){
              include 'sample.php';
            } 
            if ($link == 'users' && $_SESSION['user_name'] == $checkRole){
              include 'register.php';
            } 
            if ($link == 'help'){
              include 'help.php';
            } 
            
            ?> 
             
        </div>
      </div>
    </div>

    <?php require_once('includes/footer.php'); ?>

