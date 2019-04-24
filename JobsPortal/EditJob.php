<?php
    ob_start();
    session_start();
    
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
    
    include '../Accounts/Header.php';
    include '../Database/Dbconnect.php';
    
    if ($_SESSION['signed_in'] == false) 
    {
        //the user is not signed in
        echo '<p>Sorry, you have to be <a href="../Log-into-the-site">signed in</a> to create a topic.</p>';
    }
    
    echo '<h3 class="text-center">Edit Your Job</h3>';
    $JobId = (int)$_GET['JobId'];
    
    $query = mysql_query("SELECT * FROM Jobs WHERE JobId = '$JobId'")
    or die(mysql_error());
    

    
    if(mysql_num_rows($query)>=1){
        while($row = mysql_fetch_array($query)){
            echo "";
            
            $JobSubject = $row['JobSubject'];
            $JobCompany = $row['JobCompany'];
            $JobSalary = $row['JobSalary'];
            $JobLocation = $row['JobLocation'];
            $JobDate = $row['JobDate'];
        };
?>

<div class="container">
    <div id="login-form">
        <form action="UpdateJob" method="post">
            <div class="col-md-12">
                <input type="hidden" name="JobId" value="<?=$JobId;?>">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                        <input type="text" name="uJobSubject" class="form-control" value="<?=$JobSubject;?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-briefcase"></span></span>
                        <input type="text" name="uJobCompany" class="form-control" value="<?=$JobCompany;?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-euro"></span></span>
                        <input type="text" name="uJobSalary" class="form-control" value="<?=$JobSalary;?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                        <input type="text" name="uJobLocation" class="form-control" value="<?=$JobLocation;?>"/>
                    </div>
                </div>
                <!--Compnay: <input type="text" name="uJobCompany" value="<?=$JobCompany?>"><br>-->
                <!--Salary: <input type="text" name="uJobSalary" value="<?=$JobSalary?>"><br>-->
                <!--Location: <input type="text" name="uJobLocation" value="<?=$JobLocation?>"><br>-->
                <input type="Submit">
            </div>
        </form>
    </div>
</div>
        
<?php
}else{
    echo 'No entry found. <a href="javascript:history.back()">Go back</a>';
}
?>