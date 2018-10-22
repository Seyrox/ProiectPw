<?php
      require_once 'core/init.php';
      include 'includes/head.php';
      include 'includes/nav.php';
      include 'includes/slideshow.php';

      if (isset($_GET['cat']) )
      {
        $cat_id=$_GET['cat'];
      }
      else
      {
        $cat_id='';
      }

      $category=get_category($cat_id);

      $test="SELECT * FROM products where categories=$cat_id";
      $result=$db->query($test);

      $number_of_results = mysqli_num_rows($result);

      $results_per_page = 8;
      $number_of_pages = ceil($number_of_results/$results_per_page);


      if (!isset($_GET['page'])) {
    	  $page = 1;
    	} else {
    	  $page = $_GET['page'];
    	}


    	$this_page_first_result = ($page-1)*$results_per_page;

      $sql="SELECT * FROM products where categories=$cat_id LIMIT ". $this_page_first_result . ',' . $results_per_page;
      $productsQ=$db->query($sql);



?>
    <div class="col-md-8">
      <div class="row">
        <h2 class = "text-center"><?=$category['parent']. '-' . $category['child'];?></h2>
        <?php while($product=mysqli_fetch_array($productsQ)) : ?>
        <div class="col-md-3">
          <center><h4 style="margin-top: 20px;"><?=$product['title'] ?></h4>
          <img src="<?=$product['image']; ?>" alt="<?= $product['title'] ?>" class="img-thumb">
          <p></p>
          <p class="list-price ">Price: <?=(($product['promotion'] == 0)? $product['price'] : $product['list_price']);?>LEI</p>
          <a class="btn btn-info" href="products.php?product=<?php echo $product['title'];?>">Details</a>
        </div>
      <?php endwhile; ?>
      </div>
    </div>

    <?php include 'includes/cart.php' ?>
    <?php include 'includes/test2.php' ?>

      </div>
      <div class="text-center">
      <?php for ($page=1;$page<=$number_of_pages;$page++) {
        echo '<a style="margin-top: 10px" class="btn btn-danger" href="category.php?page='.$page.'&cat='.$cat_id.'">'.$page.'</a>';
      }
      ?>
    </div>

    <?php include 'includes/footer.php' ?>
