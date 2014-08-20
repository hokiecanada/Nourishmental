<?

function showHeader() {
?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="css/minja_manager.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" />
  </head>
  <body>
    <div class="header">
      <div class="logo">nourish<span class="green"><i>men<img class="tree_icon" src="images/tree.png" />al</i></span> - Minja Manager</div>
      <div class="navigation">
        <ul>
          <li><a href="index.php">clients</a></li>
          <li><a href="lifestyles.php">lifestyles</a></li>
          <li><a href="surveys.php">surveys</a></li>
          <li><a href="plans.php">plans</a></li>
        </ul>
      </div>
    </div>
    <div id="main_content" class="container">
<?
}

function showFooter() {
?>
    </div>
    <script src="js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="js/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
  </body>
</html>
<?
}

?>