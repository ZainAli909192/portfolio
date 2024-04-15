<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Navbar </title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">

    <script src="../js/form.js"></script>
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
<?php 

session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
  // Redirect the user to the login page
  header('Location: login.php');
  exit;
}

include './sidebar.html';
include './loader.html';

?>

<section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Add navlink</span>
      </div>
      <div class="profile-details">
        <img src="../img/profile.jpg" alt="">
        <span class="admin_name">Zain Ali</span>
      </div> 
    </nav>


    <div class="container" id="takeNotesSection">
        <h2>Project</h2>
        <form id="noteForm" method="post"  enctype="multipart/form-data">
          <label for="author">Name/Title:</label>
          <input type="text" id="author" name="name">
          <span id="authorError" class="error"></span>
          
          <label for="author">Status:</label>
          <select id="status"  name="status">
            <option value="show" >Show</option>
            <option value="hide" selected >Hide</option>
        </select>
         
          <input type="submit" value="Add Navbar">
      </form> 
</div>  
      
      <?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables to store form data
    $name = $status = "";

    // Validate and sanitize form input
    if (!empty($_POST["name"])) {
        $name = htmlspecialchars($_POST["name"]);
    } else {
        // Handle validation error
        echo "Name/Title is required.";
        // You can add further error handling or redirect back to the form
        exit; // Stop further execution
    }

    // Validate and sanitize status input
    if (!empty($_POST["status"])) {
        $status = htmlspecialchars($_POST["status"]);
    } else {
        // Handle validation error
        echo "Status is required.";
        // You can add further error handling or redirect back to the form
        exit; // Stop further execution
    }

    // Database connection parameters
  include '../php/connectdb.php';
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Construct SQL query to insert data into navlinks table
    $sql = "INSERT INTO navlinks (name, status) VALUES ('$name', '$status')";

    // Execute SQL query
    if ($conn->query($sql) === TRUE) {
        echo "New record inserted successfully";
        ?>
            <script>
    // Wait for 1 minute (60000 milliseconds) and then redirect the page
    setTimeout(function() {
        window.location.href = "navlinks.php"; // Change 'new_page.php' to your desired URL
    }, 1000); // 60000 milliseconds = 1 minute
</script>
<?php
    
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>



      <script>
          // Function to preview the selected image
          function previewImages(event) {
              var imagePreview = document.getElementById('imagePreview');
              var file = event.target.files[0];
              var reader = new FileReader();
      
              reader.onload = function(e) {
                  imagePreview.src = e.target.result;
                  imagePreview.style.display = 'block';
              }
      
              reader.readAsDataURL(file);
          }
      </script>
      
      </div>

  </section>

  <script>
    let sidebar = document.querySelector(".sidebar");
 let sidebarBtn = document.querySelector(".sidebarBtn");
 sidebarBtn.onclick = function() {
   sidebar.classList.toggle("active");
   if(sidebar.classList.contains("active")){
   sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
 }else
   sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
 }
  </script>
</body>
</html>


