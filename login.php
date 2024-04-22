<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Login & Signup Form</title>
    <link rel="stylesheet" href="../css/login.css" />
    <link rel="stylesheet" href="../css/form.css" />
    <link rel="stylesheet" href="../css/loader.css" />
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">

  </head>
  <body>

<!-- Loader container -->
<div class="loader-container" id="loaderContainer">
  <!-- Loader image -->
  <img src="../img/loader.svg" alt="Loader" class="loader-img">
</div>  


<script>
  function showloader(){
// Get the loader container element
var loaderContainer = document.getElementById('loaderContainer');
    // Display the loader container
    loaderContainer.style.display = 'block';

    // Hide the loader after 2 seconds
    setTimeout(function() {
      // Hide the loader container
      loaderContainer.style.display = 'none';
    }, 1000);
  
  } ;
  window.onload=showloader();
  </script>
  <?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['loggedin'])) {
    // Redirect the user to the login page
    header('Location: dashboard.php');
    exit;
}
?>
    <?php


$error="";
// Check if the email is submitted via POST
if (isset($_POST['remail'])) {
    // Get the submitted email
    $email = $_POST["remail"];
try{
  
    require '../php/connectdb.php';

    // Prepare a SQL query to retrieve the ID of the email from the database
    $sql = "SELECT id FROM admin WHERE email = '$email'";
    $result = $conn->query($sql);

    // Check if the email exists in the database
    if ($result->num_rows > 0) {
        // Fetch the ID from the result
        $row = $result->fetch_assoc();
        $id = $row["id"];

        // Close the database connection
        $conn->close();

        // Redirect the user to the password reset page with the ID as a query parameter
        header("Location: answer-question.php?id=$id");
        exit;
    } else {
        // If email does not exist, display an error message
      $error="Invalid Email";
      }
    // Close the database connection
    $conn->close();
}
catch (Exception $e) {
  
}
}
?>

<!-- login code  -->
<?php
      $error="";
// Check if the form is submitted via POST
if (isset($_POST["email"]) && isset($_POST["password"])) {
    // Retrieve the submitted email and password
    $email = $_POST["email"];
    $pass = trim($_POST['password']);
    
    // Include your database connection file
    include_once('../php/connectdb.php');
    
    // Hash the password using md5 for comparison with the stored hashed password
    $hashedPassword = md5($pass);
    
    // Query to check if the email and hashed password match any record in the database
    $sql = "SELECT * FROM admin WHERE email = '$email' AND password = '$hashedPassword'";
    $result = $conn->query($sql);
    
    // Execute the query 
    
    // Check if a record is found
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $id = $row['id'];
      // User authenticated successfully, redirect to dashboard or any other page with the id
      session_start();
      
      // Assuming successful login
      $_SESSION['user_id'] = $id;
      $_SESSION['loggedin'] = true;
      // $session_expiration = 86400; // 1 day = 24 hours * 60 minutes * 60 seconds
      $session_expiration = 5; // 1 day = 24 hours * 60 minutes * 60 seconds
      session_set_cookie_params($session_expiration);

      // Redirect the user to the message.php page
      header("Location: dashboard.php?id=$id");
      exit;
    } else {
        // User authentication failed, display error message
        $error = "Invalid email or password. " . mysqli_error($conn);
      }

    // Close the database connection
    $conn->close();
}
?>

    <section class="wrapper">
      <div class="form  login">
        <header>Password reset</header>
        <form action="" method="post">
          <input type="text" placeholder="Email address" required name="remail" />
          <span id="purposeError" class="error"> 
        <php echo $error ?>    
        </span>
          <input type="submit" value="Submit" />
        </form>
      </div>

      <div class="form signup">
        <header>Login</header>
        <form  method="post">
          <input type="email" placeholder="Email address" name="email" required />
          <input type="password" placeholder="Password" name="password" required />
         <span>
          <?php echo $error; ?>
         </span>
          <input type="submit" value="Login" />
        </form>
      </div>


      <script>
        const wrapper = document.querySelector(".wrapper"),
          signupHeader = document.querySelector(".signup header"),
          loginHeader = document.querySelector(".login header");

        loginHeader.addEventListener("click", () => {
          wrapper.classList.add("active");
        });
        signupHeader.addEventListener("click", () => {
          wrapper.classList.remove("active");
        });
      </script>


    </section>
  </body>
</html>