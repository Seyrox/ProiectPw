<?php
      require_once 'core/init.php';
      include 'includes/head.php';
      include 'includes/nav.php';
      $sql="SELECT * FROM contact ORDER BY id";
      $temp=$db->query($sql);
      $result=mysqli_fetch_array($temp);
?>

<?php
if ($_POST)
{
  $errors=array();

  if ( (empty($_POST['email']) ) && (empty($_POST['textarea']) ) )
  {
    $errors[]="You must provide an email and a message first.";
  }

  if ( (empty($_POST['email']) ) && (!empty($_POST['textarea']) ) )
  {
    $errors[]="You must also provide an email.";
  }

  if ( (!empty($_POST['email']) ) && (empty($_POST['textarea']) ) )
  {
    $errors[]="You must also provide a message.";
  }

  if (!empty($_POST['textarea']) )
  {
    if (strlen($_POST['textarea']) > 254)
      $errors[]="Your message is too long";
  }

  if (!empty($errors))
  {
    echo display_errors($errors);
  }
  else
  {
      $email=$_POST['email'];
      $text=$_POST['textarea'];
      $sql="INSERT INTO contact (email, comment) VALUES ('$email', '$text') ";

      $db->query($sql);
      header('Location: first.php');
  }
}

?>

  <div class="map">
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2783.871177930763!2d21.222948115855196!3d45.753728479105334!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47455d82fd425403%3A0xebeab37fb452ca7a!2sRectorat+Polytechnic+University+of+Timisoara!5e0!3m2!1sen!2sro!4v1508239174979" width="25%" height="350" frameborder="0" style="border:0"></iframe>
</div>
  <div class="datecontact">
    <div class="contactleft">
  		<h1 class="txt">Contact</h1>
  			<p class="txt">SC U.S.PRAZ SRL<br> CIF: RO********<br> Reg.com.: **/***/2017</p>
  			<p class="txt">str. Brazda lui Nova Nr. 2  <br>20078, Craiova, Romania</p>
  			<p class="txt">IBAN:<br>RO**********************<br>Banca ING</p>
        <p class="txt">Tel: 0722114455</p><br>
        <p class="txt">Program: L-V: 10:00-21</p>
  	</div>
  <form method="POST">
  	<div class="contactright">
  		<h2>Lasa-ne un mesaj</h2>
  		<p>E-mail:<br><input type="email" name="email" style="width: 200px; height: 20px;"></p>
  		<p>Comment<br><textarea name="textarea" placeholder="write your message here" rows="10" style="width: 400px; height: 142px;"></textarea></p>
  		<input class="btn btn-success" type="submit" name="submit" value="Trimite mesaj">
  	</div>
  </form>
	</div>


<?php include 'includes/footer.php' ?>
