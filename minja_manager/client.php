<?

require_once('config.php');

if ($_REQUEST['action'] == "edit-details") {
  // Set request variables to NULL if not provided
  foreach ($_POST as $key=>$value) {
    if ($value == '')
      $_POST[$key] = NULL;
  }
  
  // Edit client
  $q = $db->prepare("UPDATE clients (first_name, last_name, email, phone, address1, address2, city, state, zip, country, birthdate, other) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) WHERE id=?");
  $q->bind_param("ssssssssssssi",$_POST['first_name'],$_POST['last_name'],$_POST['email'],$_POST['phone'],$_POST['address1'],$_POST['address2'],$_POST['city'],$_POST['state'],$_POST['zip'],$_POST['country'],$_POST['birthdate'],$_POST['other'],$_POST['id']);  
  $q->execute();
  
  // Return new body content
  echo json_encode(array("success" => true, "body" => showClientProfile()));
}

else {
  showHeader();
  echo showClientProfile();
  showFooter();
}

function showHeader() {
?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="css/minja_manager.css">
    <link rel="stylesheet" type="text/css" href="css/client.css">
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
    <script type="text/javascript" src="js/client.js"></script>
  </body>
</html>
<?
}

function showClientProfile() {
  global $db;
  
  $q = $db->prepare("SELECT first_name, last_name, email, phone, address1, address2, city, state, zip, country, (YEAR(curdate()) - YEAR(birthdate)) as age, other FROM clients WHERE id=?");
  $q->bind_param("i",$_REQUEST['id']);
  $q->execute();
  $q->bind_result($firstName, $lastName, $email, $phone, $address1, $address2, $city, $state, $zip, $country, $age, $other);
  $client = $q->fetch();
  
  $address = $address1 . '<br />';
  $address .= ($address2 && $address2 != '') ? $address2 . '<br />' : '';
  $address .= $city . ', ' . $state . ', ' . $zip . '<br />' . $country;
  
  $body = '<h1>' . $firstName . ' ' . $lastName . '</h1>';
  $body .= '<div><a href="mailto:' . $email . '" target="_blank">' . $email . '</a></div>';
  $body .= '<div>' . $phone . '</div>';
  
  $details =  ' <div id="details">
                <h2>Client Details</h2>
                <div class="table">
                  <div class="row">
                    <div class="cell">Age:</div>
                    <div class="cell">' . $age . '</div>
                  </div>
                  <div class="row">
                    <div class="cell">Address:</div>
                    <div class="cell">' . $address . '</div>
                  </div>
                </div>
                <div><small><span class="edit fancybox" href="#edit">Edit</span></small></div>
              </div>';

  $q->close();
  
  $q = $db->prepare("SELECT date, weight, (girth_neck + girth_shoulder + girth_chest + girth_arm + girth_waist + girth_hips + girth_thigh + girth_calf) as inches, photo_front, photo_side, photo_back, notes FROM client_measurements WHERE client_id=? ORDER BY date DESC");
  $q->bind_param("i",$_REQUEST['id']);
  $q->execute();
  $q->bind_result($date, $weight, $inches, $photoFront, $photoSide, $photoBack, $notes);
  $client = $q->fetch();
  
  $measurements =  '<div id="measurements">
<h2>Measurements</h2>
<p>Latest:</p>
<div class="table">
  <div class="row">
    <div class="cell">Date:</div>
    <div class="cell">' . $date . '</div>
  </div>
  <div class="row">
    <div class="cell">Weight:</div>
    <div class="cell">' . $weight . '</div>
  </div>
  <div class="row">
    <div class="cell">Inches:</div>
    <div class="cell">' . $inches . '</div>
  </div>
</div>
<h2>Previous:</h2>';
                
  while ($client = $q->fetch()) {
    $measurements .= '<div>' . $date . '</div>';
  }
  $measurements .= '</div>';
  
  $forms = '<form id="edit">
              <input type="hidden" name="action" value="edit-details" />
              <h1><center>Edit Client</h1></center><br />
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
  
  $forms .= '<form id="delete">
              <input type="hidden" name="action" value="delete" />
              <input type="hidden" name="client_id" />
              <p>Are you sure want to delete this client? All associated records (plans, lifestyles, etc.) will be deleted too.</p>
              <ul><li></li></ul>
              <p><button type="submit">Delete</button><button type="reset">Cancel</button></p>
            </form>';

  return $body . $details . $measurements . $forms;
}

?>
