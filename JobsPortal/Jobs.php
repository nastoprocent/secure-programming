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
    
    $sql = "SELECT
                JobId,
                JobSubject
            FROM
                Jobs
            WHERE
                Jobs.JobId = " . mysql_real_escape_string($_GET['id']);
    $subject = $row['JobSubject'];
    $result = mysql_query($sql);
    
    if(!$result) {
        echo 'The job could not be displayed. Please try again later';
    } else {
        if (mysql_num_rows($result) == 0){
            echo 'This job does not exist. It may have expried or been removed.';
        } else {
            while($row = mysql_fetch_assoc($result)) {
                echo '<div class="container">
		    		        <div class="page-header">
		    			        <tr class="text-center">
							        <th><h2>' . $row['JobSubject'].'</h2></th>
						        </tr>
					        </div>
					    <table>';
                                    //fetch the posts from the database
                            $posts_sql = "SELECT
                                            IndividualJobPost.JobPostTopic,
                                            IndividualJobPost.JobPostContent,
                                            IndividualJobPost.JobPostDate,
                                            IndividualJobPost.JobPostBy,
                                            users.userId,
                                            users.userName
                                        FROM
                                            IndividualJobPost
                                        LEFT JOIN
                                            users
                                        ON
                                            IndividualJobPost.JobPostBy = users.UserId
                                        WHERE
                                            IndividualJobPost.JobPostTopic = " . mysql_real_escape_string($_GET['id']);
                                            
                                    
                            $posts_result = mysql_query($posts_sql);
                                    
                            if (!$posts_result)
                                {
                                    echo '<tr><td><p>The posts could not be displayed, please try again later.<p></td></tr>';
                                } else {
                                        
                                         while ($posts_row = mysql_fetch_assoc($posts_result))
                                            {
                                             
                                                echo '
                        						    <tbody>
                        							    <tr>' . 
                        								   '<td class="post">'.'
                        								        <p>' .nl2br($posts_row['JobPostContent']) . '</p>' .
                        								    '</td>
                        							    </tr>';
                        							    
                        							    
                                            }   
                                        }
                                    
                                                echo '</tbody>
                        </table>
                                        
                        <div class="form-group">
                            <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#jobApplicationModal">Apply</button>
                        </div>
                    </div>';

        }
    }
}

?>

<!--Modal Section -->
<<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <?php
        
        $query = "SELECT
                    JobId,
                    JobSubject
                 FROM
                    Jobs
                WHERE
                    Jobs.JobId = " . mysql_real_escape_string($_GET['id']);
        $result = mysql_query($query);
        while($row = mysql_fetch_assoc($result))
        {
    ?>
    <form action="ApplyForJob" method="post">
<div class="modal fade" id="jobApplicationModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Job Title you are applying for: <?php echo $row['JobSubject']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="applicantName" class="form-control-label">Name:</label>
            <input type="text" class="form-control" name="applicantName" id="applicantName">
          </div>
          <div class="form-group">
            <label for="applicantEmail" class="form-control-label">Email:</label>
            <input type="text" class="form-control" name="applicantEmail" id="applicantEmail"> 
          </div>
          <div class="form-group">
            <label for="applicantNumber" class="form-control-label">Phone Number:</label>
            <input type="text" class="form-control" name="applicantNumber" id="applicantNumber">
          </div>
             <!-- http://www.htmlgoodies.com/tutors/forms/article/3479041? -->
            <div class="form-group">
                <label for="applicantCV">File input</label>
                <input type="file" class="form-control-file" id="applicantCV" aria-describedby="fileHelp">
                <small id="fileHelp" class="form-text text-muted">Please attach and CV and/or cover note for consideration in your application.</small>
            </div>
          <div class="form-group">
            <label for="message-text" class="form-control-label">Message:</label>
            <textarea class="form-control" name="message-text" id="message-text" rows="5"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send message</button>
        
      </div>
    </div>
  </div>
</div>

<?php }?>
</body>
</html>