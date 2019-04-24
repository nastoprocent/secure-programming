<?php
 ob_start();
 session_start();

    include 'Header.php';
    include '../Database/Dbconnect.php';
 
//start of session time out
    if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) { //have we expired?
        //redirect to logout
        header('Location: ../Logout-from-the-site');
    } else{ 
        $_SESSION['last_activity'] = time(); //this was the moment of last activity.
    }
        $_SESSION['logged_in'] = true; //set you've logged in
        $_SESSION['last_activity'] = time(); //your last activity was now, having logged in.
        $_SESSION['expire_time'] = 10*60; //expire time in seconds: three hours (you must change this)
//end of session time out
 
 if( isset($_POST['btn-login']) ) { 
  
  // prevent sql injections/ clear user invalid inputs
  $email = trim($_POST['userEmail']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['userPass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  // prevent sql injections / clear user invalid inputs

  
  
  if(empty($email)){
   $error = true;
   $emailError = "Please enter your email address.";
  } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  }
  
  if(empty($pass)){
   $error = true;
   $passError = "Please enter your password.";
  }
  
   // password encrypt using SHA256();
		$password = hash('sha256', $pass);
  
  $sql = "SELECT userId, userName, userPass, userLevel FROM users WHERE userEmail='$email' and userPass='$password'";
  
  $result = mysql_query($sql);
  if(!$result) {
   $errMSG = "Incorrect Credentials, Try again...";
  }
  else {
   if 
    (mysql_num_rows($result) == 0){
     $errMSG = "Wrong username or password";
    }
    else{
     $_SESSION['signed_in'] = true;
     header('Location: /NCI-Jobs');
     
     while($row = mysql_fetch_assoc($result)){
       $_SESSION['userId']    = $row['userId'];
       $_SESSION['userEmail']  = $row['userEmail'];
       $_SESSION['userName']  = $row['userName'];
       $_SESSION['userLevel'] = $row['userLevel'];
     }
     
    }
               
   }
  }
 
?>
<!DOCTYPE html>
<html>
 <head> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <title>Jobs Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
    <link rel="stylesheet" href="style.css" type="text/css" />
  </head>
<body>

<div class="container">

 <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
     <div class="col-md-12">
        
         <div class="form-group">
             <h2 class="">Sign In.</h2>
            </div>
        
         <div class="form-group">
             <hr />
            </div>
            
            <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="email" name="userEmail" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="userPass" class="form-control" placeholder="Your Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
             <div class="form-group col-md-4 ">
             <button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group" >
             <b><a href="Register-into-the-site" style="margin-left:10%;">Sign Up Here...</a></b>
            </div>
        
        </div>
       
   
    </form>
    </div> 

</div>

</body>
</html>
<?php ob_end_flush(); ?>