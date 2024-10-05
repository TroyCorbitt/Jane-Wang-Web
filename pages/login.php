<?php
$page_title = "Log In";
?>

<!DOCTYPE html>
<html lang="en">

<?php include "includes/meta.php" ?>

<body>

  <?php include "includes/header.php" ?>
  <?php if (!is_user_logged_in()) { ?>
    <h1>Admin Log In</h1>

  <?php echo login_form('/adminview', $session_messages);
  }
  if (is_user_logged_in()) { ?>
    <p>Welcome <strong> You are logged in! </strong></p>
  <?php } ?>


</body>

</html>
