<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Project </title>
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
        <span class="dashboard">Update project</span>
      </div>
      <div class="profile-details">
        <img src="../img/profile.jpg" alt="">
        <span class="admin_name">Zain Ali</span>
      </div> 
    </nav>

    <?php
// Include your database connection file
include_once('../php/connectdb.php');

// Check if project ID is provided in the URL
if(isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    
    // Query to fetch project details by project ID
    $sql = "SELECT * FROM projects WHERE project_id = $project_id";
    $result = $conn->query($sql);
 
    // Check if the query returned any results
    if ($result->num_rows > 0) {
        // Fetch project details
        $row = $result->fetch_assoc();

        // Populate form fields with project details
        $name = $row['name'];
        $date = $row['date']; // Assuming date is stored in a format compatible with <input type="date">
        $description = $row['description'];
        $url = $row['project_url'];
    } else {
        echo "No project found with the provided ID.";
    }
} else {
    echo "Project ID is not provided.";
}
?>

<?php


session_start();

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
    $date = $_POST['date'];
    $description = $_POST['description'];
    $project_url = $_POST['url'];
    $project_id = $_GET['project_id']; // Assuming project_id is provided in the URL
    
    // Update project details in the projects table
    $update_project_sql = "UPDATE projects SET name='$name', date='$date', description='$description', project_url='$project_url' WHERE project_id = $project_id";

    // Execute the update query for project details
    if ($conn->query($update_project_sql) === TRUE) {
        // Handle image uploads if new images are selected
        if(isset($_FILES['pictures']) && !empty($_FILES['pictures']['name'][0])) {
            // Loop through each uploaded file
            foreach($_FILES['pictures']['tmp_name'] as $key => $tmp_name) {
                // File details
                $file_name = $_FILES['pictures']['name'][$key];
                $file_size = $_FILES['pictures']['size'][$key];
                $file_tmp = $_FILES['pictures']['tmp_name'][$key];
                $file_type = $_FILES['pictures']['type'][$key];
                
                // File upload directory (update as per your requirement)
                $upload_directory = "../img/";
                
                $sanitized_file_name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $file_name);

                // Move uploaded file to destination directory
                if(move_uploaded_file($file_tmp, $upload_directory . $sanitized_file_name)) {
                    // Insert or update image details in the pictures table
                    $image_path = $upload_directory . $sanitized_file_name;
                    $insert_image_sql = "INSERT INTO pictures ( project_id, img_name ,path) VALUES ('$project_id', '$file_name', '$image_path')";
                    
                    // Execute the insert query for image
                    if($conn->query($insert_image_sql) === FALSE) {
                        echo "Error inserting image: " . $conn->error;
                    }
                } else {
                    echo "Error uploading file.";
                }
            }
        }
        echo "Project details updated successfully.";
        // Redirect to a success page or refresh the page
        // header("Location: success.php");
        // exit();
    } else {
        echo "Error updating project details: " . $conn->error;
    }
}




?>


<div class="container sp" id="takeNotesSection">
    <!-- <h2>Project</h2> -->
    
    <form id="noteForm" style="margin-top:3.3%;" method="post" enctype="multipart/form-data">
        <label for="author">Name/Title:</label>
        <input type="text" id="author" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
        <span id="authorError" class="error"></span>

        <label id="purposeLabel3" for="purpose">Date of completion:</label>
        <input type="date" id="purpose3" name="date" value="<?php echo isset($date) ? $date : ''; ?>">
        <span id="purposeError" class="error"></span>

        <label id="purposeLabel3" for="purpose">Url (optional):</label>
        <input type="text" id="purpose3" name="url" value="<?php echo isset($url) ? $url : ''; ?>">
        <span id="purposeError" class="error"></span>

        <!-- Add file input field for pictures -->
        <label id="purposeLabel3" for="pictures">Pictures:</label>
        <span style="display:flex;">
        <input type="file" id="pictures" name="pictures[]" accept="image/*" multiple onchange="previewImages(event)">
        <span id="purposeError" class="error"></span></span>

    <!-- Image preview -->
    <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 100px; max-height: 100px;">
        

        <label for="title">Description:</label>
        <textarea id="notes" name="description" rows="4" cols="50"><?php echo isset($description) ? $description : ''; ?></textarea>
        <span id="notesError" class="error"></span>

        <input type="submit" name="update_project" value="Update project">
    </form>
    
    <div id="imagePreviews">
       
    </div>                     
</div>


  </section>


</body>
</html>
<script>
    // Function to handle file input change event
   
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