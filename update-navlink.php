<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Navlink </title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/form.css">

    <script src="../js/form.js"></script>
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" href="../img/favicon.ico" type="image/x-icon">

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
include './loader.html';
include './sidebar.html';

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
    <?php
// Establish database connection
include '../php/connectdb.php';

// Retrieve the ID from the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare SQL statement to fetch data from the database
    $sql = "SELECT * FROM navlinks WHERE id=$id";
    
    // Execute SQL statement
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the data from the result
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $status = $row['status'];
    } else {
        echo "No record found with the provided ID.";
    }
} else {
    echo "ID parameter is missing in the URL.";
}

// Close database connection
$conn->close();
?>




    <div class="container" id="takeNotesSection">
        <h2>Project</h2>
        <!-- <form id="noteForm" method="post"  enctype="multipart/form-data">
          <label for="author">Name/Title:</label>
          <input type="text" id="author" name="name">
          <span id="authorError" class="error"></span>
          
          <label for="author">Status:</label>
          <select id="status"  name="status">
            <option value="show" >Show</option>
            <option value="hide" selected >Hide</option>
        </select>
         
          <input type="submit" value="Add Navbar">
      </form>  -->

      <form id="noteForm" method="post"  enctype="multipart/form-data">
    <label for="author">Name/Title:</label>
    <input type="text" id="author" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
    <span id="authorError" class="error"></span>
    
    <label for="author">Status:</label>
    <select id="status" name="status">
        <option value="show" <?php echo ($status == 'show') ? 'selected' : ''; ?>>Show</option>
        <option value="hide" <?php echo ($status == 'hide') ? 'selected' : ''; ?>>Hide</option>
    </select>
     
    <input type="submit" value="Update Navbar">
</form>
</div>  
      
<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (!empty($_POST["name"]) && !empty($_POST["status"])) {
        // Get the form data
        $name = $_POST["name"];
        $status = $_POST["status"];

        // Perform any necessary validation
        
        // Establish database connection
     include '../php/connectdb.php';
        
        // Retrieve the ID from the URL
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            
            // Prepare SQL statement to update data in the database
            $sql = "UPDATE navlinks SET name='$name', status='$status' WHERE id=$id";
            
            // Execute SQL statement
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully"; ?>
                <script>
    // Wait for 1 minute (60000 milliseconds) and then redirect the page
    setTimeout(function() {
        window.location.href = "navlinks.php"; // Change 'new_page.php' to your desired URL
    }, 1000); // 60000 milliseconds = 1 minute
</script>
<?php
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "ID parameter is missing in the URL.";
        }
        
        // Close database connection
        $conn->close();
    } else {
        echo "Name/Title and Status fields are required.";
    }
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


