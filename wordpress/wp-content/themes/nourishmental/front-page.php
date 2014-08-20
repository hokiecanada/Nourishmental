<?php 
  //The template for the home page.
?>

<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
  <div class="underlay">
    <div class="overlay">
      <div class="motto">
        <div class="mind">change your mind</div>
        <div class="body align_right">change your body</div>
        <div class="life align_center">change your life</div>
      </div>
      <div class="cta">
        <button href="#signup_form">Find out how</button>
        <div><img class="arrow" src="wp-content/themes/nourishmental/images/arrow.png" /></div>
      </div>
      
    </div>
    <video controls="none" loop="true" autoplay="true">
      <source src="<?php the_field('video'); ?>" type="video/mp4" />
    </video>
  </div>
  <div class="main_content">
    <?php the_field('content'); ?>
  </div>
<?php endwhile; ?>

<?php get_footer(); ?>