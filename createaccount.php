<?php
      require_once 'core/init.php';
      include 'includes/head.php';
      include 'includes/nav.php';

      $username='';
      $password='';
      $email='';
?>

<?php

 if (isset($_POST['submit']) )
 {
   if (empty($_POST['username']) )
   {
     $errors[]='You must provide a username.';
   }

   if (empty($_POST['password']) )
   {
     $errors[]='You must provide a password.';
   }

   if (empty($_POST['email']) )
   {
     $errors[]='You must provide an email.';
   }

   if (strlen($_POST['password']) < 4)
      $errors[]='Password is too short.';

   $username=$_POST['username'];
   $sql="SELECT * FROM users WHERE username='$username' ";
   $result=mysqli_fetch_array($db->query($sql) );

   if (!empty($result['username']) )
     $errors[]='That username is already taken.';

   if (!empty($errors))
     echo display_errors($errors);
   else
   {
     $username=$_POST['username'];
     $password=$_POST['password'];
     $email=$_POST['email'];
     $date=date("Y/m/d");

     $sql="INSERT INTO users (username, password, email, join_date, permisions) VALUES ('$username', '$password', '$email', '$date', 'user')";
     $db->query($sql);

     header("Location: login.php");
   }


 }


 ?>

    <p class="groove">
      <div class="centered"><h2>New Account</h2></div>
      <form class="formBox" action="" method="POST">Username
           <p style="font-size:16px; margin-top: 10px"></p>
           <input type="text" name="username">
           <p style="font-size:16px; margin-top: 10px">Password</p>
           <input type="password" name="password">
           <p style="font-size:16px; margin-top: 10px">Mail</p>
           <input type="email" name="email"><br>
           <input type="submit" href="" name="submit" value="Submit">
      </form>
    </p>

<?php include 'includes/footer.php' ?>
