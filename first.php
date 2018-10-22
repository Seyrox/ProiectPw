<?php
      require_once 'core/init.php';
      include 'includes/head.php';
      include 'includes/nav.php';
      include 'includes/slideshow.php';
      $sql=NULL;
      $sql="SELECT * FROM products where promotion=1 AND stock > 0 LIMIT 8";
      $promotion=$db->query($sql);
      if (isset($_SESSION['test']) )
        $userreviewer=$_SESSION['test'];
?>

<?php
  $errors=array();
  if (isset($_GET['add']) ){
    if (!isset($_SESSION['test']) )
      $errors[]='You need to be logged in order to buy something.';

    $shm=$_GET['add'];
    $sql11="SELECT * FROM cart WHERE username='$userreviewer' AND items_id = '$shm' ";
    $shm1=$db->query($sql11);
    $shm2=mysqli_fetch_array($shm1);

    if ($shm2 == NULL)
      add_to_cart($shm);
    else
    {
      $sql2="UPDATE cart SET quantity=quantity+1 WHERE items_id=$shm";
      $db->query($sql2);

    }
    header("Location: first.php");
  }

  ?>

    <div class="col-md-8">
      <div class="row">
        <h2 class = "text-center" >Promotions</h2>
        <?php while($product=mysqli_fetch_array($promotion)) : ?>
        <div class="col-md-3">
          <center><h4 class="first"><?= $product['title'] ?></h4>
          <img src="<?=$product['image']; ?>" alt="<?= $product['title'] ?>" class="img-thumbing">
          <p class="list-price text-danger">Old price:<s><?= $product['price']?>LEI</s></p>
          <p class="price">New price:<?= $product['list_price']?>LEI</p>

          <a href="products.php?product=<?php echo $product['title']; ?>" type="button" name="cancer"class="btn btn-sm btn-info">
            Details</a>
          <a href="first.php?add=<?=$product['id'];?>" type="button" name="shopit" class="btn btn-sm btn-warning">
            <span class="glyphicon glyphicon-shopping-cart"></span>Add to cart</a>
        </div>
      <?php endwhile; ?>
      </div>
    </div>
    <?php include 'includes/cart.php' ?>
    <?php include 'includes/test2.php' ?>

    </div>


    <?php include 'includes/footer.php' ?>
