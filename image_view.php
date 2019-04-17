<?php

try {
    $dbh = new PDO('mysql:host=localhost;dbname=network_security_db', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
// $date=date("Y-m-d H:i:s");
try{if(isset($_GET['image_id'])){
    $_query= $dbh->prepare("SELECT filetype, image FROM output_images WHERE PicNum = ?");
    $_query->execute([$_GET['image_id']]);
    foreach($_query->fetchAll() as $row)
    {
        header("Content-type: " . $row["imageType"]);
        echo $row["imageData"];        
    }}
    $dbh = null;
}catch(PDOException $exception){
    echo "exception: ".$exception->getMessage();
    // return $exception->getMessage(); 
}

?>