<?

require_once('config.php');

if ($_REQUEST['action'] == "new") {
  // Add new lifestyle
  $q = $db->prepare("INSERT INTO lifestyles (title, description, ordering, plan_id) values (?,?,?,?)");
  $q->bind_param("ssii", $_REQUEST['title'], $_REQUEST['description'], $_REQUEST['ordering'], $_REQUEST['plan_id']);
  $q->execute();
  
  // Return new body content
  echo json_encode(array("success" => true, "body" => showLifestyleManager()));
}

else if ($_REQUEST['action'] == "show") {
  showHeader();
  echo showLessonManager($_REQUEST['id']);
  showFooter();
}

else if ($_REQUEST['action'] == "edit") {
  // Edit existing lifestyle
  $q = $db->prepare("UPDATE lifestyles SET title=?, description=?, ordering=? WHERE id=?");
  $q->bind_param("ssii", $_REQUEST['title'], $_REQUEST['description'], $_REQUEST['ordering'], $_REQUEST['lifestyle_id']);
  $q->execute();
  
  // Return new body content
  echo json_encode(array("success" => true, "body" => showLifestyleManager()));
}

else if ($_REQUEST['action'] == "delete") {
  // Delete lessons associated with lifestyle
  $q = $db->prepare("DELETE FROM lessons WHERE lifestyle_id=?");
  $q->bind_param("i", $_REQUEST['lifestyle_id']);
  $q->execute();
  
  // Delete lifestyle
  $q = $db->prepare("DELETE FROM lifestyles WHERE id=?");
  $q->bind_param("i", $_REQUEST['lifestyle_id']);
  $q->execute();
  
  // Return new body content
  echo json_encode(array("success" => true, "body" => showLifestyleManager()));
}

else if ($_REQUEST['action'] == "new-lesson") {
  // Add new lesson
  $q = $db->prepare("INSERT INTO lessons (lifestyle_id, day, subject, body, survey_id) values (?,?,?,?,?)");
  $q->bind_param("iissi", $_REQUEST['lifestyle_id'], $_REQUEST['day'], $_REQUEST['subject'], $_REQUEST['body'], $_REQUEST['survey_id']);
  $q->execute();
  
  // Return new body content
  echo json_encode(array("success" => true, "body" => showLessonManager($_REQUEST['lifestyle_id'])));
}

else if ($_REQUEST['action'] == "edit-lesson") {
  // Edit existing lesson
  $q = $db->prepare("UPDATE lessons SET day=?, subject=?, body=?, survey_id=? WHERE id=?");
  $q->bind_param("issii", $_REQUEST['day'], $_REQUEST['subject'], $_REQUEST['body'], $_REQUEST['survey_id'], $_REQUEST['lesson_id']);
  $q->execute();
  
  // Return new body content
  echo json_encode(array("success" => true, "body" => showLessonManager($_REQUEST['lifestyle_id'])));
}

else if ($_REQUEST['action'] == "delete-lesson") {
  // Delete lesson
  $q = $db->prepare("DELETE FROM lessons WHERE id=?");
  $q->bind_param("i", $_REQUEST['lesson_id']);
  $q->execute();
  
  // Return new body content
  echo json_encode(array("success" => true, "body" => showLessonManager($_REQUEST['lifestyle_id'])));
}

else {
  showHeader();
  echo showLifestyleManager();
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
    <script type="text/javascript" src="js/lifestyles.js"></script>
  </body>
</html>
<?
}

