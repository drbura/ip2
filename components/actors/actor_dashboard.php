<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Student Clearance Management System</title>
  <link rel="stylesheet" href="path/to/your/styles.css"> <!-- Make sure this path is correct -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    header, footer {
      background: #f1f1f1; /* Example background color */
      padding: 10px;
      text-align: center;
    }
    #content {
      padding: 20px;
      margin: 0 auto;
      min-height: 600px; /* Ensure there is enough space for content */
    }
    /* Ensure the footer is at the bottom of the page */
    footer {
      /* position: absolute; */
      bottom: 0;
      width: 100%;
    }
  </style>
</head>
<body>
  <?php include 'lib.php'; ?>
  <?php include 'header_actor.php'; ?>

  <div id="content">
  
  </div>

  <?php include 'footer.php'; ?>

  <script>
    $(document).ready(function() {
      var actor = '<?php echo $_GET["actor"]; ?>'; // Capture the actor parameter from the current URL

      // Load content based on actor role
      var initialPage;
      if (actor === 'registrar') {
        initialPage = 'cleared.php';
      } else {
        initialPage = 'ActorClearance.php?actor=' + actor;
      }

      // Load the initial page
      $('#content').load(initialPage, function(response, status, xhr) {
        if (status === "error") {
          $('#content').html("An error occurred: " + xhr.status + " " + xhr.statusText);
        } else {
          console.log(initialPage + " loaded successfully");
        }
      });

      // Handle clicks on links with data-page attribute
      $('a[data-page]').click(function(e) {
        e.preventDefault(); // Prevent the default link behavior
        var page = $(this).data('page');

        // Adjust URL based on actor role
        var pageUrl;
        if (actor === 'Registrar' && page === 'ActorClearance') {
          pageUrl = 'cleared.php';
        } else {
          pageUrl = page + '.php?actor=' + actor;
        }

        $('#content').load(pageUrl, function(response, status, xhr) {
          if (status === "error") {
            $('#content').html("An error occurred: " + xhr.status + " " + xhr.statusText);
          } else {
            console.log(pageUrl + " loaded successfully");
          }
        });
      });
    });
  </script>
</body>
</html>
