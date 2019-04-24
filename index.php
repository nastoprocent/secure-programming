<?php
    ob_start();
    session_start();
    
    include 'Database/Dbconnect.php';
    include 'Accounts/Header.php';
    
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>NCI Jobs</title> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body style="background:url('/img/application-1883453_1920.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div id="content" style="padding-top: 10%;">
                    <h1 style="color:black;">NCI Jobs</h1>
                    <h3 style="color:black;">Find Jobs Today</h3>
                    <hr style="padding-left:-30%">
                </div><!-- /.content -->
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>