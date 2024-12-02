<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

include '../db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Luxury Property Services</title>
  <link rel="stylesheet" href="../css/admin.css">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
  <div class="sidebar">
    <h1 class="logo">LUXURY<br>Property Services</h1>
    <nav>
      <ul>
        <li class="menu-item">
          <i class="fas fa-photo-video"></i>
          <a href="media.php"><span>Media</span></a>
        </li>
        <li class="menu-item">
          <i class="fas fa-file-alt"></i>
          <span>Landing Pages</span>
          <ul class="submenu">
            <li><i class="fas fa-image"></i><a href="banner.php">Banner</a></li>
            <li><i class="fas fa-tachometer-alt"></i><a href="add_banner.php">Add Banner</a></li>
            <li><i class="fas fa-info-circle"></i><a href="">Details</a></li>
          </ul>
        </li>
      </ul>
    </nav>
    <div class="profile">
      <i class="fas fa-user-circle profile-icon"></i>
      <span><?php echo $_SESSION['username']; ?></span>
    </div>
    <div class="logout">
      
    <i class="fa fa-sign-out" aria-hidden="true"></i>
    <a href="../logout.php"><span>Logout</span></a>
    </div>
  </div>
  <div class="main-content">
    <header>
      <input type="text" class="search-bar" placeholder="Search">
      <div class="user-options">
        <i class="fas fa-bell icon"></i>
        <i class="fas fa-info-circle icon"></i>
        <i class="fas fa-user-circle profile-icon"></i>
        <!-- <img src="user-avatar.jpg" alt="User Avatar" class="user-avatar"> -->
      </div>
    </header>
    <div class="content">