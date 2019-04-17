<?php
require("index.php");
$url='/index.php';
try {
    $dbh = new PDO('mysql:host=localhost;dbname=network_security_db', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $_query= $dbh->prepare("select id from messages where msg_id = :id");
    // $_query= $dbh->prepare("update messages set type='d' WHERE msg_id = :id");
    $_query->execute(array(':id' => $_POST[msg_id]));
    $id_confirm = $row[1];
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage() . "<br/>";
    die();
}
// print $id_confirm_1;
if($id==$id_confirm || $login==true){
try{
        // $_query= $dbh->prepare("DELETE FROM messages WHERE msg_id = :id");
        $_query= $dbh->prepare("update messages set type='d' WHERE msg_id = :id");
        $_query->execute(array(':id' => $_POST[msg_id]));
        $dbh = null;
    }catch(PDOException $exception){
        echo "exception: ".$exception->getMessage();
        // return $exception->getMessage();     
    }
}else{
    // print $id;
    $dbh = null;
}
?>
<html>
<head>   
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>">   
</head>   

</html>