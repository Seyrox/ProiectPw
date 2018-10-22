<?php
      require_once 'core/init.php';
      include 'includes/head.php';
      include 'includes/nav.php';
      require_once 'includes/PHPMailer-master/src/PHPMailer.php';
      require_once 'includes/PHPMailer-master/src/Exception.php';
?>
    <p class="groove">
      <div class="centered"><h2>Forgot Password</h2></div>
      <form class="formBox" action="#" method="POST">
           <p style="font-size:16px; margin-top: 10px">Username</p>
           <input type="text" name="username">
           <p style="font-size:16px; margin-top: 10px">Mail</p>
           <input type="email" name="email"><br>
           <input type="submit" name="forgot_submit" value="Submit">
           <?php
              if (isset($_POST['forgot_submit']) )
              {
                $email=$_POST['email'];
                $username=$_POST['username'];
                $sql="SELECT * FROM users WHERE username='$username' AND email='$email' ";
                $result=mysqli_fetch_array($db->query($sql) );
                $msg="Suck it!";
                if ( (isset($result['email']) ) && (isset($result['username']) ) )
                {
                  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                  try {
                      //Server settings
                      $mail->SMTPDebug = 2;                                 // Enable verbose debug output
                      $mail->isSMTP();                                      // Set mailer to use SMTP
                      $mail->Host = 'smpt.gmail.com';  // Specify main and backup SMTP servers
                      $mail->SMTPAuth = true;                               // Enable SMTP authentication
                      $mail->Username = 'claudiu.take16@gmail.com';                 // SMTP username
                      $mail->Password = 'davideVoicu13';                           // SMTP password
                      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                      $mail->Port = 587;                                    // TCP port to connect to

                      //Recipients
                      $mail->setFrom('no-reply@howcode.org', 'Mailer');
                      //$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
                      $mail->addAddress($result['email']);               // Name is optional

                      //Content
                      $mail->isHTML(true);                                  // Set email format to HTML
                      $mail->Subject = 'Recover password';
                      $mail->Body    = 'TEST';

                      $mail->send();
                      echo 'Message has been sent';
                  } catch (Exception $e) {
                      echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                  }
                }
              }
            ?>
      </form>
    </p>

<?php include 'includes/footer.php' ?>
