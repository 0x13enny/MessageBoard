<?php
  session_start();
  $count = 0;
  if (isset($_COOKIE['counter_v2'])) {
    $count = $_COOKIE['counter_v2'];
  }
  if (!isset($_SESSION['entered'])) {
    $count += 1;
    $_SESSION['entered'] = true;
    setcookie('counter_v2', $count, time() + 30*24*60*60);
  }
?>

<html>

<body>
  <h1>Simple Count v2 (bennychen)</h1>
  <?php
      echo "Welcome!</br>You have entered this site {$count} time(s)!</br>";
      
      echo "<br>";
      foreach ($_SESSION as $key=>$val) {
        echo "{$key} is {$val}<br>";
      }
    ?>
</body>

</html>