function showLifestyleManager() {
  global $db;
  
  $q = "SELECT id, name FROM plans ORDER BY id";
  $r = $db->query($q);

  $body = '<form id="new">
              <input type="hidden" name="action" value="new" />
              <input type="hidden" name="plan_id" />
              <h1>Add new lifestyle:</h1>
              <p>Plan: <span id="plan_name"></span></p>
              <p>Order: <input type="text" name="ordering" /></p>
              <p>Name:<br /><input type="text" name="title" /></p>
              <p>Description:<br /><textarea name="description"></textarea></p>
              <p><button type="submit">Save</button><button type="reset">Cancel</button></p>
            </form>';
      
  $body .= '<form id="edit">
              <input type="hidden" name="action" value="edit" />
              <input type="hidden" name="lifestyle_id" />
              <h1>Edit lifestyle:</h1>
              <p>Order: <input type="text" name="ordering" /></p>
              <p>Name:<br /><input type="text" name="title" /></p>
              <p>Description:<br /><textarea name="description"></textarea></p>
              <p><button type="submit">Save</button><button type="reset">Cancel</button></p>
            </form>';
  
  $body .= '<form id="delete">
              <input type="hidden" name="action" value="delete" />
              <input type="hidden" name="lifestyle_id" />
              <p>Are you sure want to delete this lifestyle? All associated lessons will also be deleted.</p>
              <ul><li></li></ul>
              <p><button type="submit">Delete</button><button type="reset">Cancel</button></p>
            </form>';

  while ($plan = $r->fetch_assoc()) {
    $body .= '<div class="plan" data-plan-id="' . $plan['id'] . '" data-plan-name="' . $plan['name'] . '">
          <div class="left">
            <h1>'. $plan['name'] . '</h1>
          </div>
          <div class="right">
            <a class="add_new fancybox" href="#new">+</a>
          </div>
          <div class="table">
            <div class="row headers">
              <div class="cell">Order</div>
              <div class="cell">Lifestyle</div>
              <div class="cell">Description</div>
              <div class="cell">Lessons</div>
              <div class="cell"></div>
            </div>';

    $q2 = "SELECT * FROM lifestyles WHERE plan_id = {$plan['id']} ORDER BY ordering";
    $r2 = $db->query($q2);

    while ($lifestyle = $r2->fetch_assoc()) {
      $q3 = "SELECT * FROM lessons WHERE lifestyle_id = {$lifestyle['id']} ORDER BY day";
      $r3 = $db->query($q3);

      $body .= '<a class="row lifestyle" href="?action=show&id=' . $lifestyle['id'] . '" data-lifestyle="' . $lifestyle['id'] . '" data-ordering="' . $lifestyle['ordering'] . '" data-title="' . $lifestyle['title'] . '" data-description="' . $lifestyle['description'] . '">
              <div class="cell">' . $lifestyle['ordering'] . '</div>
              <div class="cell">' . $lifestyle['title'] . '</div>
              <div class="cell">' . $lifestyle['description'] . '</div>
              <div class="cell"><small>';

      while ($lesson = $r3->fetch_assoc()) {
        $body .= '<div>' . $lesson['day'] . ' - ' . $lesson['subject'] . '</div>';
      }

      $body .= '</small></div>
            <div class="cell"><small><span class="edit fancybox" href="#edit">Edit</span></small> <small><span class="delete fancybox" href="#delete">Delete</span></small></div>
            </a>';
    }
    $body .= '</div></div>';
  }
  return $body;
}

function showLessonManager($id) {
  global $db;
  
  $body =  '<form id="new">
              <input type="hidden" name="action" value="new-lesson" />
              <input type="hidden" name="lifestyle_id" value="' . $id . '" />
              <h1>Add new lesson:</h1>
              <p>Day: <input type="text" name="day" /></p>
              <p>Subject:<br /><input type="text" name="subject" /></p>
              <p>Body:<br /><textarea name="body"></textarea></p>
              <p>Survey:<br /><input type="text" name="survey_id" /></p>
              <p><button type="submit">Save</button><button type="reset">Cancel</button></p>
            </form>';
      
  $body .= '<form id="edit">
              <input type="hidden" name="action" value="edit-lesson" />
              <input type="hidden" name="lifestyle_id" value="' . $id . '" />
              <input type="hidden" name="lesson_id" />
              <h1>Edit lesson:</h1>
              <p>Day: <input type="text" name="day" /></p>
              <p>Subject:<br /><input type="text" name="subject" /></p>
              <p>Body:<br /><textarea name="body"></textarea></p>
              <p>Survey:<br /><input type="text" name="survey_id" /></p>
              <p><button type="submit">Save</button><button type="reset">Cancel</button></p>
            </form>';
  
  $body .= '<form id="delete">
              <input type="hidden" name="action" value="delete-lesson" />
              <input type="hidden" name="lifestyle_id" value="' . $id . '" />
              <input type="hidden" name="lesson_id" />
              <p>Are you sure want to delete this lesson?</p>
              <ul><li></li></ul>
              <p><button type="submit">Delete</button><button type="reset">Cancel</button></p>
            </form>';  
  
  // Find lifestyle
  $q = $db->prepare("SELECT title, description FROM lifestyles WHERE id=?");
  $q->bind_param("i", $id);
  $q->execute();
  $r = $q->get_result();
  $lifestyle = $r->fetch_array();
  
  $body .=  '<h1>' . $lifestyle['title'] . '</h1>
            <p>Description: ' . $lifestyle['description'] . '</p>
            <h2>Lessons</h2>';
            
  // Find associated lessons
  $q = $db->prepare("SELECT * FROM lessons WHERE lifestyle_id=? ORDER BY day");
  $q->bind_param("i", $id);
  $q->execute();
  $r = $q->get_result();

  while ($lesson = $r->fetch_assoc()) {
    $body .= '<div class="lesson clear" data-lesson="' . $lesson['id'] . '">
                <div>Day <span class="day">' . $lesson['day'] . '</span> - 
                  <span class="subject">' . $lesson['subject'] . '</span>
                  <span class="survey_id">' . $lesson['survey_id'] . '</span>
                  <small><span class="view">View</span></small> 
                  <small><span class="edit_lesson fancybox" href="#edit">Edit</span></small> 
                  <small><span class="delete_lesson fancybox" href="#delete">Delete</span></small>
                </div>
                <div class="body">' . $lesson['body'] . '</div>
              </div>';
  }

  $body .= '<p><a class="add_new_lesson fancybox" href="#new">Add New Lesson</a></p>';
  return $body;
}


?>
