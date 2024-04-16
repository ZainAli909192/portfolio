<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Service  </title>
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
// Include your database connection file
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
        <span class="dashboard">Dashboard</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search...">
        <i class='bx bx-search' ></i>
      </div>
      <div class="profile-details">
        <img src="../img/profile.jpg" alt="">
        <span class="admin_name">Zain Ali</span>
        <i class='bx bx-chevron-down' ></i>
      </div> 
    </nav>

    <?php
// Include your database connection file
include_once('../php/connectdb.php');

// Check if project ID is provided in the URL
if(isset($_GET['service_id'])) {
    $service_id = $_GET['service_id'];
    
    // Query to fetch project details by project ID
    $sql = "SELECT * FROM services WHERE service_id = $service_id";
    $result = $conn->query($sql);
 
    // Check if the query returned any results
    if ($result->num_rows > 0) {
        // Fetch project details
        $row = $result->fetch_assoc();

        // Populate form fields with project details
        $name = $row['name'];
        $path = $row['path']; // Assuming date is stored in a format compatible with <input type="date">
    } else {
        echo "No project found with the provided ID.";
    }
} else {
    echo "Project ID is not provided.";
}
?>

<?php


// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
  // Redirect the user to the login page
  header('Location: login.php');
  exit;
}

// Check if the form is submitted
// Include your database connection file
include_once('../php/connectdb.php');

$image_path="";
// Check if the form is submitted
if(isset($_POST['update_project'])) {
   
    // Retrieve the form data
    $name = $_POST['name'];
    // $path = $_POST['path'];
    $service_id = $_GET['service_id']; // Assuming project_id is provided in the URL
    
      if(isset($_FILES['pictures']) && !empty($_FILES['pictures']['name'][0])) {
            // Loop through each uploaded file
            foreach($_FILES['pictures']['tmp_name'] as $key => $tmp_name) {
                // File details
                $file_name = $_FILES['pictures']['name'][$key];
                $file_size = $_FILES['pictures']['size'][$key];
                $file_tmp = $_FILES['pictures']['tmp_name'][$key];
                $file_type = $_FILES['pictures']['type'][$key];
                
                // File upload directory (update as per your requirement)
                $upload_directory = "../img/services/";
               
                $trimmed_directory = trim($file_name);
                // Move uploaded file to destination directory
                if(move_uploaded_file($file_tmp, $upload_directory . $trimmed_directory)) {
                    // Insert or update image details in the pictures table
                    $image_path = $upload_directory . $trimmed_directory;
                        // Update project details in the projects table
                        $update_service_sql = "UPDATE services SET name='$name', path='$image_path' WHERE service_id = $service_id";
                // Execute the insert query for image
                    if($conn->query($update_service_sql) === FALSE) {
                        echo "Error inserting image: " . $conn->error;
                    }
                } else {
                    echo "Error uploading file.";
                }
            }
        
        echo "service details updated successfully.";
        // Redirect to a success page or refresh the page
        // header("Location: success.php");
        // exit();
    } 
}




?>


<div class="container sp" id="takeNotesSection">
    <!-- <h2>Project</h2> -->
    
    <form id="noteForm" method="post" enctype="multipart/form-data">
        <label for="author">Name/Title:</label>
        <input type="text" id="author" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
        <span id="authorError" class="error"></span>
        
        
        <!-- Add file input field for pictures -->
        <label id="purposeLabel3" for="pictures">Pictures:</label>
        <span style="display:flex;">
        <input type="file" id="pictures" name="pictures[]" accept="image/*" multiple onchange="previewImages(event)">
        <span id="purposeError" class="error"></span></span>

        
          <!-- Image preview -->
          <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 100px; max-height: 100px;">
        <br>  

        <input type="submit" name="update_project" value="Update service">
    </form>
                 
</div>


  </section>


</body>
</html>
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