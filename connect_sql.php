<?php
  $user='benny';
  $pass='password';
  $db = 'network_security_db';

  try {
    $dbh = new PDO('mysql:host=localhost;dbname=network_security_db', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage() . "<br/>";
    die();
}


  ?>