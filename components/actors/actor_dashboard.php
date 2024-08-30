<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Student Clearance Management System</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <?php include 'lib.php'; ?>
  <?php include 'header_actor.php'; ?>

  <div id="content">
    <?php include 'ActorClearance.php'; // Default content ?>
  </div>

  <?php include 'footer.php'; ?>

  <script>
    $(document).ready(function() {
  $('a[data-page]').click(function(e) {
    e.preventDefault(); // Prevent the default link behavior
    var page = $(this).data('page');
    var actor = '<?php echo $_GET["actor"]; ?>'; // Capture the actor parameter from the current URL

    $('#content').load(page + '.php?actor=' + actor, function(response, status, xhr) {
      if (status == "error") {
        $('#content').html("An error occurred: " + xhr.status + " " + xhr.statusText);
      } else {
        console.log(page + ".php loaded successfully");
      }
    });
  });

  // Load ActorClearance.php with actor by default when the page loads
  var defaultActor = '<?php echo $_GET["actor"]; ?>';
  $('#content').load('ActorClearance.php?actor=' + defaultActor, function(response, status, xhr) {
    if (status == "error") {
      $('#content').html("An error occurred: " + xhr.status + " " + xhr.statusText);
    } else {
      console.log("ActorClearance.php loaded successfully");
    }
  });
});

    // $(document).ready(function() {
    //   $('a[data-page]').click(function(e) {
    //     e.preventDefault(); // Prevent the default link behavior
    //     var page = $(this).data('page');
    //     $('#content').load(page + '.php'); // Load the content dynamically
    //   });
    // });
  </script>
</body>
</html>
