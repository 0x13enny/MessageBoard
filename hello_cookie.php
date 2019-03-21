<?php
  $cookie_name = "greeting";
  $cookie_value = "Hello World";
  setcookie($cookie_name, $cookie_value, time() + 10*60);
?>

<html>

<body>
  <h1>Cookie Test (bennychen)</h1>
  <?php
    if(!isset($_COOKIE[$cookie_name])) {
      echo "Cookie named {$cookie_name} is not set!<br>";
    } else {
      echo "Cookie named {$cookie_name} is set!<br>";
      echo "Value is: {$_COOKIE[$cookie_name]}<br>";
    }

    echo "<br>";
    foreach ($_COOKIE as $key=>$val) {
      echo "{$key} is {$val}<br>";
    }
  ?>
</body>

</html>