<?php 
  //The main template for displaying pages.
?>

<?php get_header(); ?>

<div id="content">

  <?php while ( have_posts() ) : the_post(); ?>
    <div class="page-title"><?php the_title(); ?></div>
    <?php the_content(); ?>
  <?php endwhile; ?>
  
</div>

<?php get_footer(); ?>