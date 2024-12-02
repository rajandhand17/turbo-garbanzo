<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <link rel="stylesheet" href="css/style.css"> <!-- Link the shared CSS -->
</head>
<body>
  <div class="auth-container">
    <h2>Signup</h2>
    <form action="signup_handler.php" method="POST">
      <div class="input-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
      </div>
      <div class="input-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
      </div>
      <button type="submit" class="btn">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Log in</a></p>
  </div>
</body>
</html>
