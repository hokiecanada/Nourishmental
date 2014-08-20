<?

require_once('config.php');

if ($_REQUEST['action'] == "new") {
  // Set request variables to NULL if not provided
  foreach ($_POST as $key=>$value) {
    if ($value == '')
      $_POST[$key] = NULL;
  }
  
  // Add new client
  $q = $db->prepare("INSERT INTO clients (first_name, last_name, email, phone, address1, address2, city, state, zip, country, birthdate, other) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
  $q->bind_param("ssssssssssss",$_POST['first_name'],$_POST['last_name'],$_POST['email'],$_POST['phone'],$_POST['address1'],$_POST['address2'],$_POST['city'],$_POST['state'],$_POST['zip'],$_POST['country'],$_POST['birthdate'],$_POST['other']);  
  $q->execute();
  
  // Enroll client in selected plan
  $clientID = $q->insert_id;
  if ($clientID != 0) {
    $q = $db->prepare("INSERT INTO client_plans (client_id, plan_id, status, start_date) values (?,?,'active',curdate())");
    $q->bind_param("ii", $clientID, $_POST['plan']);
    $q->execute();
    
    // Return new body content
    echo json_encode(array("success" => true, "body" => showClientManager()));
  } else {
    echo json_encode(array("error" => true));
  }
}

else {
  showHeader();
  echo showClientManager();
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
    <script type="text/javascript" src="js/index.js"></script>
  </body>
</html>
<?
}

function showClientManager() {
  global $db;
  
  $q = "SELECT id, name FROM plans ORDER BY id";
  $r = $db->query($q);
  $planOptions = '';
  
  while ($plan = $r->fetch_assoc()) {
    $planOptions .= '<option value="' . $plan['id'] . '">' . $plan['name'] . '</option>';  
  }
  
  $body = '<form id="new">
              <input type="hidden" name="action" value="new" />
              <h1><center>Add New Client</h1></center><br />
              <div class="table">
                <div class="row">
                  <div class="cell" style="width:100px;">First Name:</div>
                  <div class="cell"><input type="text" name="first_name" /></div>
                </div>
                <div class="row">
                  <div class="cell">Last Name:</div>
                  <div class="cell"><input type="text" name="last_name" /></div>
                </div>
                <div class="row">
                  <div class="cell">Email:</div>
                  <div class="cell"><input type="text" name="email" /></div>
                </div>
                <div class="row">
                  <div class="cell">Phone:</div>
                  <div class="cell"><input type="text" name="phone" /></div>
                </div>
                <div class="row">
                  <div class="cell">Address 1:</div>
                  <div class="cell"><input type="text" name="address1" /></div>
                </div>
                <div class="row">
                  <div class="cell">Address 2:</div>
                  <div class="cell"><input type="text" name="address2" /></div>
                </div>
                <div class="row">
                  <div class="cell">City:</div>
                  <div class="cell"><input type="text" name="city" /></div>
                </div>
                <div class="row">
                  <div class="cell">State:</div>
                  <div class="cell"><input type="text" name="state" /></div>
                </div>
                <div class="row">
                  <div class="cell">Zip:</div>
                  <div class="cell"><input type="text" name="zip" /></div>
                </div>
                <div class="row">
                  <div class="cell">Country:</div>
                  <div class="cell"><input type="text" name="country" /></div>
                </div>
                <div class="row">
                  <div class="cell">Birthdate:</div>
                  <div class="cell"><input type="text" name="birthdate" /></div>
                </div>
                <div class="row">
                  <div class="cell">Other:</div>
                  <div class="cell"><input type="text" name="other" /></div>
                </div>
                <div class="row">
                  <div class="cell">Plan:</div>
                  <div class="cell"><select name="plan">' . $planOptions . '</select></div>
                </div>
              </div>
              <p><button type="submit">Save</button><button type="reset">Cancel</button></p>
            </form>';
  
  $body .= '<form id="delete">
              <input type="hidden" name="action" value="delete" />
              <input type="hidden" name="client_id" />
              <p>Are you sure want to delete this client? All associated records (plans, lifestyles, etc.) will be deleted too.</p>
              <ul><li></li></ul>
              <p><button type="submit">Delete</button><button type="reset">Cancel</button></p>
            </form>';

  $body .= '<div class="left">
              <h1>Clients</h1>
            </div>
            <div class="right">
              <a class="add_new fancybox" href="#new">+</a>
            </div>
            <div class="table">
              <div class="row headers">
                <div class="cell"><input type="checkbox" class="select_all"></div>
                <div class="cell">Email</div>
                <div class="cell">Name</div>
                <div class="cell">Plan</div>
                <div class="cell">Status</div>
                <div class="cell">Weeks</div>
              </div>';

  $q = "SELECT c.id, email, concat(first_name, ' ', last_name) as name, p.name as plan, status, datediff(curdate(), start_date) as time
        FROM clients c JOIN client_plans cp ON c.id = cp.client_id
        JOIN plans p ON cp.plan_id = p.id
        ORDER BY p.id, email";
  $r = $db->query($q);

  while ($client = $r->fetch_assoc()) {
    $body .= '<a class="row client" href="client.php?id=' . $client['id'] . '">
                <div class="cell"><input type="checkbox" data-client="' . $client['id'] . '"></div>
                <div class="cell">' . $client['email'] . '</div>
                <div class="cell">' . $client['name'] . '</div>
                <div class="cell">' . $client['plan'] . '</div>
                <div class="cell">' . ucfirst($client['status']) . '</div>
                <div class="cell">' . round($client['time'] / 7) . '</div>
              </a>';
  }
  return $body;
}

?>
