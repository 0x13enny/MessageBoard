<?php

require('index.php');

$file = fopen($_FILES["upfile"]["tmp_name"], "rb");
$fileContents = fread($file, filesize($_FILES["upfile"]["tmp_name"])); 
fclose($file);
$fileContents = base64_encode($fileContents);

If($login==true)
{
    $url='/index.php';
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=network_security_db', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    try{
        $_query= $dbh->prepare("INSERT INTO images (filename,filesize,filetype,image) values(?,?,?,?)");
        $_query->execute([
            $_FILES["upfile"]["name"],
            $_FILES["upfile"]["size"],
            $_FILES["upfile"]["type"],
            $fileContents]);
    }catch(PDOException $exception){
        echo "exception: ".$exception->getMessage();
        // return $exception->getMessage(); 
    }
    

}
// else echo "<script>alert(\"you didn't upload any figure\")</script>";
?>
<html>
<head>   
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>">   
</head>   
</html>