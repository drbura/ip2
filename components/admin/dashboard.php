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
  <?php include 'header.php'; ?>

  <div id="content">
    <?php include 'main.php'; // Default content ?>
  </div>

  <?php include 'footer.php'; ?>

  <script>
    $(document).ready(function() {
      // Function to load content dynamically
      function loadPage(page) {
        $('#content').load(page + '.php', function(response, status, xhr) {
          if (status == "error") {
            $('#content').html("An error occurred: " + xhr.status + " " + xhr.statusText);
          } else {
            console.log(page + ".php loaded successfully");
          }
        });
      }

      // Attach click event handler to navigation links
      $('a[data-page]').click(function(e) {
        e.preventDefault(); // Prevent default link behavior
        var page = $(this).data('page'); // Get page to load
        loadPage(page);
      });

      // Load default content
      var defaultPage = 'main'; // Default page to load
      loadPage(defaultPage);
    });
  </script>
</body>
</html>
