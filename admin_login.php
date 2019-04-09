<?php
require("index.php");
$url='/index.php';
$K_array = array(
    ':user'=> $_POST[usr],
    ':pass'=> $_POST[pwd]);
try {
    $dbh = new PDO('mysql:host=localhost;dbname=network_security_db', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
  $_query= $dbh->prepare("SELECT userid, MD5(UNIX_TIMESTAMP() + userid + RAND(UNIX_TIMESTAMP()))
  guid FROM accounts WHERE account = :user AND password = password( :pass )");

  if($_query->execute($K_array)){
    $login_fail=true;
    foreach($_query->fetchAll() as $row){

        $_query_update = $dbh->prepare("UPDATE accounts SET guid = '$row[1]' WHERE userid = $row[0]");
        if($_query_update->execute()){
            // $cookieexpiry = (time() + 21600);
            // setcookie("session_id", $row[1], $cookieexpiry);
            $login_fail=false;
            $_SESSION['id'] = $row[1];
        }
        // $row = $_query_update->fetch(PDO::FETCH_ASSOC);
        }
    }
?>
<html>
<head>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>">   
</head>
</html>