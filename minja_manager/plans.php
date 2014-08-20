<?

require_once('config.php');

if ($_REQUEST['action'] == "new") {
  // Add new plan
  $q = $db->prepare("INSERT INTO plans (name, description, monthly_cost) values (?,?,?)");
  $q->bind_param("ssi", $_REQUEST['name'], $_REQUEST['description'], $_REQUEST['monthly_cost']);
  $q->execute();
  
  // Return new body content
  echo json_encode(array("success" => true, "body" => showPlanManager()));
}

else if ($_REQUEST['action'] == "edit") {
  // Edit existing plan
  $q = $db->prepare("UPDATE plans SET name=?, description=?, monthly_cost=? WHERE id=?");
  $q->bind_param("ssii", $_REQUEST['name'], $_REQUEST['description'], $_REQUEST['monthly_cost'], $_REQUEST['plan_id']);
  $q->execute();
  
  // Return new body content
  echo json_encode(array("success" => true, "body" => showPlanManager()));
}

else if ($_REQUEST['action'] == "delete") {
  // Delete plan
  $q = $db->prepare("DELETE FROM plans WHERE id=?");
  $q->bind_param("i", $_REQUEST['plan_id']);
  $q->execute();
  
  // Return new body content
  echo json_encode(array("success" => true, "body" => showPlanManager()));
}

else {
  showHeader();
  echo showPlanManager();
  showFooter();
}

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
    <script type="text/javascript" src="js/plans.js"></script>
  </body>
</html>
<?
}

function showPlanManager() {
  global $db;

  $body = '<form id="new">
              <input type="hidden" name="action" value="new" />
              <h1>Add new plan:</h1>
              <p>Name:<br /><input type="text" name="name" /></p>
              <p>Description:<br /><textarea name="description"></textarea></p>
              <p>Monthly Cost:<br /><input type="text" name="monthly_cost" /></p>
              <p><button type="submit">Save</button><button type="reset">Cancel</button></p>
            </form>';
      
  $body .= '<form id="edit">
              <input type="hidden" name="action" value="edit" />
              <input type="hidden" name="plan_id" />
              <h1>Edit plan:</h1>
              <p>Name:<br /><input type="text" name="name" /></p>
              <p>Description:<br /><textarea name="description"></textarea></p>
              <p>Monthly Cost:<br /><input type="text" name="monthly_cost" /></p>
              <p><button type="submit">Save</button><button type="reset">Cancel</button></p>
            </form>';
  
  $body .= '<form id="delete">
              <input type="hidden" name="action" value="delete" />
              <input type="hidden" name="plan_id" />
              <p>Are you sure want to delete this plan?</p>
              <ul><li></li></ul>
              <p><button type="submit">Delete</button><button type="reset">Cancel</button></p>
            </form>';

  $body .= '<div class="left">
              <h1>Plans</h1>
            </div>
            <div class="right">
              <a class="add_new fancybox" href="#new">+</a>
            </div>
            <div class="table">
              <div class="row headers">
                <div class="cell">Name</div>
                <div class="cell">Description</div>
                <div class="cell">Monthly Cost</div>
                <div class="cell"></div>
              </div>';

  $q = "SELECT * FROM plans ORDER BY id";
  $r = $db->query($q);
  
  while ($plan = $r->fetch_assoc()) {
    $body .= '<div class="row plan" data-plan-id="' . $plan['id'] . '">
                <div class="cell name">' . $plan['name'] . '</div>
                <div class="cell description">' . $plan['description'] . '</div>
                <div class="cell monthly_cost">' . $plan['monthly_cost'] . '</div>
                <div class="cell"><small><span class="edit fancybox" href="#edit">Edit</span></small> <small><span class="delete fancybox" href="#delete">Delete</span></small></div>
              </div>';
  }
  return $body;
}


?>
