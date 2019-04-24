<!--/*-->
<!-- * Logout.php-->
<!-- *-->
<!-- * Date e.g. 11th May 2017-->
<!-- *-->
<!-- * @author Andre MacNamara X14380181-->
<!-- *-->
<!-- */ -->

<?php
 session_start();
 session_destroy();
 include '../Database/Dbconnect.php';

 header("Location: ../NCI-Jobs");
 exit();

 
 ?>