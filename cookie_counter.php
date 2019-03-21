<?php
  $count = 1;
  if (isset($_COOKIE['counter'])) {
    $count = $_COOKIE['counter'] + 1;
  }
  setcookie('counter', $count, time() + 30*24*60*60);
?>

<html>

<body>
  <h1>Simple Count (bennychen)</h1>
  <?php
    echo "Welcome!</br>You have entered this site {$count} time(s)!</br>";
    
    // echo "<br>";
    // foreach ($_COOKIE as $key=>$val) {
    //   echo "{$key} is {$val}<br>";
    // }
  ?>
</body>

</html>