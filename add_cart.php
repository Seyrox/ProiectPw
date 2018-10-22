<?php
      require_once 'core/init.php';
      include 'includes/head.php';
      include 'includes/nav.php';
      include 'includes/slideshow.php';
      $sql=NULL;
      $sql="SELECT * FROM products where promotion=1 AND stock > 0 LIMIT 8";
      $promotion=$db->query($sql);

?>

    <?php include 'includes/footer.php' ?>
