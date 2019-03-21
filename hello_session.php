<?php
  session_start();
  $key = 'greeting';
  $value = 'Hello World';
  $_SESSION[$key] = $value;
?>

<html>

<body>
  <h1>Session Test (bennychen)</h1>
  <?php
    echo "Message from session: {$_SESSION['greeting']}<br>";

    echo "<br>";
    foreach ($_SESSION as $key=>$val) {
      echo "{$key} is {$val}<br>";
    }
  ?>
</body>

</html>