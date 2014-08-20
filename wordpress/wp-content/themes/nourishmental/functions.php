<?php

function nourishmental_scripts(  ) {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', get_stylesheet_directory_uri() . '/js/jquery-1.11.0.min.js' );
	// For production
	//wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js' );
		
	wp_enqueue_style('common', get_stylesheet_directory_uri() . '/css/common.css');
  
  if (is_front_page()) {
    wp_enqueue_style('front-page', get_stylesheet_directory_uri() . '/css/front-page.css');
  }
  
  if (is_front_page()) {
    wp_enqueue_style('front-page', get_stylesheet_directory_uri() . '/css/front-page.css');
  }
  
  if (is_front_page()) {
    wp_enqueue_script('front-page', get_stylesheet_directory_uri() . '/js/front-page.js', array('jquery'));
  }
}
add_action( 'wp_enqueue_scripts', 'nourishmental_scripts' );
