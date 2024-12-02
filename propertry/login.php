<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/style.css"> <!-- Link the shared CSS -->
</head>
<body>
  <div class="auth-container">
    <h2>Login</h2>
    <?php
    session_start();
    if (isset($_SESSION['error'])) {
        echo "<p class='error-message'>" . htmlspecialchars($_SESSION['error']) . "</p>";
        unset($_SESSION['error']);
    }
    ?>
    <form action="login_handler.php" method="POST">
      <div class="input-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
      </div>
      <button type="submit" class="btn">Login</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
  </div>
</body>
</html>
