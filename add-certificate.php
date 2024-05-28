<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>All Certificates list
  </title>
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
        <span class="dashboard">Add certificate</span>
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

        if (empty($_POST["date"])) {
            $dateErr = "Date is required";
        } else {
            $date = $_POST["date"];
        }
        if (empty($_POST["institute"])) {
            $nameErr = "institue is required";
        } else {
            $institute = $_POST["institute"];
        }

        // Check if there are no errors
        // if (empty($nameErr) && empty($dateErr) && empty($descriptionErr)) {
            // Connect to the database
include '../php/connectdb.php';
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

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
                        move_uploaded_file($file_tmp, "../img/certificates/" . $sanitized_file_name);

                        // Move uploaded file to upload directory 
                        // move_uploaded_file($file_tmp, "../img/services/" . $file_name);
                        $sql = "INSERT INTO certificates (name, date,institution,path) VALUES ('$name', '$date','$institute', '../img/certificates/$sanitized_file_name')";

                        // Insert image details into the database
                        // $sql = "INSERT INTO pictures (project_id, img_name, path) VALUES ('$projectId', '$file_name', '../img/$file_name')";
                        $conn->query($sql);
                        $mesg= "Certificate uploaded successfully.";
                        ?>
                        <script>
                // Wait for 1 minute (60000 milliseconds) and then redirect the page
                setTimeout(function() {
                    window.location.href = "certificates-list.php"; // Change 'new_page.php' to your desired URL
                }, 1500); // 60000 milliseconds = 1 minute
            </script>
            <?php
                    }
                }
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
      
          <label for="author">Date:</label>
          <input type="date" id="author" name="date">
          <span id="authorError" class="error"></span>
      
      
          <label for="author">Institute:</label>
          <input type="text" id="author" name="institute">
          <span id="authorError" class="error"></span>
      
          <!-- Add file input field for pictures -->
          <label id="purposeLabel3" for="pictures">Picture:</label>
          <input type="file" id="pictures" name="pictures[]" multiple onchange="previewImages(event)">
          <span id="purposeError" class="error"></span>
      
          <!-- Image preview -->
          <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 100px; max-height: 100px;">
          
      
          <input type="submit" value="Upload certificate">
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
