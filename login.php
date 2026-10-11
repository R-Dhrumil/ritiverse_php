<?php
/**
 * RiTiVerse — Admin Login Redirector
 * Automatically forwards /login or /login.php to the Admin Portal (/admin/login.php)
 */
header('Location: admin/login.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="0;url=admin/login.php">
  <title>Redirecting to Admin Portal...</title>
  <script>window.location.href = "admin/login.php";</script>
</head>
<body style="font-family: sans-serif; background: #FAF7EE; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0;">
  <p style="color: #4A5568;">Opening Admin Portal... <a href="admin/login.php" style="color: #F86800; font-weight: bold;">Click here</a>.</p>
</body>
</html>
<?php exit; ?>
