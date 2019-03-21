<?php
require 'database.php';
extract($_POST);
// $username = $_POST['username'];
  echo $_POST['username'];
          $username=mysqli_real_escape_string($con,$_POST['username']);

              $query = "INSERT INTO logininfo VALUES ('','$username')";
              $query_run=mysqli_query($con,$query);
              if(!$query_run)
              {
               echo '<script type="text/javascript"> alert("Error")</script>';
               // header("location:registerpage.php");
               }
              else
               {
                 echo '<script type="text/javascript"> alert("Succesfull")</script>';
                 // header("location:loginpage.php");
                }
 ?>
