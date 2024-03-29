
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-type" content="text/html;charset=ENCODING">
<?php
  session_start();
  $id = session_id();
  $user='benny';
  $pass='password';
  $db = 'network_security_db';
  $count_single = 0;
  $login = false;
  $login_fail=false;


  require_once 'vendor/autoload.php';	  
  $config = HTMLPurifier_Config::createDefault();
  $purifier = new HTMLPurifier($config);
  //XSS defense 

  include("getClient.php");
  try {
    $dbh = new PDO('mysql:host=localhost;dbname=network_security_db', $user, $pass);
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    print(phpinfo());
    die();
  }
  if (isset($_COOKIE['counter_v2'])) {
    $count_single = $_COOKIE['counter_v2'] + 1;
  }
  if (!isset($_SESSION['entered'])) {
    $count_single += 1;
    $_SESSION['entered'] = true;
    $_query= $dbh->prepare("INSERT INTO connections (id, os, browser) VALUES (?,?,?)");
    $_query->execute([$id,$user_os,$user_browser]);
    setcookie('counter_v2', $count_single, time() + 24*60*60);
  }
  if (isset($_SESSION['id'])){
    $guid = $_SESSION['id'];
    $id = $guid;
    // $guid = '44564ea34a2b56855c72e55ed3286bf0';//
    $_query = $dbh->prepare("SELECT account FROM accounts WHERE guid = :guid ");
    $_query->execute(array(':guid'=> $guid));
    foreach($_query->fetchAll() as $row){
      $name = $row[0];
      if($row){
        $login = true;
      }
    }
  }
  else{
    $_SESSION['id'] = $id;
    // setcookie('session_id', $id, time() + 6*60*60);
  }
  


?>

<html>
<head>
  <title>Benny</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body class="bg-light">
  
  <div class="row bg-dark text-light fix-top">
    <div class="col-sm-9 text-center">
      <br>
      <h3>匿名留言區
      <?php
      if($login){echo " (Admin Mode)";}
      ?></h3>
      <br>  
    </div>
    <div class="col-sm-3 text-light text-center">
      <br>
      <?php
      if($login){
        echo "<form action=\"logout.php\" method=\"post\">        
                <button class=\"btn btn-light\">Sign out</button>
              </form>";
      }else{
        echo "<button class=\"btn btn-light\" data-toggle=\"modal\" data-target=\"#login_modal\">Sign in</button>";
              }
      if($login_fail){
        echo "<h6>wrong login information</h6>";
      }else{echo "<br>";}
      ?>
    </div>
  </div>
  <div class="row">
    
    <div class="col-sm-4 text-center">
      <br>
      <img src="/img/profile.jpg" class="rounded-circle border border-info" height="250"/>
      <!-- <img src="imageView.php?image_id=<?php echo $row["imageId"]; ?>"/> -->
      <?php
      if($login==true){  
        echo "
        <form action=\"img_upload.php\" method=\"post\" class=\"form-horizontal\" enctype=\"multipart/form-data\">
          <div class=\"form-group \">
                <div class=\"custom-file col-sm-4\">
                  <input type=\"file\" class=\"custom-file-input\" name=\"profile\" id=\"validatedCustomFile\" required>
                  <label class=\"custom-file-label text-left\" for=\"validatedCustomFile\">Choose file...</label>
                </div>
                <input type=\"submit\" class=\"btn btn-secondary\" value=\"Update Profile\" name=\"submit\">
              
          </div>
        </form>
        ";}
    ?>
      <div class="row">
      <div class="col-sm-2"></div>
      <div class="col-sm-8 text-center">
        <br>  
        <h3>Benny</h3>
        <p>這裡是陳邦元架設的匿名留言板，歡迎留言聊天，<br>也麻煩各位XSS大師手下留情。</p>
      </div>
      <div class="col-sm-2"></div>
    </div>
    </div>
    <div class="col-sm-6">

    <?php    
      foreach($dbh->query('SELECT * from messages') as $row) {
        if($row[type]!='d'){
          echo "<br>
                <div class=\"text-right\"><i>$row[time_stamp]</i></div>
                <div class=\"media border p-3\"><div class=\"media-top\"><a>";
          if($row['type']=='a'){
            echo "
                  <img src=\"/img/woman.png\" alt=admin class=\"align-self-start mr-3 mt-3 rounded-circle\" style=\"width:60px;\">
                  ";
          }else{
          echo "
                  <img src=\"/img/head.png\" alt=slave class=\"align-self-start mr-3 mt-3 rounded-circle\" style=\"width:60px;\">
                  ";
          }echo "
                  </a>
                  </div>
                  <div class=\"media-body\">
                    <h4 class=\"media-heading\" >
                    ";
          echo $purifier->purify($row[name]);
          // echo $row[name];
          echo "
                  </h4><div class=\"row\">
                  <div class=\"col-sm-10\">
                  <p style=\"word-break:break-all; word-wrap:break-all;\">
          ";
          echo $purifier->purify($row[content]);
          // echo $row[content];
          echo "
          </p></div>";
          if($id==$row[id] || $login==true)
          {
            echo "
            <div class=\"col-sm-2 text-center\">
                <form action=\"msg-del.php\" method=\"post\">
                  <input type=\"hidden\" name=\"msg_id\" value=\"$row[msg_id]\">
                  <input type=\"submit\" name=\"submit\" class=\"btn btn-danger\" value=\"Delete\">
                </form>     
            </div>
                  ";
          }
          echo "</div>
          </div>
          </div>
          ";
        }
  }
  ?>
        <br>
        <div class="row">
          <div class="col"><hr></div>
          <h6 class="col-auto">Leave Some Messages</h6>
          <div class="col"><hr></div>
        </div>
      <form action="msg-add.php" method="post">
        <div class="form-group">
          <?php
          //bug here id identify
          if($login){
            echo "<label for=\"usr\">Name:</label>
                  <h4>Admin</h4>
                  <input type=\"hidden\" value=\"Admin\" name=\"usr\">
                  <input type=\"hidden\" value=\"a\" name=\"type\">";
          }else{
            echo "<label for=\"usr\">Name:</label>
                  <input type=\"hidden\" value=\"u\" name=\"type\">
                  <input type=\"text\" class=\"form-control\" placeholder=\"Anonymous\" value=\"Anonymous\" name=\"usr\">";
          }
          ?>
        </div>
        <div class="form-group">
          <label for="msg">Comment:</label>
          <textarea name="msg" rows="5" class="form-control" required></textarea>
          <br>
          <input type="submit" name="submit" value="Submit" class="btn btn-primary pull-right">
        </div>
      </form>
    </div>
    <div class="col-sm-2 text-left">
      <br>
      <?php
      $res = $dbh->query('SELECT COUNT(*) FROM connections');
      $num_rows = $res->fetchColumn();
      echo "Your Visits in 24 Hours : <strong>{$count_single}</strong></br>";
      echo "Total Visits : <strong>{$num_rows}</strong></br>";
      // echo "<br>";
      // foreach ($_SESSION as $key=>$val) {
      //   echo "Online Users:{$val}<br>";
      // }
      $dbh = null;
      ?>
    </div>
  </div>


  <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title" id="myModalLabel">Sign in</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <div class="modal-body">
                  <form action="admin_login.php" method="post">
                    <div class="form-group">
                      <label for="usr">Account:</label>
                      <input type="text" class="form-control" name='usr' required>
                    </div>
                    <div class="form-group">
                      <label for="pwd">Password:</label>
                      <input type="password" class="form-control" name='pwd' required>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal -->
      </div>
</body>
</html>
