<?php
require("index.php");

$url='/index.php';
try {
    $dbh = new PDO('mysql:host=localhost;dbname=network_security_db', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
// $date=date("Y-m-d H:i:s");

try{
    $_query= $dbh->prepare("INSERT INTO messages (name, content, id, type) VALUES (?,?,?,?)");
    $_query->execute([$_POST[usr],$_POST[msg], $id, $_POST[type]]);
    
    $dbh = null;
}catch(PDOException $exception){
    echo "exception: ".$exception->getMessage();
    // return $exception->getMessage(); 
}
?>
<html>
<head>   
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>">   
</head>   
</html>