<?php
/**
 * The Header for our theme.
 */
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width">
  <title><?php wp_title( '|', true, 'right' ); ?></title>
</head>

<html>
  <head>
    <link href="//fonts.googleapis.com/css?family=Gudea:400,700,400italic" rel="stylesheet" type="text/css">
    <?php wp_head(); ?>
  </head>
  <body>
    <header>
      <div class="logo">nourish<span class="green"><i>men<img class="tree_icon" src="wp-content/themes/nourishmental/images/tree.png" />al</i></span></div>
      <div class="navigation">
        <ul>
          <li>home</li>
          <li>services</li>
          <li>people</li>
          <li>contact</li>
        </ul>
      </div>
    </header>
