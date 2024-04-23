<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Dashboard </title>
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/loader.css">
    <link rel="stylesheet" href="../css/dashboard.css">
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

include './loader.html';
include './sidebar.html';

?>

  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Dashboard</span>
      </div>
      <div class="profile-details">
        <img src="../img/profile.jpg" alt="">
        <span class="admin_name">Zain Ali</span>
      </div> 
    </nav>
    
    <div class="container" id="takeNotesSection">
      <h2>Profile</h2>
      
      <?php

if (isset($_SESSION['loggedin'])) {
  // Access the user ID from the session
  $user_id = $_SESSION['user_id'];
  
  include_once('../php/connectdb.php');
  // Prepare a SQL query to fetch the data based on the provided id
    $sql = "SELECT * FROM admin WHERE id = $user_id";

    // Execute the query
    $result = $conn->query($sql);

    // Check if a record is found
    if($result->num_rows > 0) {
        // Fetch the data from the result
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $question = $row['question'];
        $answer = $row['answer'];

    } else {
        echo "No record found with the provided ID.";
    }
} else {
  // header('Location: login.php');
  // exit;
}
?>

<?php
// Include your database connection file
include_once('../php/connectdb.php');
$mesg="";
// Check if the 'author' field is present in the POST data

if ( isset($_POST["name"]) 
     || isset($_POST['email']) 
     || isset($_POST['question']) 
     || isset($_POST['answer']) 
    ) {
    // Retrieve the form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $question = $_POST["question"];
    $answer = $_POST["answer"];

    // Perform any necessary validation here

    // File upload handling
    $targetDir = "../img/";
    $fileName = basename($_FILES["cv"]["name"]);
    $sanitized_file_name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $fileName);
    $targetFilePath = $targetDir . $sanitized_file_name;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if file is selected
    if (!empty($_FILES["cv"]["name"])) {
        // Allow certain file formats
        $allowTypes = array('pdf', 'doc', 'docx');
        if (in_array($fileType, $allowTypes)) {
            // Upload file to the server
            if (move_uploaded_file($_FILES["cv"]["tmp_name"], $targetFilePath)) {
                // Prepare and execute the SQL UPDATE query
                $sql = "UPDATE admin SET name = '$name', question = '$question', answer='$answer', cv='$targetFilePath' WHERE email = '$email'";
                if ($conn->query($sql) === TRUE) {
                    $mesg = "Record updated successfully";
                } else {
                    $error = "Error updating record: " . $conn->error;
                }
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        } else {
            $error = "Sorry, only PDF, DOC, & DOCX files are allowed to upload.";
        }
    } else {
        // If no file is selected, update other fields without CV
        $sql = "UPDATE admin SET name = '$name', question = '$question', answer='$answer' WHERE email = '$email'";
        if ($conn->query($sql) === TRUE) {
            $mesg = "Record updated successfully";
        } else {
            $error = "Error updating record: " . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
}
?>

        
<form id="noteForm" class="form" method="post"  enctype="multipart/form-data">
          <span style="color:green;"> <?php echo $mesg ?> </span>
          <label for="author">Name:</label>
          <input type="text" id="author" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
          <span id="authorError" class="error"></span>
          
          <label for="title">Email:</label>
          <input type="email" id="title" name="email" readonly value="<?php echo isset($email) ? $email : ''; ?>" oninput="togglePurposeField()">
          <span id="titleError" class="error"></span>

          <label for="title">Cv:</label>
          <input type="file" id="title" name="cv"  oninput="togglePurposeField()">
          <span id="titleError" class="error"></span>

          <label for="title">Security Question:</label>
          <input type="text" id="title" name="question"  value="<?php echo isset($question) ? $question : ''; ?>" oninput="togglePurposeField()">
          <span id="titleError" class="error"></span>

          <label for="title">Answer:</label>
          <input type="text" id="title" name="answer"  value="<?php echo isset($answer) ? $answer : ''; ?>" oninput="togglePurposeField()">
          <span id="titleError" class="error"></span>
          
          <input type="submit" value="Update details">
      </form>
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

<script>
  window.onload = function() {
    togglePurposeField();
  };
</script>