<?php
      require_once 'core/init.php';
      include 'includes/head.php';
      include 'includes/nav.php';
      include 'includes/slideshow.php';

      $test=$_GET['product'];
      $sql="SELECT * FROM products where title = '$test' ";
      $templink = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

      $promotion=$db->query($sql);
      $product=mysqli_fetch_array($promotion);
      $title=$product['title'];
      $temp='<span class="glyphicon glyphicon-remove-sign"></span>';

      $star='<span class="fa fa-star" style="color: orange"></span>';
      $nostar='<span class="fa fa-star"></span>';
      if (isset($_SESSION['test']) )
        $userreviewer=$_SESSION['test'];

      $product_id = $product['id'];
      
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
      if ($product['stock'] > $shm2['quantity'])
      {
        $sql2="UPDATE cart SET quantity=quantity+1 WHERE items_id=$shm";
        $db->query($sql2);
      }
      else
        $errors[]='Max stock reached for '. $shm2['items'] . '.';
    }
    $paul='products.php?product=' . str_replace(" ", "%20", $product['title']);
    header("Location: $paul");

  }
  ?>

    <div class="col-md-8">
      <div class="row">
        <div class="col-md-3" >
          <div class="card" style="padding-top: 9px; margin-top: 20px;">
            <center><h4><?=$product['title'] ?></h4>
            <img src="<?= $product['image']; ?>" alt="<?= $product['title'] ?>" style="width:100%">
            <p class="pricet">Price: <?=(($product['promotion'] == 1)? $product['list_price'] : $product['price']);?>LEI</p>
            <?php $temp23=$_SERVER['HTTP_REFERER']; ?>
            <a href="<?php echo $templink. '?product='.$product['title'].'&add='.$product['id'];?>" type="button" name="shopit" style="width: 213px;" class="btn btn-lg btn-warning">
              <span class="glyphicon glyphicon-shopping-cart"></span>Add to cart</a>
            </center>
          </div>
        </div>

        <div class="col-md-8">
          <table class="table table-bordered table-condensed" style="background-color:#b3b3c0; width: 100%; margin-top: 20px">
            <tr>
              <th>Title</th>
              <td><?=$product['title'];?></td>
            </tr>

            <tr>
              <th>Brand</th>
              <td><?=$product['brand'];?></td>
            </tr>

            <tr>
              <th>Category</th>
              <td><?=$product['categories'];?></td>
            </tr>

            <tr>
              <th>Price</th>
              <td><?=(($product['promotion'] == 0)? $product['price'] : $product['list_price']);?> LEI</td>
            </tr>

            <tr>
              <th>Stock</th>
              <td><?=(($product['stock'] > 0) ? $product['stock'] : $temp);?></td>
            </tr>


            <tr>
              <th>Description</th>
              <p><td><div class="description-box"><?=$product['description']?></div></td></p>
            </tr>
          </div>
          </table>

      </div>
    </div>

        <?php
        $errors=array();
        if (isset($_SESSION['test']))
        {
          $namereviewer=$_SESSION['test'];
        }
        else
        {
          $namereviewer='anonim';
        }
        if ( ($product['review'] != 0) && ($product['count_reviews'] != 0) )
          $aux=$product['review']/$product['count_reviews'];
        else
          $aux=0;
        for ($i=0; $i < $aux; $i++)
            echo $star;
        for ($i=0; $i < 5-ceil($aux); $i++)
            echo $nostar;

        if ( (isset($_POST['submiting']) ) && (strcmp($namereviewer, 'anonim') !== 0) )
        {
          if (!empty($_POST['rating']) )
          {
            $nrstars=$_POST['rating'];
            $counts=1;
          }
          else
          {
            $nrstars=0;
            $counts=0;
          }

          if ( (isset($_POST['submiting']) ) && (empty($_POST['rating']) ) && (empty($_POST['review']) ) )
            $errors[]='You need to include either comment, either a rating.';

          $product_id=$product['id'];
          $coments=$_POST['review'];

          $sqlcomment="SELECT * FROM comments WHERE product_id='$product_id' AND user='$namereviewer'";
          $temp2=$db->query($sqlcomment);
          $count=mysqli_num_rows($temp2);

          if ($count > 0)
            $errors[]='You already commented on this product.';
          else if ($count == 0)
          {

            if ( (isset($_POST['submiting']) ) && (!empty($_POST['rating']) ) || (!empty($_POST['review']) ) )
            {
              $date = date('Y-m-d h:i:sa');

              $sql2="UPDATE products SET review = review+$nrstars, count_reviews=count_reviews+$counts WHERE title='$title' ";
              $coments=str_replace("'", "''", $_POST['review']);

              $resultc="INSERT INTO comments (product_id, user, comment, rating, datet) VALUES ('$product_id', '$namereviewer', '$coments', '$nrstars', '$date') ";

              $bcde=$db->query($resultc);
              $db->query($sql2);
            }
          }
        }else
          $errors[] = 'You need to be logged in to review a product.';

        if ( (!empty($errors) ) && (isset($_POST['submiting']) ) )
          echo display_errors($errors);

          $number="SELECT * FROM comments WHERE product_id='$product_id'";
          $tmp=$db->query($number);
          while($resultnr=mysqli_fetch_array($tmp) )
          {
            echo "<div class='commnt'><p>";
            echo 'Username: ' . $resultnr['user'] .'<br>';
            echo 'Rating: ';
              for ($i=0; $i < $resultnr['rating']; $i++)
                echo $star;
              for ($i=0; $i < 5-ceil($resultnr['rating']); $i++)
                echo $nostar;
            echo '<br>' . 'Date: ' . $resultnr['datet'];
            echo '<br><p>' . 'Description: ' . $resultnr['comment'].'</p>';
            echo "</p></div>";
          }
        ?>

    <form class="field" method="post" accept-charset="utf-8">
        <fieldset><legend>Review This Product</legend>
          <p>
          <label for="rating">Rating: </label><input type="radio" name="rating" value="5" /> 5 <?=$star?>
          <input type="radio" name="rating" value="4" /> 4 <?=$star?>
          <input type="radio" name="rating" value="3" /> 3 <?=$star?>
          <input type="radio" name="rating" value="2" /> 2 <?=$star?>
          <input type="radio" name="rating" value="1" /> 1 <?=$star?></p>
          <label for="review">Review</label>
          <p><textarea name="review" rows="8" cols="40"></textarea></p>
          <p><input name="submiting" class="btn btn-warning" type="submit" value="Submit Review"></p>
          <input type="hidden" name="product_type" value="actual_product_type" id="product_type">
          <input type="hidden" name="product_id" value="actual_product_id" id="product_id">
        </fieldset>
    </form>
  </div>

      <?php include 'includes/cart.php' ?>
      <?php include 'includes/test2.php' ?>
    </div>


    <?php include 'includes/footer.php' ?>
