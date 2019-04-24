 <?php
//signin
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
    
    if($_SESSION['signed_in'] == false || $_SESSION['userLevel'] != 1)
{
	//the user is not an admin
	echo '<p class="error">You have no rights to be on this page!</p>';
} 
else {
    	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		//the form hasn't been posted yet, display it
		echo '<div class="container">
		        <div id="login-form">
    		        <form method="post" action="">
    		        	<div class="col-md-12">
    		        		<div class="form-group">
    		        			<label for="CatName"><h5>Category Name</h5></label>
    	                    	<input type="text" class="form-control" name="JobCatName" id="CategoryName" placeholder="eg Finance"/><br />
    	                    </div>
    	    			    <div class="form-group">
    		        			<label for="CatDescription"><h5>Category Description</h5></label>
    	                    	<input type="text" class="form-control" name="JobCatDescription" id="CatDescription" placeholder="This is for students with a finance backg"/><br />
    	                    </div>
    	                    <div class="form-group">
    	    			        <input type="submit" class="btn btn-block btn-primary" value="Add category"/>
        			        </div>
        			    </div>
    		        </form>
                </div>
             </div>';
	}
	
	else {
	    //the form has been posted, so save it
		$sql = "INSERT INTO JobCategories(JobCatName, JobCatDescription)
		   VALUES('" . mysql_real_escape_string($_POST['JobCatName']) . "',
				 '" . mysql_real_escape_string($_POST['JobCatDescription']) . "')";
		$result = mysql_query($sql);
		if(!$result)
		{
			//something went wrong, display the error
			echo 'Error' . mysql_error();
		}
		else
		{
			echo '<p class="success">New Job category succesfully added.</p>';
		}
	}
}

?>