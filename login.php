<?php
      ob_start();
      require_once 'core/init.php';
      include 'includes/head.php';
      include 'includes/nav.php';

      $username=((isset($_POST['username'])) ? $_POST['username']:'');
      $password=((isset($_POST['password'])) ? $_POST['password']:'');
?>


      <div login="login_error">
      <?php
        if($_POST)
        {
          if( (empty($_POST['username']) ) || (empty($_POST['password']) ) )
          {
            $errors[] = 'You must provide a username and a password.';
          }

          $query=$db->query("SELECT * FROM users WHERE username='$username' ");
          $sql=mysqli_fetch_array($query);
          $flag=mysqli_num_rows($query);
          $_SESSION['logged'] = TRUE;

          if ($flag < 1)
          {
            if (!isset($errors))
            {
              $errors[]='Wrong username.';
              $_SESSION['logged'] = FALSE;
            }
          }

          if (!strcmp($password, $sql['password'])==0)
          {
            if (!isset($errors))
            {
              $errors[]='Wrong password.';
              $_SESSION['logged'] = FALSE;
            }
          }


          if (!empty($errors))
          {
            echo display_errors($errors);
            $username='';
            $password='';
            $aux=$_POST['username'];
          }
          else
          {
            if(isset($_POST['submit']))
            {
              if (!isset($_SESSION))
                session_start();
              if (isset($_SESSION))
                $_SESSION['test'] = $username;
                header("Location: first.php");
            }
          }
        }

        ?>
      </div>

      <p class="groove" style="margin-top: 40px">
        <div class="centered"><h2>LOGIN</h2></div>
        <form class="formBox" action="login.php" method="POST">
           <h3>Username</h3>
           <input type="text" name="username" value="<?=$username;?>">
           <h3> Password</h3>
           <input type="Password" name="password" value="<?=$password;?>"><br>
           <input class="btn btn-success" type="submit" name="submit" value="Submit"><br>
           <div class="forgot">
             <a href="forgotpass.php">Forgot Password ?</a>
             <div class="new">
               <h4>You don't have an account ?</h4>
               <a class="btn btn-primary" href="createaccount.php">Create one</a>
             </div>
           </div>
      </form>
    </p>


<?php include 'includes/footer.php' ?>
