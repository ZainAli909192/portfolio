<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Services </title>
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
        <span class="dashboard">Add service</span>
      </div>
      <div class="profile-details">
        <img src="../img/profile.jpg" alt="">
        <span class="admin_name">Zain Ali</span>
      </div> 
    </nav>

    <?php
    $mesg="";
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if pictures are uploaded
    if (!empty($_FILES['pictures']) && isset($_FILES['pictures']['tmp_name'])) {
        // Define error variables
        $nameErr = $dateErr = $descriptionErr = "";
        
        // Validate name/title
        if (empty($_POST["name"])) {
            $nameErr = "Name/Title is required";
        } else {
            $name = $_POST["name"];
        }

        // Validate date of completion
        if (empty($_POST["date"])) {
            $dateErr = "Date of completion is required";
        } else {
            $date = $_POST["date"];
        }

        // Validate description
        if (empty($_POST["description"])) {
            $descriptionErr = "Description is required";
        } else {
            $description = $_POST["description"];
        }

        // Check if there are no errors
        // if (empty($nameErr) && empty($dateErr) && empty($descriptionErr)) {
            // Connect to the database
include '../php/connectdb.php';
      
                // $projectId = $conn->insert_id;

                // Handle uploaded images
                foreach ($_FILES['pictures']['tmp_name'] as $key => $tmp_name) {
                    // Check if the file is uploaded successfully
                    if ($_FILES['pictures']['error'][$key] === UPLOAD_ERR_OK) {
                        $file_name = $_FILES['pictures']['name'][$key];
                        $file_tmp = $_FILES['pictures']['tmp_name'][$key];

                        // Sanitize the file name to remove spaces and special characters
                        $sanitized_file_name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $file_name);

                        // Move uploaded file to upload directory with sanitized file name
                        move_uploaded_file($file_tmp, "../img/services/" . $sanitized_file_name);

                        $maxIdQuery = "SELECT MAX(id) AS maxId FROM services";
    $maxIdResult = $conn->query($maxIdQuery);
    
    // Check if the query was successful
    if ($maxIdResult) {
        $maxIdRow = $maxIdResult->fetch_assoc();
        $maxId = $maxIdRow['maxId'];
        
        // Calculate the new ID
        $newId = $maxId + 1;
    }else{
        $newId = 1;
    }
                        // Move uploaded file to upload directory
                        // move_uploaded_file($file_tmp, "../img/services/" . $file_name);
                        $sql = "INSERT INTO services (id,name, description,path) VALUES ('$newId','$name', '$description', '../img/services/$sanitized_file_name')";

                        // Insert image details into the database
                        // $sql = "INSERT INTO pictures (project_id, img_name, path) VALUES ('$projectId', '$file_name', '../img/$file_name')";
                        $conn->query($sql);
                    }
                }
                $mesg= "Service uploaded successfully.";
            // } else {
            //     $mesg= "Error: ". "<br>";
            // }

            // Close database connection
        }
    } else {
        echo "No pictures uploaded.";
    }

?>



    

    <div class="container" id="takeNotesSection">
        <h2>Project</h2>
        <form id="noteForm" method="post"  enctype="multipart/form-data">
        <span class="success">
            <?php echo $mesg; ?>
      </span> 
        <label for="author">Name/Title:</label>
          <input type="text" id="author" name="name">
          <span id="authorError" class="error"></span>
      
          <!-- Add file input field for pictures -->
          <label id="purposeLabel3" for="pictures">Pictures:</label>
          <input type="file" id="pictures" name="pictures[]" accept="image/*" multiple onchange="previewImages(event)">
          <span id="purposeError" class="error"></span>
      
          <!-- Image preview -->
          <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 100px; max-height: 100px;">
          
          <label for="title">Description:</label>
          <textarea id="notes" name="description" rows="4" cols="50"></textarea>
          <span id="notesError" class="error"></span>
      
          <input type="submit" value="Upload project">
      </form>
      
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


</body>
</html>


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